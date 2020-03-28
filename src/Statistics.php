<?php


namespace Jarosoft;


class Statistics
{
    public static function randomIntNormalDistribution(float $mean, float $sd): float
    {
        $x = mt_rand() / mt_getrandmax();
        $y = mt_rand() / mt_getrandmax();
        return sqrt(-2 * log($x)) * cos(2 * pi() * $y) * $sd + $mean;
    }
}