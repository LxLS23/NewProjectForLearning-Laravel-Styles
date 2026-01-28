<?php

namespace App\Services;

use App\Models\Faq;
use Illuminate\Support\Facades\Cache;

class ChatService
{
    private function normalize(String $text): string
    {
        $text = mb_strtolower(trim($text), 'UTF-8');
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text);
        $text = str_replace(
            ['á', 'é', 'í', 'ó', 'ú'],
            ['a', 'e', 'i', 'o', 'u'],
            $text
        );
        return $text;
    }

    private array $stopWords = [
        'que',
        'como',
        'cual',
        'cuales',
        'donde',
        'cuando',
        'por',
        'para',
        'el',
        'la',
        'los',
        'las',
        'un',
        'una',
        'unos',
        'unas',
        'de',
        'del',
        'al',
        'en',
        'y',
        'o',
        'es',
        'son',
        'tienen',
        'tengo',
        'me',
        'mi',
        'tu',
        'su',
        'se',
        'a'
    ];

    private function filterWords(array $words): array
    {
        return array_values(array_filter($words, function ($word) {
            return $word !== '' && !in_array($word, $this->stopWords, true);
        }));
    }

    public function getResponse(String $message): string
    {
        //Normalizar mensaje 
        $message = $this->normalize($message);
        $messageWords = $this->filterWords(explode(' ', $message));

        //FAQs en Cache
        $faqs = Cache::remember('faqs_activas', 3600, function () {
            return Faq::where('activo', true)->get();
        });

        $bestScore = 0;
        $bestAnswer = null;

        foreach ($faqs as $faq) {
            $score = 0;

            //Evaluar Pregunta
            $normalizedQuestion = $this->normalize($faq->pregunta);
            $questionWords = $this->filterWords(explode(' ', $normalizedQuestion));
            // Coincidencia directa con la pregunta
            if (str_contains($message, $normalizedQuestion)) {
                $score += 3;
            }

            // Coincidencia palabra por palabra (pregunta)
            foreach ($questionWords as $qWord) {
                foreach ($messageWords as $mWord) {
                    if ($qWord === $mWord) {
                        $score += 2;
                    }
                }
            }

            $keywords = explode(',', $faq->palabras_clave);

            foreach ($keywords as $keyword) {
                $keyword = $this->normalize($keyword);

                if (str_contains($message, $keyword)) {
                    $score += 2;
                }

                // Coincidencia palabra por palabra
                foreach ($messageWords as $word) {
                    if ($word === $keyword) {
                        $score += 1;
                    }
                }
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestAnswer = $faq->respuesta;
            }
        }

        if ($bestScore >= 2) {
            return $bestAnswer;
        }

        return 'No encontre información relacionada. ¿Puedes reformular tu pregunta?';
    }
}
