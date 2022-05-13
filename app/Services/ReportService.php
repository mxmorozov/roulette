<?php
/**
 * Created by PhpStorm.
 * User: Maksim Morozov <maxpower656@gmail.com>
 * Date: 13.05.2022
 * Time: 01:22
 */

namespace App\Services;

use App\Models\CellEnum;
use App\Models\Game;
use App\Models\User;

class ReportService
{
    public static function usersPerRolls(): array
    {
        $output = [];
        foreach (CellEnum::cases() as $cell) {
            $output[$cell->value] = Game::query()
                ->selectRaw('distinct games.user_id')
                ->leftJoin('rolls', 'rolls.game_id', '=', 'games.id')
                ->groupBy('games.id')
                ->havingRaw('count(rolls.id) >= ?', [$cell->value])
                ->count();
        }
        return $output;
    }

    public static function activeUsers(): array
    {
        return User::query()
            ->selectRaw('users.id, users.name, count(distinct games.id) as gamesCount, round(count(rolls.id) / count(distinct games.id), 1) as avgRolls')
            ->leftJoin('games', 'games.user_id', '=', 'users.id')
            ->leftJoin('rolls', 'rolls.game_id', '=', 'games.id')
            ->groupBy('users.id')
            ->havingRaw('gamesCount > 0')
            ->orderBy('gamesCount', 'desc')
            ->orderBy('avgRolls', 'desc')
            ->get()
            ->toArray();
    }

}
