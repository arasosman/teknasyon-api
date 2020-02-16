<?php

namespace Tests\Feature;

use App\Services\ConfigService;
use App\User;
use Artisan;
use GuzzleHttp\Client;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUnAuth()
    {
        $response = $this->get('/api/user');
        $response = json_decode($response->getContent());
        $this->assertEquals(401, $response->errorCode);
        $this->assertEquals("UnAuthorize", $response->errorMessage);
    }

    /**
     * Db in memory olduğu için 401
     */
    public function testAuth()
    {
        $user = factory(User::class)->create();
        $client = new Client([
            'headers' => [
                'Accept' => 'application/json',
                'token' => $user->api_token
            ]
        ]);

        $response = $client->get(env("APP_URL") . '/api/user');
        $response = json_decode($response->getBody()->getContents());
        $this->assertEquals(401, $response->errorCode);
        $this->assertEquals("UnAuthorize", $response->errorMessage);
    }
}
