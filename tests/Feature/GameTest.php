<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GameTest extends TestCase
{
    public function test_roll_unauthenticated()
    {
        $response = $this
            ->postJson(route('roll'), []);


        $response->assertStatus(401);

//        $response->dump();
    }



    public function test_roll()
    {
        $user = User::find(2);

        $response = $this
            ->actingAs($user, 'sanctum')
            ->postJson(route('roll'), []);


        $response->assertStatus(200);

//        $response->dump();
    }
}
