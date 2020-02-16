<?php

namespace Tests\Feature;

use App\Category;
use App\Song;
use App\User;
use Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function testCreateCategories()
    {
        $categories = factory(Category::class, 4)->create();
        $this->assertCount(4, $categories);
    }

    public function testCreateCategorySong()
    {
        $category = factory(Category::class)->create();
        $songs = factory(Song::class, 3)->create();

        $songsIds = $songs->pluck('id')->values();
        $category->songs()->attach($songsIds);

        $this->assertCount(3, $category->songs);
    }

    public function testGetCategories()
    {
        $response = $this->get('/api/category');

        $response->assertStatus(200);
    }

    public function testGetCategory()
    {
        $response = $this->get('/api/category/1');

        $response->assertStatus(200);
    }

    public function testGetSong()
    {
        $response = $this->get('/api/category/1/song');

        $response->assertStatus(200);
    }
}
