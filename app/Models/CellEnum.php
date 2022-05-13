<?php
/**
 * Created by PhpStorm.
 * User: Maksim Morozov <maxpower656@gmail.com>
 * Date: 12.05.2022
 * Time: 18:45
 */

namespace App\Models;

enum CellEnum: int
{
    case One = 1;
    case Two = 2;
    case Three = 3;
    case Four = 4;
    case Five = 5;
    case Six = 6;
    case Seven = 7;
    case Eight = 8;
    case Nine = 9;
    case Ten = 10;
    case Jackpot = 11;

    public function weight(): int
    {
        return match ($this) {
            self::One => 20,
            self::Two => 100,
            self::Three => 45,
            self::Four => 70,
            self::Five => 15,
            self::Six => 140,
            self::Seven => 20,
            self::Eight => 20,
            self::Nine => 140,
            self::Ten => 45,
            default => 0,
        };
    }

    public static function numericCases(): array
    {
        return array_slice(CellEnum::cases(), 0, -1);
    }

}
