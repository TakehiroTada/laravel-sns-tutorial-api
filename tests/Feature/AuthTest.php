<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @dataProvider registerDataProvider
     * @param        array $expected     expect
     * @param        int   $responseCode response
     * @return       void
     */
    public function testRegister($expect, $responseCode): void
    {
        $response = $this->post('/api/auth/register', $expect);
        $response->assertStatus($responseCode);
    }

    /**
     * registerDataProvider
     *
     * @return array
     */
    public function registerDataProvider(): array
    {
        $this->createApplication();
        $normalCase = factory(User::class)->make()->toArray();
        $abnormalCase = factory(User::class)->make(['account_id'=> null]);

        return[
            [$normalCase, 201],
            [$abnormalCase->toArray(), 500 ]
        ];
    }
}
