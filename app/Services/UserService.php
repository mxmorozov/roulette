<?php
/**
 * Created by PhpStorm.
 * User: Maksim Morozov <maxpower656@gmail.com>
 * Date: 12.05.2022
 * Time: 20:04
 */

namespace App\Services;

use App\Models\User;
use Faker\Factory;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public static function newUser(): User
    {
        $faker = Factory::create();
        $user = new User();
        $user->name = $faker->name();
        $user->save();
        Auth::login($user, true);
        return $user;
    }
}
