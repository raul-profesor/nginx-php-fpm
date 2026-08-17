<?php

class HeartRateCalculator
{
    public static function calculateFCM(int $age): int
    {
        return 220 - $age;
    }

    public static function calculateTanaka(int $age): int
    {
        return round(208 - (0.7 * $age));
    }

    public static function getZones(int $fcm): array
    {
        return [
            "Z1 Recuperación" => [round($fcm * 0.50), round($fcm * 0.60)],
            "Z2 Aeróbica" => [round($fcm * 0.60), round($fcm * 0.70)],
            "Z3 Tempo" => [round($fcm * 0.70), round($fcm * 0.80)],
            "Z4 Umbral" => [round($fcm * 0.80), round($fcm * 0.90)],
            "Z5 VO2Max" => [round($fcm * 0.90), round($fcm * 1.00)]
        ];
    }
}