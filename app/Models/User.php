<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class Members
 *
 * @property int $id
 * @property string $name
 *
 * @property Game[] $games
 */
class User extends Authenticatable
{
    use /*HasApiTokens, */HasFactory, Notifiable;

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function currentGame(): Game
    {
        /** @var Game $game */
        $game = $this->games()->orderBy('id', 'desc')->first();
        if ($game === null || $game->isFinished()) {
            $game = new Game();
            $game->user_id = $this->id;
            $game->save();
        }
        return $game;
    }

}
