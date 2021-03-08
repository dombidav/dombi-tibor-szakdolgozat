<?php

namespace Http\Controllers;

use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

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

    public function testAdminCanCreateUsers(){
        $password = Hash::make('secret');
        $response = $this->actingAs($this->users['admin'])->post(route('user.store'), [
            'name' => 'Test User',
            'email' => 'test@test.test',
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertJsonFragment([
            'name' => 'Test User',
            'email' => 'test@test.test'
        ]);
    }

    public function testOthersCanNotCreateUsers(){
        $password = Hash::make('secret');
        $user = [
            'name' => 'Test User',
            'email' => 'test@test.test',
            'password' => $password,
            'password_confirmation' => $password
        ];
        $response = $this->actingAs($this->users['supervisor'])->post(route('user.store'), $user);
        $response->assertStatus(ResponseCode::HTTP_FORBIDDEN);

        $response = $this->actingAs($this->users['guard'])->post(route('user.store'), $user);
        $response->assertStatus(ResponseCode::HTTP_FORBIDDEN);
    }

    public function testAdminCanUpdateUser(){
        $user = [
            'name' => 'Updated User'
        ];
        $expected = User::latest()->first();
        $response = $this->actingAs($this->users['admin'])->put(route('user.update', $expected->id), $user);
        $response->assertStatus(ResponseCode::HTTP_NO_CONTENT);
    }

    public function testAdminCanOnlyUpdateOwnPassword(){
        $data = [
            'password' => 'updated_secret',
            'password_confirmation' => 'updated_secret',
            'old_password' => 'secret'
        ];
        $response = $this->actingAs($this->users['admin'])->put(route('user.update', $this->users['admin']->id), $data);
        $response->assertStatus(ResponseCode::HTTP_NO_CONTENT);

        $response = $this->actingAs($this->users['admin'])->put(route('user.update', $this->users['supervisor']->id), $data);
        $response->assertStatus(ResponseCode::HTTP_FORBIDDEN);
    }

    public function testOthersCanNotUpdateUsers(){
        $user = [
            'name' => 'Updated User'
        ];
        $expected = User::latest()->first();
        $response = $this->actingAs($this->users['supervisor'])->put(route('user.update', $expected->id), $user);
        $response->assertStatus(ResponseCode::HTTP_FORBIDDEN);

        $response = $this->actingAs($this->users['guard'])->put(route('user.update', $expected->id), $user);
        $response->assertStatus(ResponseCode::HTTP_FORBIDDEN);
    }

    public function testAdminCanDeleteUsers(){
        $response = $this->actingAs($this->users['admin'])->delete(route('user.destroy', $this->users['supervisor']->id));
        $response->assertStatus(ResponseCode::HTTP_NO_CONTENT);

        $response = $this->actingAs($this->users['admin'])->delete(route('user.destroy', $this->users['admin']->id));
        $response->assertStatus(ResponseCode::HTTP_FORBIDDEN);
    }

    public function testOthersCanNotDeleteUsers(){
        $response = $this->actingAs($this->users['supervisor'])->delete(route('user.destroy', $this->users['guard']->id));
        $response->assertStatus(ResponseCode::HTTP_FORBIDDEN);

        $response = $this->actingAs($this->users['supervisor'])->delete(route('user.destroy', $this->users['supervisor']->id));
        $response->assertStatus(ResponseCode::HTTP_FORBIDDEN);
    }
}
