<?php

namespace App\Services;

use App\Models\Faq;
use Illuminate\Support\Facades\Cache;

class ChatService
{

    private function normalize(String $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text);
        $text = str_replace(
            ['á', 'é', 'í', 'ó', 'ú'],
            ['a', 'e', 'i', 'o', 'u'],
            $text
        );
        return $text;
    }


    public function getResponse(String $message): string
    {
        $message = $this->normalize($message);

        // Separar mensaje en palabras
        $messageWords = explode(' ', $message);

        $faqs = Cache::remember('faqs_activas', 3600, function () {
            return Faq::where('activo', true)->get();
        });

        $bestScore = 0;
        $bestAnswer = null;

        foreach ($faqs as $faq) {
            $keywords = explode(',', $faq->palabras_clave);
            $score = 0;

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
