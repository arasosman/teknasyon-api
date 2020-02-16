<?php

namespace Tests\Feature;

use App\Song;
use Artisan;
use Tests\TestCase;

class SongTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function testCreateSongs()
    {
        $songs = factory(Song::class, 3)->create();
        $this->assertCount(3, $songs);
    }
}
