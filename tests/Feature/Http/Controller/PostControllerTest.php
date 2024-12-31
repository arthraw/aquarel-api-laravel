<?php

namespace Tests\Feature\Http\Controller;

use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetAllPostsAndReturnSuccess()
    {
        $header = [
            'token' => env('API_TOKEN')
        ];
        $response = $this->getJson(route('post.all'), $header);

        $response->assertStatus(200);
    }
    public function testGetPostByIdAndReturnSuccess()
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
        $response = $this->getJson(route('post.show', $post->post_id), $header);
        $response->assertStatus(200);
    }

    public function testGetPostByIdAndReturnBadRequest()
    {
        $header = [
            'token' => env('API_TOKEN'),
        ];
        $post_id = '1';
        $response = $this->getJson(route('post.show', $post_id), $header);
        $response->assertStatus(404);
    }

    public function testCreatePostAndReturnSuccess()
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

        $postCreate = [
            'content' => $post->content,
            'profile_id' => $profile->profile_id
        ];

        $response = $this->postJson(route('post.create'), $postCreate, $header);
        $response->assertStatus(201);
    }

    public function testCreatePostAndReturnBadRequest()
    {
        $header = [
            'token' => env('API_TOKEN')
        ];

        $postCreate = [
            'post_id' => '1',
            'content' => 'Lorem Ipsum',
            'profile_id' => '1'
        ];

        $response = $this->postJson(route('post.create'), $postCreate, $header);
        $response->assertStatus(400);
    }

    public function testUpdatePostContentAndReturnSuccess()
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

        $postToUpdate = [
            'post_id' => $post->post_id,
            'content' => 'Content Test',
            'profile_id' => $profile->profile_id
        ];

        $responsePatch = $this->patchJson(route('post.update'), $postToUpdate, $header);
        $responsePatch
            ->assertStatus(200);
    }

    public function testUpdatePostContentAndReturnFail()
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

        $postToUpdate = [
            'post_id' => '1',
            'content' => 'Content Test',
            'profile_id' => '1'
        ];

        $responsePatch = $this->patchJson(route('post.update'), $postToUpdate, $header);
        $responsePatch
            ->assertStatus(404);
    }

    public function testDeletePostAndReturnSuccess()
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


        $dataToRemove = [
            'post_id'=> $post->post_id,
            'content' => $post->content,
            'profile_id' => $post->profile_id,
        ];
        $response = $this->deleteJson(route('post.delete'), $dataToRemove, $header);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Post deleted successfully'
            ]);
    }

    public function testTryDeleteNonExistentPostAndReturnFail()
    {
        $header = [
            'token' => env('API_TOKEN'),
        ];

        $dataToRemove = [
            'post_id' => '1',
            'content' => 'Lorem Ipsum',
            'profile_id' => '1'
        ];
        $response = $this->deleteJson(route('post.delete'), $dataToRemove, $header);
        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'No profile or post founded with provided id'
            ]);
    }
}
