<?php

namespace Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUserIndex()
    {
        $this->assertModel('user.index', UserResource::make(User::first()), [], User::count());
    }

    public function testUserShow()
    {
        $this->assertModel('user.show', UserResource::make(User::first()), ['user' => User::first()->id]);
    }

    public function testAdminCanCreateUsers()
    {
        $requestModel = [
            'name' => 'Test User',
            'email' => 'test@test.test',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ];
        $expectedData = [
            'name' => 'Test User',
            'email' => 'test@test.test'
        ];

        $this->assertPermissionCanCreate('admin', 'user', $requestModel, $expectedData);
    }

    public function testOthersCanNotCreateUsers()
    {
        $requestModel = [
            'name' => 'Test User',
            'email' => 'test@test.test',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ];

        $this->assertPermissionCanNotCreate('supervisor', 'user', $requestModel);
        $this->assertPermissionCanNotCreate('guard', 'user', $requestModel);
    }

    public function testAdminCanUpdateUser()
    {
        $this->assertPermissionCanUpdate('admin', 'user', ['name' => 'Updated User'], User::latest()->first());
    }

    public function testAdminCanOnlyUpdateOwnPassword()
    {
        $requestModel = [
            'password' => 'updated_secret',
            'password_confirmation' => 'updated_secret',
            'old_password' => 'secret'
        ];
        $this->assertPermissionCanUpdate('admin', 'user', $requestModel, $this->users['admin']);
        $this->assertPermissionCanNotUpdate('admin', 'user', $requestModel, $this->users['supervisor']);
    }

    public function testOthersCanNotUpdateUsers()
    {
        $this->assertPermissionCanNotUpdate('supervisor', 'user', ['name' => 'Updated User'], User::latest()->first());
        $this->assertPermissionCanNotUpdate('guard', 'user', ['name' => 'Updated User'], User::latest()->first());
    }

    public function testAdminCanDeleteUsers()
    {
        $this->assertPermissionCanDelete('admin', 'user', $this->users['supervisor']->id);
        $this->assertPermissionCanNotDelete('admin', 'user', $this->users['admin']->id);
    }

    public function testOthersCanNotDeleteUsers()
    {
        $this->assertPermissionCanNotDelete('supervisor', 'user', $this->users['guard']->id);
        $this->assertPermissionCanNotDelete('guard', 'user', $this->users['supervisor']->id);
    }
}
