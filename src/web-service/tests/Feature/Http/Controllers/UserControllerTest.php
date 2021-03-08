<?php

namespace Http\Controllers;

use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\Actor;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var User[] $users */
    private array $users;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
        $this->users = [
            'admin' => User::where( 'name', 'Administrator')->first(),
            'supervisor' => User::where( 'name', 'Test Supervisor')->first(),
            'guard' => User::where( 'name', 'Test Security Guard')->first()
        ];
    }

    public function testUserIndex()
    {
        foreach ($this->users as $user){
            $response = $this->actingAs($user)->getJson(route('user.index'));
            $response->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'email_verified_at',
                        'created_at',
                        'updated_at',
                        'roles' => [
                            '*' => []
                        ],
                        'abilities' => [
                            '*' => []
                        ],
                        'forbidden' => [
                            '*' => []
                        ]
                    ]
                ]
            ]);
        }
    }

    public function testUserShow(){
        $expected = User::first();

        foreach ($this->users as $user){
            $response = $this->actingAs($user)->getJson(route('user.show', ['user' => $expected->id]));
            $response->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                    'roles' => [
                        '*' => []
                    ],
                    'abilities' => [
                        '*' => []
                    ],
                    'forbidden' => [
                        '*' => []
                    ]
                ]
            ]);
            $response->assertExactJson(['data' => UserResource::make($expected)->jsonSerialize()]);
        }
    }

}
