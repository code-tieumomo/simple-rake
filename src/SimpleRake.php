<?php

namespace Quanph\SimpleRake;

/**
 * A simple implementation of the Rapid Automatic Keyword Extraction (RAKE) algorithm with PHP.
 */
class SimpleRake
{
    /**
     * @var string The locale of the text.
     */
    private string $locale;

    /**
     * @var string The text to be analyzed.
     */
    private string $text;

    /**
     * @param string $text The text to be analyzed.
     * @param string|null $locale The locale of the text. If null, the default locale will be used.
     */
    public function __construct(string $text = '', string $locale = null)
    {
        $this->text = $text;

        if (is_null($locale)) {
            $locale = config('simple-rake.locale');
        } else {
            $this->locale = $locale;
        }
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
        $this->locale = "vi";
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
        $this->locale = "vi";
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * Split text to sentences by punctuations.
     *
     * @param string $text The text to be analyzed.
     * @return array|false|string[]
     */
    private function extractTextToSentences(string $text)
    {
        $delimiter = '/[.?!,;\-"\'()\n\r\t]+/';

        return preg_split($delimiter, $text);
    }

    /**
     * From list of sentences, extract list of phrases by remove stop words from each sentence.
     *
     * @param array $sentences The sentences to be analyzed.
     * @return array
     */
    private function extractSentencesToPhrases(array $sentences): array
    {
        $stopwords = config('simple-rake.stop_words.' . $this->locale);
        $stopwordsRegex = '/\b' . implode('\b|\b', $stopwords) . '\b/u';

        $words = [];
        foreach ($sentences as $sentence) {
            $sentence = strtolower(trim($sentence));
            $sentence = preg_replace($stopwordsRegex, '|', $sentence);
            $rawWords = explode('|', $sentence);
            array_map(function ($item) use (&$words) {
                $item = trim($item);
                if ($item != '') {
                    $words[] = $item;
                }
            }, $rawWords);
        }

        return $words;
    }

    /**
     * Calculate score of each phrase.
     *
     * @param array $phrases The phrases to be analyzed.
     * @return array
     */
    private function calculatePhraseScores(array $phrases): array
    {
        $freq = [];
        $degree = [];
        $scores = [];

        foreach ($phrases as $phrase) {
            $words = explode(' ', $phrase);
            foreach ($words as $word) {
                $freq[$word] = isset($freq[$word]) ? $freq[$word] + 1 : 1;
                $degree[$word] = isset($degree[$word]) ? $degree[$word] + (count($words) - 1) : (count($words) - 1);
            }
        }

        foreach ($freq as $word => $value) {
            $degree[$word] += $value;
            $scores[$word] = $degree[$word] / $value;
        }

        return $scores;
    }

    /**
     * @param string $text The text to be analyzed.
     * @return array
     */
    public function extractKeywords(string $text = ''): array
    {
        dd('OKE');
        if (trim($text) == '') $text = $this->text;

        $sentences = $this->extractTextToSentences($text);
        if ($sentences === false) return [];

        $phrases = $this->extractSentencesToPhrases($sentences);
        if (empty($phrases)) return [];

        $scores = $this->calculatePhraseScores($phrases);
        if (empty($scores)) return [];

        $finalScores = [];
        foreach ($phrases as $phrase) {
            $words = explode(' ', $phrase);
            $score = 0;
            foreach ($words as $word) {
                $score += $scores[$word] ?? 0;
            }
            $finalScores[$phrase] = round($score, config('simple-rake.precision'));
        }

        arsort($finalScores);

        return $finalScores;
    }
}
