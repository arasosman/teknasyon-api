<?php

namespace Tests\Feature;

use App\Song;
use App\User;
use Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function testCreateUsers()
    {
        $users = factory(User::class, 3)->create();
        $this->assertCount(3, $users);
    }

    public function testUserFavoriteSongs()
    {
        $user = factory(User::class)->create();
        $songs = factory(Song::class, 3)->create();

        $songsIds = $songs->pluck('id')->values();
        $user->favorites()->attach($songsIds);

        $this->assertCount(3, $user->favorites);
    }
}
