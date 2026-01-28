<?php

namespace App\Services;

use App\Models\Faq;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ChatService
{
    private const CACHE_TTL = 3600;
    private const MIN_SCORE_THRESHOLD = 2;

    //Pesos para scoring
    private const SCORE_EXACT_MATCH = 5;
    private const SCORE_WORD_MATCH_QUESTION = 2;
    private const SCORE_KEYWORD_CONTAINS = 2;
    private const SCORE_KEYWORD_EXACT = 1;

    private array $stopWords = [
        'que', 'como', 'cual', 'cuales', 'donde', 'cuando', 'por', 'para',
        'el', 'la', 'los', 'las', 'un', 'una', 'unos', 'unas', 'de', 'del',
        'al', 'en', 'y', 'o', 'es', 'son', 'tienen', 'tengo', 'me', 'mi',
        'tu', 'su', 'se', 'a', 'si', 'no', 'hay', 'esta', 'esto', 'ese'
    ];

    //Normaliza texto removiendo acentos, caracteres especiales convirtiendo a minusculas
    private function normalize(string $text): string
    {
        $text = mb_strtolower(trim($text), 'UTF-8');

        // Remplazar acentos
        $replacements = [
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
        'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
        'ä' => 'a', 'ë' => 'e', 'ï' => 'i', 'ö' => 'o', 'ü' => 'u',
        'ñ' => 'n',
        'ç' => 'c', 
        ];
        $text = strtr($text, $replacements);

        // Remover caracteres especiales pero mantener espacios
        $text = preg_replace('/[^a-z0-9\s]/i', ' ', $text);

        // Normalizar espacios múltiples
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }

    //Filtrar palabras vacías y stop words
    private function filterWords(array $words): array
    {
        return array_values(array_filter(
            $words,
            fn($word) =>
            strlen($word) > 1 && !in_array($word, $this->stopWords, true)
        ));
    }

    //Obtiene las FAQs desde caché
    private function getFaqs(): Collection
    {
        return Cache::remember(
            'faqs_activas',
            self::CACHE_TTL,
            fn() =>
            Faq::where('activo', true)
                ->select(['id', 'pregunta', 'respuesta', 'palabras_clave'])
                ->get()
        );
    }


    //Calcula el score de coincidencia entre el mensaje y una FAQ
    private function calculateScore(string $message, array $messageWords, Faq $faq): int
    {
        $score = 0;

        // Normalizar pregunta
        $normalizedQuestion = $this->normalize($faq->pregunta);

        // 1. Coincidencia exacta de la pregunta completa
        if ($message === $normalizedQuestion) {
            return self::SCORE_EXACT_MATCH * 2; // Máxima prioridad
        }

        // 2. Coincidencia parcial de la pregunta
        if (str_contains($message, $normalizedQuestion)) {
            $score += self::SCORE_EXACT_MATCH;
        }
            

        // 3. Coincidencia palabra por palabra (pregunta)
        $questionWords = $this->filterWords(explode(' ', $normalizedQuestion));
        $commonWords = array_intersect($questionWords, $messageWords);
        $score += count($commonWords) * self::SCORE_WORD_MATCH_QUESTION;

        // 4. Evaluar keywords
        if (!empty($faq->palabras_clave)) {
            $keywords = array_map(
                fn($k) => $this->normalize(trim($k)),
                explode(',', $faq->palabras_clave)
            );

            foreach ($keywords as $keyword) {
                if (empty($keyword)) continue;

                // Coincidencia completa de keyword en mensaje
                if (str_contains($message, $keyword)) {
                    $score += self::SCORE_KEYWORD_CONTAINS;
                }

                // Coincidencia palabra exacta
                if (in_array($keyword, $messageWords, true)) {
                    $score += self::SCORE_KEYWORD_EXACT;
                }
            }
        }

        return $score;
    }

    public function getResponse(String $message): string
    {
        if (empty(trim($message))) {
            return 'Por favor, escribe tu pregunta.';
        }

        //Normalizar mensaje 
        $normalizedMessage = $this->normalize($message);
        $messageWords = $this->filterWords(explode(' ', $normalizedMessage));

        // Si después de filtrar no quedan palabras significativas
        if (empty($messageWords)) {
            return 'No entendí tu pregunta. ¿Puedes ser más específico?';
        }

        // Obtener FAQs
        $faqs = $this->getFaqs()->map(function ($faq) {
            $faq->normalized_question = $this->normalize($faq->pregunta);
            $faq->question_words = $this->filterWords(
                explode(' ', $faq->normalized_question)
            );
            return $faq;
        });

        if ($faqs->isEmpty()) {
            return 'El sistema está siendo actualizado. Por favor, intenta más tarde.';
        }

        $bestScore = 0;
        $bestFaq = null;

        foreach ($faqs as $faq) {
            $score = $this->calculateScore($normalizedMessage, $messageWords, $faq);

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestFaq = $faq;
            }
        }

        // Retornar respuesta si supera el umbral
        if ($bestScore >= self::MIN_SCORE_THRESHOLD && $bestFaq) {
            return $bestFaq->respuesta;
        }
        return 'No encontré información relacionada con tu pregunta. ¿Podrías reformularla o ser más específico?';
    }

    //Limpia el caché de FAQs (útil cuando se actualizan)
    public function clearCache(): void
    {
        Cache::forget('faqs_activas');
    }
}
