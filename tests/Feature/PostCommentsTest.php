<?php

namespace Tests\Feature;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_comment_on_a_post()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        /*id of 123 just to not get confused with user ID*/
        $post = factory(Post::class)->create(['id' => 123]);

        $response = $this->post('/api/posts/' . $post->id . '/comment', [
            'body' => 'A great comment here',
        ])->assertStatus(200);

        $comment = Comment::first();
        $this->assertCount(1, Comment::all());
        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals($post->id, $comment->post_id);
        $this->assertEquals('A great comment here', $comment->body);

        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'type' => 'comments',
                        'comment_id' => 1,
                        'attributes' => [
                            'commented_by' => [
                                'data' => [
                                    'user_id' => $user->id,
                                    'attributes' => [
                                        'name' => $user->name,
                                    ]
                                ]
                            ],
                            'body' => 'A great comment here',
                            'commented_at' => $comment->created_at->diffForHumans()
                        ]
                    ],
                    'links' => [
                        'self' => url('/posts/123'),
                    ]
                ]
            ],
            'links' => [
                'self' => url('/posts'),
            ]
        ]);
    }

    /** @test */
    public function a_body_is_required_to_leave_a_comment_on_a_post()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $post = factory(Post::class)->create(['id' => 123]);

        $response = $this->post('/api/posts/'.$post->id.'/comment', [
            'body' => '',
        ]);

        /*Error on Validation with assertStatus(422) but dd($responseString) show
        inside a error array this error*/
        $responseString = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('body', $responseString['error']['meta']);
    }

    /** @test */
    public function posts_are_returned_with_comments()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $post = factory(Post::class)->create(['id' => 123, 'user_id' => $user->id]);
        $this->post('/api/posts/' . $post->id . '/comment', [
            'body' => 'A great comment here',
        ]);

        $response = $this->get('/api/posts/');

        $comment = Comment::first();

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    /*array of posts ... collection*/
                    [
                        'data' => [
                            'type' => 'posts',
                            'attributes' => [
                                /*collection of comments*/
                                'comments' => [
                                    'data' => [
                                        [
                                            'data' => [
                                                'type' => 'comments',
                                                'comment_id' => 1,
                                                'attributes' => [
                                                    'commented_by' => [
                                                        'data' => [
                                                            'user_id' => $user->id,
                                                            'attributes' => [
                                                                'name' => $user->name,
                                                            ]
                                                        ]
                                                    ],
                                                    'body' => 'A great comment here',
                                                    'commented_at' => $comment->created_at->diffForHumans()
                                                ]
                                            ],
                                            'links' => [
                                                'self' => url('/posts/123'),
                                            ]
                                        ]
                                    ],
                                    /*helpers to make our front communicate with back-end*/
                                    'comment_count' => 1,
                                ],
                            ]
                        ]
                    ]
                ]
            ]);
    }
}
