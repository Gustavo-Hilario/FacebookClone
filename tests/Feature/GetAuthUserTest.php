<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetAuthUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticate_user_can_be_fetched()
    {
        $this->withoutExceptionHandling();

        /* with 'api' we make sure that we are authenticating our user as an api user */
        $this->actingAs($user = factory(User::class)->create() , 'api');

        $response = $this->get('/api/auth-user');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'user_id' => $user->id,
                    'attributes' => [
                        'name' => $user->name,
                    ]
                ],
                'links' => [
                    'self' => url('/users/' . $user->id),
                ]
            ]);
    }
}
