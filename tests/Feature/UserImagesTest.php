<?php

namespace Tests\Feature;

use App\User;
use App\UserImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserImagesTest extends TestCase
{
    use RefreshDatabase;

    /*A method to run before every single test - work with Images*/
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    /** @test */
    public function images_can_be_uploaded()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $file = UploadedFile::fake()->image('user-image.jpg');

        $response = $this->post('/api/user-images', [
            'image' => $file,
            'width' => 850,
            'height' => 300,
            'location' => 'cover',
        ])->assertStatus(201);

        Storage::disk('public')->assertExists('user-images/'.$file->hashName());

        $userImage = UserImage::first();
        $this->assertEquals('user-images/'.$file->hashName(), $userImage->path);
        $this->assertEquals('850', $userImage->width);
        $this->assertEquals('300', $userImage->height);
        $this->assertEquals('cover', $userImage->location);
        $this->assertEquals($user->id, $userImage->user_id);

        $response->assertJson([
            'data' => [
                'type' => 'user-images',
                'user_image_id' => $userImage->id,
                'attributes'=> [
                    'path' => url($userImage->path),
                    'width' => $userImage->width,
                    'height' => $userImage->height,
                    'location' => $userImage->location,
                ]
            ],
            'links' => [
                'self' => url('/users/'.$user->id),
            ]
        ]);

    }

    /** @test */
    public function users_are_returned_with_their_images()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');
        $file = UploadedFile::fake()->image('user-image.jpg');
        /*Create One image for cover-image*/
        $this->post('/api/user-images', [
            'image' => $file,
            'width' => 850,
            'height' => 300,
            'location' => 'cover',
        ])->assertStatus(201);
        /*Create One image for profile-image*/
        $this->post('/api/user-images', [
            'image' => $file,
            'width' => 850,
            'height' => 300,
            'location' => 'profile',
        ])->assertStatus(201);

        $response = $this->get('/api/users/' . $user->id);

        $response->assertJson([
            'data' => [
                'type' => 'users',
                'user_id' => $user->id,
                'attributes' => [
                    'cover_image' => [
                        /*we copied the above data test but due we are interesting on specific thing
                        we can clean it up, for example, all others attributes are tested in the previous test*/
                        'data' => [
                            'type' => 'user-images',
                            'user_image_id' => 1,
                            'attributes'=> []
                        ],
                    ],
                    'profile_image' => [
                        /*we copied the above data test but due we are interesting on specific thing
                        we can clean it up, for example, all others attributes are tested in the previous test*/
                        'data' => [
                            'type' => 'user-images',
                            'user_image_id' => 2,
                            'attributes'=> []
                        ],
                    ]
                ]
            ],
        ]);


    }
}
