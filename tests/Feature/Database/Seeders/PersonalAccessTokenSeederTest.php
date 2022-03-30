<?php

namespace Tests\Feature\Database\Seeders;

use Database\Seeders\PersonalAccessTokenSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class PersonalAccessTokenSeederTest extends TestCase
{
    use RefreshDatabase;

    public function testSeed()
    {
        $this->seed(PersonalAccessTokenSeeder::class);

        $this->assertDatabaseHas(PersonalAccessToken::class, ['id' => 1]);
    }
}
