<?php /** @noinspection MagicMethodsValidityInspection */

/** @noinspection PhpUnhandledExceptionInspection */

namespace Tests;

use App\Models\User;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\TestResponse;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

abstract class TestCase extends BaseTestCase {

    use CreatesApplication;
    use DatabaseMigrations;

    protected Generator $faker;

    /** @var User[] $users */
    protected array $users;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');
        $this->users = [
            'admin' => User::where( 'name', 'Administrator')->first(),
            'supervisor' => User::where( 'name', 'Test Supervisor')->first(),
            'guard' => User::where( 'name', 'Test Security Guard')->first()
        ];
    }

    public function __get($key) {

        if ($key === 'faker') {
            return $this->faker;
        }
        throw new RuntimeException('Unknown Key Requested');
    }

    /**
     * @param string $routingTo Route to GET from
     * @param JsonResource|string $iShouldGet Expected JSON
     * @param array $sending Request Body
     * @param int $resultCountWillBe Count of resulting array if applicable. -1 to ignore.
     */
    public function assertModel(string $routingTo, JsonResource|string $iShouldGet, array $sending = [], int $resultCountWillBe = -1): void
    {
        foreach ($this->users as $user) {
            $response = $this->actingAs($user)->getJson(route($routingTo, $sending));
            if($iShouldGet instanceof JsonResource) {
                $response->assertJsonFragment([$iShouldGet->jsonSerialize()]);
            }else{
                try{
                    $response->assertJsonFragment(json_decode($iShouldGet, true, 512, JSON_THROW_ON_ERROR));
                }catch (\JsonException $e){
                    self::fail($e->getMessage());
                }
            }
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

    public function assertPermissionCanNotCreate(string $actingAs, string $canNotCreate, array $sending): TestResponse
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

    /**
     * @param string $actingAs
     * @param string $canDelete
     * @param $target
     * @return TestResponse
     */
    public function assertPermissionCanDelete(
        string $actingAs,
        string $canDelete,
        $target
    ): TestResponse {
        $response = $this->actingAs($this->users[$actingAs])->delete(route("$canDelete.destroy", $target));
        $response->assertStatus(ResponseCode::HTTP_NO_CONTENT);
        return $response;
    }

    /**
     * @param string $actingAs
     * @param string $canNotDelete
     * @param $target
     * @return TestResponse
     */
    public function assertPermissionCanNotDelete(string $actingAs, string $canNotDelete, $target): TestResponse
    {
        $response = $this->actingAs($this->users[$actingAs])->delete(route("$canNotDelete.destroy", $target));
        $response->assertStatus(ResponseCode::HTTP_FORBIDDEN);
        return $response;
    }
}
