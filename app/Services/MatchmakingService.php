<?php

namespace App\Services;

class MatchmakingService
{
    /**
     * Calculate love compatibility score in a deterministic and commutative manner.
     *
     * @param string $name1
     * @param string $date1 Format: Y-m-d
     * @param string $name2
     * @param string $date2 Format: Y-m-d
     * @return array
     */
    public function calculateMatch(string $name1, string $date1, string $name2, string $date2): array
    {
        // 1. String Normalization (trim & lowercase)
        $normName1 = strtolower(trim($name1));
        $normDate1 = trim($date1);

        $normName2 = strtolower(trim($name2));
        $normDate2 = trim($date2);

        // 2. Format individual person tokens
        $personA = $normName1 . '|' . $normDate1;
        $personB = $normName2 . '|' . $normDate2;

        // 3. Commutative sorting: sort lexicographically so (A+B) equals (B+A)
        $pair = [$personA, $personB];
        sort($pair, SORT_STRING);
        $canonicalInput = implode('::', $pair);

        // 4. SHA-256 Hash Generation
        $hash = hash('sha256', $canonicalInput);

        // 5. Deterministic Score (Range: 40% - 99%)
        $hexSegment = substr($hash, 0, 8);
        $numericVal = hexdec($hexSegment);
        $score = 40 + ($numericVal % 60);

        // 6. Sub-scores for breakdown analysis (deterministik dari segmen hash lain)
        $commScore = 40 + (hexdec(substr($hash, 8, 8)) % 60);
        $emoScore  = 40 + (hexdec(substr($hash, 16, 8)) % 60);
        $valScore  = 40 + (hexdec(substr($hash, 24, 8)) % 60);
        $chemScore = 40 + (hexdec(substr($hash, 32, 8)) % 60);

        // 7. Determine Category, Narrative & Aesthetics
        if ($score >= 85) {
            $category = 'Sangat Cocok';
            $badgeColor = 'emerald';
            $narrative = 'Hubungan kalian memiliki fondasi emosional dan chemistry yang sangat kuat! Komunikasi mengalir secara alami, dan visi masa depan kalian saling melengkapi secara penuh keharmonisan.';
            $advice = 'Pertahankan keterbukaan dan terus apresiasi momen-momen kecil bersama. Pasangan seperti ini sangat langka dan berharga!';
        } elseif ($score >= 65) {
            $category = 'Cukup Cocok';
            $badgeColor = 'amber';
            $narrative = 'Pasangan yang serasi dengan potensi kebahagiaan yang sangat tinggi. Terus rawat komunikasi terbuka dan saling mengerti, karena dinamika hubungan kalian sangat menjanjikan.';
            $advice = 'Fokus pada peningkatan kualitas waktu bersama (quality time) serta saling mendengarkan saat menghadapi perbedaan pendapat.';
        } else {
            $category = 'Perlu Penyesuaian';
            $badgeColor = 'rose';
            $narrative = 'Setiap hubungan yang luar biasa membutuhkan usaha, empati, dan kompromi. Perbedaan sudut pandang antara kalian justru dapat menjadi peluang emas untuk saling melengkapi dan tumbuh bersama.';
            $advice = 'Tingkatkan empati dan kesabaran. Komunikasi secara jujur tanpa menghakimi akan mempererat ikatan kalian secara signifikan.';
        }

        return [
            'person1_name' => trim($name1),
            'person1_birthdate' => trim($date1),
            'person2_name' => trim($name2),
            'person2_birthdate' => trim($date2),
            'score' => $score,
            'category' => $category,
            'badge_color' => $badgeColor,
            'narrative' => $narrative,
            'advice' => $advice,
            'breakdown' => [
                'communication' => $commScore,
                'emotional' => $emoScore,
                'values' => $valScore,
                'chemistry' => $chemScore,
            ],
            'calculated_at' => now()->translatedFormat('d F Y, H:i') . ' WIB',
        ];
    }
}
