<?php
/**
 * Created by PhpStorm.
 * User: Maksim Morozov <maxpower656@gmail.com>
 * Date: 13.05.2022
 * Time: 02:22
 */

namespace App\Models;

class Roulette
{
    private readonly array $cells;
    private readonly array $numericCells;

    public function __construct(
        private readonly array $dealtCells,
    )
    {
        $this->cells = CellEnum::cases();
        $this->numericCells = CellEnum::numericCases();
    }

    public function roll(): ?CellEnum
    {
        if (count($this->dealtCells) >= count($this->cells)) {
            return null;
        } elseif (count($this->dealtCells) == count($this->numericCells)) {
            $cell = CellEnum::Jackpot;
        } else {
            $allowedCells = array_udiff($this->numericCells, $this->dealtCells, function (CellEnum $a, CellEnum $b) {
                if ($a->value < $b->value) {
                    return -1;
                } elseif ($a->value > $b->value) {
                    return 1;
                } else {
                    return 0;
                }
            });

            $totalWeight = array_reduce($allowedCells, function ($totalWeight, CellEnum $cell) {
                return $totalWeight + $cell->weight();
            });

            $randomNum = rand(1, $totalWeight);
            $max = 0;

            foreach ($allowedCells as $cell) {
                $max += $cell->weight();
                if ($randomNum <= $max) {
                    break;
                }
            }
        }

        return $cell;
    }

}
