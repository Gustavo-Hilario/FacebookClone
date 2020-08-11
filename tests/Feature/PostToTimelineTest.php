<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostToTimelineTest extends TestCase
{
//To make our database refresh after every single Test
    use RefreshDatabase;

    /** @test */

    public function a_user_can_post_a_text_post()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->post('/api/posts', [
           'data' => [
               'type' => 'posts',
               'attributes' => [
                   'body' => 'Testing Body',
               ]
           ]
        ]);

        $post = Post::first();

        $this->assertCount(1, Post::all());

        $this->assertEquals($user->id, $post->user_id);
        $this->assertEquals('Testing Body', $post->body);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'type' => 'posts',
                    /*To be more specific we use post_id that is different from JSON API DOCS*/
                    'post_id' => $post->id,
                    'attributes' => [
                        'body' => 'Testing Body',
                    ]
                ],
                /*Different from DOCS our links is outside DATA because API Resources in Laravel use in this way*/
                'links' => [
                    'self' => url('/posts/'.$post->id)
                ]
            ]);
    }
}
