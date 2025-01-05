<?php

namespace Tests\Feature\Http\Controller;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PostImageControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetPostImageByIdAndReturnSuccess()
    {
        $header = [
            'token' => env('API_TOKEN'),
        ];
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->user_id
        ])->makeVisible('user_id');
        $post = Post::factory()->create([
            'profile_id' => $profile->profile_id
        ])->makeVisible('user_id');
        $postImage = PostImage::factory()->create([
            'profile_id' => $profile->profile_id,
            'post_id' => $post->post_id,
        ]);
        $response = $this->getJson(route('post.image.show', $postImage->post_image_id), $header);
        $response->assertStatus(200);
    }

    public function testGetPostImageByIdAndReturnBadRequest()
    {
        $header = [
            'token' => env('API_TOKEN'),
        ];
        $post_id = '1';
        $response = $this->getJson(route('post.image.show', $post_id), $header);
        $response->assertStatus(404);
    }

    public function testCreatePostImageAndReturnSuccess()
    {
        $header = [
            'token' => env('API_TOKEN'),
        ];
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->user_id
        ])->makeVisible('user_id');
        $post = Post::factory()->create([
            'profile_id' => $profile->profile_id
        ])->makeVisible('profile_id');
        $postImage = PostImage::factory()->create([
            'profile_id' => $profile->profile_id,
            'post_id' => $post->post_id,
        ]);

        $postCreate = [
            'post_image_url' => $postImage->post_image_id,
            'profile_id' => $profile->profile_id,
            'post_id' => $post->post_id,
        ];

        $response = $this->postJson(route('post.image.create'), $postCreate, $header);
        $response->assertStatus(201);
    }

    public function testCreatePostImageAndReturnBadRequest()
    {
        $header = [
            'token' => env('API_TOKEN')
        ];

        $postCreate = [
            'post_image_url' => 'www.test_image.com',
            'profile_id' => '1',
            'post_id' => '1',
        ];

        $response = $this->postJson(route('post.image.create'), $postCreate, $header);
        $response->assertStatus(400);
    }

    public function testUpdatePostImageUrlAndReturnSuccess()
    {

        $header = [
            'token' => env('API_TOKEN'),
        ];
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->user_id
        ])->makeVisible('user_id');
        $post = Post::factory()->create([
            'profile_id' => $profile->profile_id
        ])->makeVisible('profile_id');

        $postImage = PostImage::factory()->create([
            'profile_id' => $profile->profile_id,
            'post_id' => $post->post_id,
        ])->makeVisible('profile_id');

        $postToUpdate = [
            'post_image_id' => $postImage->post_image_id,
            'post_image_url' => $postImage->post_image_url,
            'profile_id' => $profile->profile_id,
            'post_id' => $post->post_id,
        ];

        $responsePatch = $this->patchJson(route('post.image.update'), $postToUpdate, $header);
        $responsePatch
            ->assertStatus(200);
    }

    public function testUpdatePostImageUrlAndReturnFail()
    {
        $header = [
            'token' => env('API_TOKEN'),
        ];
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->user_id
        ])->makeVisible('user_id');
        $post = Post::factory()->create([
            'profile_id' => $profile->profile_id
        ])->makeVisible('profile_id');

        $postImage = PostImage::factory()->create([
            'profile_id' => $profile->profile_id,
            'post_id' => $post->post_id,
        ])->makeVisible('profile_id');

        $postToUpdate = [
            'post_image_id' => '1',
            'post_image_url' => 'www.test.com',
            'profile_id' => '1',
            'post_id' => '1',
        ];

        $responsePatch = $this->patchJson(route('post.image.update'), $postToUpdate, $header);
        $responsePatch
            ->assertStatus(404);
    }

    public function testDeletePostImageAndReturnSuccess()
    {
        $header = [
            'token' => env('API_TOKEN'),
        ];
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->user_id
        ])->makeVisible('user_id');
        $post = Post::factory()->create([
            'profile_id' => $profile->profile_id
        ])->makeVisible('profile_id');

        $postImage = PostImage::factory()->create([
            'profile_id' => $profile->profile_id,
            'post_id' => $post->post_id,
        ])->makeVisible('profile_id');

        $postToRemove = [
            'post_image_id' => $postImage->post_image_id,
            'post_image_url' => $postImage->post_image_url,
            'profile_id' => $profile->profile_id,
            'post_id' => $post->post_id,
        ];
        $response = $this->deleteJson(route('post.image.delete'), $postToRemove, $header);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Post image deleted successfully'
            ]);
    }

    public function testTryDeleteNonExistentPostImageAndReturnFail()
    {
        $header = [
            'token' => env('API_TOKEN'),
        ];

        $dataToRemove = [
            'post_image_id' => '1',
            'post_image_url' => 'www.test.com',
            'profile_id' => '1',
            'post_id' => '1',
        ];
        $response = $this->deleteJson(route('post.image.delete'), $dataToRemove, $header);
        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'No profile or post image founded with provided id'
            ]);
    }
}
