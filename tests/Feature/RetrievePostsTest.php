<?php

namespace Tests\Feature;

use App\Friend;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetrievePostTest extends TestCase
{
    Use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /* IMPORTANT: Without this our code can not run*/
    /** @test*/

    public function a_user_can_retrieve_posts()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $anotherUser = factory(User::class)->create();

        /*getting the posts for the other user*/
        $posts = factory(Post::class, 2)->create(['user_id' => $anotherUser->id]);

        /*creating a friendship between users to each one be all to see posts*/
        Friend::create([
            'user_id' => $user->id,
            'friend_id' => $anotherUser->id,
            'confirmed_at' => now(),
            'status' => 1
        ]);

        /*Fetching Data - Fetching Resources. JSON API DOCS*/
        $response = $this->get('/api/posts');

        $response->assertStatus(200)
            ->assertJson([
                /*We have a single data structure but each Resource will be a post resource its own*/
                'data' => [
                    [
                        'data' => [
                            'type' => 'posts',
                            'post_id' => $posts->last()->id,
                            'attributes' => [
                                'body' => $posts->last()->body,
                                'image' => $posts->last()->image,
                                'posted_at' => $posts->last()->created_at->diffForHumans(),
                            ]
                        ]
                    ],
                    [
                        'data' => [
                            'type' => 'posts',
                            'post_id' => $posts->first()->id,
                            'attributes' => [
                                'body' => $posts->first()->body,
                                'image' => $posts->first()->image,
                                'posted_at' => $posts->first()->created_at->diffForHumans(),
                            ]
                        ]
                    ],
                ],
                'links' => [
                    'self' => url('/posts'),
                ],
            ]);
    }

    /** @test */
    public function a_user_can_only_retrieve_their_code()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $posts = factory(Post::class)->create();

        /*Fetching Data - Fetching Resources. JSON API DOCS*/
        $response = $this->get('/api/posts');

        $response->assertStatus(200)
            /*fetching resources representing a empty collection*/
                /*with exact json we will check the empty data array*/
            ->assertExactJson([
                'data' => [],
                'links' => [
                    'self' => url('/posts'),
                ]
            ]);
    }
}
