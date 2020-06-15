<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    /**
     * __construct
     *
     * @param  mixed $name
     * @param  mixed $data
     * @param  mixed $dataName
     * @return void
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->createApplication();
    }
    /**
     * testLogin
     *
     * @dataProvider loginDataProvider
     * @param        mixed $expect
     * @param        mixed $responseCode
     * @return       void
     */
    public function testLogin($expect, $responseCode): void
    {
        $response = $this->post('/api/auth/login', $expect);
        $response->assertStatus($responseCode);
    }

    /**
     * testLogout
     *
     * @dataProvider logoutDataProvider
     * @param        mixed $expect
     * @param        mixed $responseCode
     * @return       void
     */
    public function testLogout($token, $responseCode): void
    {
        $this->withHeader('Authorization', "Bearer {$token}");
        $response = $this->post('/api/auth/logout');
        $response->assertStatus($responseCode);
    }

    /**
     * testMe
     *
     * @dataProvider meDataProvider
     * @param        mixed $token
     * @param        mixed $expect
     * @return       void
     */
    public function testMe($token, $expect): void
    {
        $this->withHeader('Authorization', "Bearer {$token}");
        $response = $this->get('/api/auth/me');

        $response->assertJsonFragment($expect);
    }

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
     * testRefresh
     *
     * @dataProvider refreshDataProvider
     * @param        mixed $token
     * @param        mixed $responseCode
     * @return       void
     */
    public function testRefresh($token, $responseCode): void
    {
        $this->withHeader('Authorization', "Bearer {$token}");
        $response = $this->post('/api/auth/refresh');

        $response->assertStatus($responseCode);
    }

    /**
     * testUpdate
     *
     * @dataProvider updateDataProvider
     * @param        mixed $token
     * @param        mixed $expect
     * @return       void
     */
    public function testUpdate($token, $expect): void
    {
        $this->withHeader('Authorization', "Bearer {$token}");
        $response = $this->put('/api/auth/update', $expect);

        $response->assertJsonFragment($expect);
    }

    /**
     * loginDataProvider
     *
     * @return array
     */
    public function loginDataProvider(): array
    {
        $normalCase = User::find(1)->toArray();
        $normalCase['password'] = 'password';
        $abnormalCase = [
            "email" => "badcase@example.com",
            "password" => "paaaaaaasword"
        ];

        return [
            [$normalCase, 200],
            [$abnormalCase, 401]
        ];
    }

    /**
     * logoutDataProvider
     *
     * @return array
     */
    public function logoutDataProvider(): array
    {
        $user = User::find(1);
        $token = JWTAuth::fromUser($user);
        $wrongToken = "hogehogehogehgoehogehogehogehogehogehogehoge";
        return [
            [$token, 200],
            [$wrongToken, 401]
        ];
    }

    /**
     * meDataProvider
     *
     * @return array
     */
    public function meDataProvider(): array
    {
        $user = User::find(1);
        $token = JWTAuth::fromUser($user);
        $authlized = [
            "account_id" => "superuser",
            "email" => "admin@example.com",
        ];

        $wrongToken = "hogehogehogehgoehogehogehogehogehogehogehoge";
        $unAuthlized = [
            "error" => "Unauthenticated."
        ];

        return [
            [$token, $authlized],
            [$wrongToken, $unAuthlized]
        ];
    }

    /**
     * registerDataProvider
     *
     * @return array
     */
    public function registerDataProvider(): array
    {
        $normalCase = factory(User::class)->make()->toArray();
        $normalCase['password'] = 'password';
        $abnormalCase = factory(User::class)->make(['account_id' => null]);
        $abnormalCase['password'] = 'password';

        return [
            [$normalCase, 201],
            [$abnormalCase->toArray(), 500]
        ];
    }

    /**
     * refreshDataProvider
     *
     * @return array
     */
    public function refreshDataProvider(): array
    {
        $user = User::find(1);
        $token = JWTAuth::fromUser($user);
        $wrongToken = "hogehogehogehgoehogehogehogehogehogehogehoge";
        return [
            [$token, 200],
            [$wrongToken, 401]
        ];
    }

    /**
     * updateDataProvider
     *
     * @return array
     */
    public function updateDataProvider(): array
    {
        $user = User::find(1);
        $token = JWTAuth::fromUser($user);
        $normalCase = [
          "last_name" => "山田",
          "first_name" => "花子",
          "last_name_kana" => "やまだ",
          "first_name_kana" => "花子"
        ];

        $wrongToken = "hogehogehogehgoehogehogehogehogehogehogehoge";
        $unAuthlized = [
            "error" => "Unauthenticated."
        ];

        return [
            [$token, $normalCase],
            [$wrongToken, $unAuthlized]
        ];
    }
}
