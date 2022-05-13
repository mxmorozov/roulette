<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Game
 *
 * @property int $id
 * @property int $user_id
 *
 * @property Roll[] $rolls
 */
class Game extends Model
{
    use HasFactory;

    public function rolls()
    {
        return $this->hasMany(Roll::class);
    }

    public function roll(): ?CellEnum
    {
        $dealtCells = $this->rolls()->pluck('cell')->toArray();

        $roulette = new Roulette($dealtCells);

        $cell = $roulette->roll();

        if ($cell) {
            $roll = new Roll();
            $roll->game_id = $this->id;
            $roll->cell = $cell;
            $roll->save();
        }

        return $cell;

    }

    public function isFinished(): bool
    {
        if ($this->rolls()->count() >= count(CellEnum::cases())) {
            return true;
        }
        return false;
    }

    public function lastRoll(): ?Roll
    {
        return $this->rolls()->orderBy('id', 'desc')->first();
    }

}
