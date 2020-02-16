<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ConfigTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/api/config');

        $response->assertStatus(200);
    }

    public function testGetConfigCode()
    {
        $response = $this->get('/api/config');
        $config = json_decode($response->getContent());
        $this->assertEquals($config->errorCode, 200);
    }

    public function testGetConfigAppVersion()
    {
        $response = $this->get('/api/config');
        $config = json_decode($response->getContent(), true);
        $this->assertTrue(Arr::has($config, 'data.app_ver'));
    }

    public function testGetConfigLangVersion()
    {
        $response = $this->get('/api/config');
        $config = json_decode($response->getContent(), true);
        $this->assertTrue(Arr::has($config, 'data.lang_ver'));
    }
}
