<?php

class KarvonenCalculator
{
    public static function calculateZones(
        int $fcm,
        int $restingHR
    ): array {

        $reserve = $fcm - $restingHR;

        return [
            "Z1" => [
                round(($reserve * 0.50) + $restingHR),
                round(($reserve * 0.60) + $restingHR)
            ],
            "Z2" => [
                round(($reserve * 0.60) + $restingHR),
                round(($reserve * 0.70) + $restingHR)
            ],
            "Z3" => [
                round(($reserve * 0.70) + $restingHR),
                round(($reserve * 0.80) + $restingHR)
            ],
            "Z4" => [
                round(($reserve * 0.80) + $restingHR),
                round(($reserve * 0.90) + $restingHR)
            ],
            "Z5" => [
                round(($reserve * 0.90) + $restingHR),
                round(($reserve * 1.00) + $restingHR)
            ]
        ];
    }
}
