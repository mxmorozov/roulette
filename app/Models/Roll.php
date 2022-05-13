<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Members
 *
 * @property int $id
 * @property int $game_id
 * @property CellEnum $cell
 *
 * @property Game $game
 */
class Roll extends Model
{
    use HasFactory;

    protected $casts = [
        'cell' => CellEnum::class,
    ];

    public function game()
    {
        return $this->hasOne(Game::class);
    }
}
