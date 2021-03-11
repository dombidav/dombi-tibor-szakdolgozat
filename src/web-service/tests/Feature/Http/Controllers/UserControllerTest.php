<?php

namespace Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var User[] $users */
    protected array $users;

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

    public function testUserIndex(){
        $this->assertModel('user.index', UserResource::make(User::first()), [], User::count());
    }

    public function testUserShow(){
        $this->assertModel('user.show', UserResource::make(User::first()), ['user' => User::first()->id]);
    }

    public function testAdminCanCreateUsers(){
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

    public function testOthersCanNotCreateUsers(){
        $requestModel = [
            'name' => 'Test User',
            'email' => 'test@test.test',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ];

        $this->assertPermissionCanNotCreate('supervisor', 'user', $requestModel);
        $this->assertPermissionCanNotCreate('guard', 'user', $requestModel);
    }

    public function testAdminCanUpdateUser(){
        $this->assertPermissionCanUpdate('admin', 'user', ['name' => 'Updated User'], User::latest()->first());
    }

    public function testAdminCanOnlyUpdateOwnPassword(){
        $requestModel = [
            'password' => 'updated_secret',
            'password_confirmation' => 'updated_secret',
            'old_password' => 'secret'
        ];
        $this->assertPermissionCanUpdate('admin', 'user', $requestModel, $this->users['admin']);
        $this->assertPermissionCanNotUpdate('admin', 'user', $requestModel, $this->users['supervisor']);
    }

    public function testOthersCanNotUpdateUsers(){
        $this->assertPermissionCanNotUpdate('supervisor', 'user',  ['name' => 'Updated User'], User::latest()->first());
        $this->assertPermissionCanNotUpdate('guard', 'user', ['name' => 'Updated User'], User::latest()->first());
    }

    public function testAdminCanDeleteUsers(){
        $model = 'user';
        $response = $this->actingAs($this->users['admin'])->delete(route("$model.destroy", $this->users['supervisor']->id));
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

    /**
     * @param string $routingTo Route to GET from
     * @param JsonResource $iShouldGet Expected JSON
     * @param array $sending Request Body
     * @param int $resultCountWillBe Count of resulting array if applicable. -1 to ignore.
     */
    public function assertModel(string $routingTo, JsonResource $iShouldGet, array $sending = [], int $resultCountWillBe = -1): void
    {
        foreach ($this->users as $user) {
            $response = $this->actingAs($user)->getJson(route($routingTo, $sending));
            $response->assertJsonFragment([$iShouldGet->jsonSerialize()]);
            if($resultCountWillBe > -1) {
                self::assertCount($resultCountWillBe, $response->json('data'));
            }
        }
    }

    public function assertPermissionCanCreate(string $actingAs, string $canCreate, array $sending, array $expecting): void
    {
        $response = $this->actingAs($this->users[$actingAs])->post(route("$canCreate.store"), $sending);
        $response->assertStatus(ResponseCode::HTTP_CREATED);
        $response->assertJsonFragment($expecting);
    }

    public function assertPermissionCanNotCreate(string $actingAs, string $canNotCreate, array $sending): \Illuminate\Testing\TestResponse
    {
        $response = $this->actingAs($this->users[$actingAs])->post(route("$canNotCreate.store"), $sending);
        $response->assertStatus(ResponseCode::HTTP_FORBIDDEN);
        return $response;
    }

    public function assertPermissionCanUpdate(string $actingAs, string $canUpdate, array $sending, Model $expecting): void
    {
        $response = $this->actingAs($this->users[$actingAs])->put(route("$canUpdate.update", $expecting->id), $sending);
        $response->assertStatus(ResponseCode::HTTP_NO_CONTENT);
    }
    public function assertPermissionCanNotUpdate(string $actingAs, string $canNotUpdate, array $sending, Model $expecting): void
    {
        $response = $this->actingAs($this->users[$actingAs])->put(route("$canNotUpdate.update", $expecting->id), $sending);
        $response->assertStatus(ResponseCode::HTTP_FORBIDDEN);
    }
}
