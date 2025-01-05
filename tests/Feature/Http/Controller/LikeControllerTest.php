<?php

namespace Tests\Feature\Http\Controller;

use App\Enum\Like\LikeTypeEnum;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LikeControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testAddLikeInPostReturnSuccess()
    {
        $header = [
            'token' => env('API_TOKEN')
        ];
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->user_id
        ])->makeVisible('user_id');
        $post = Post::factory()->create([
            'profile_id' => $profile->profile_id
        ])->makeVisible('user_id');

        $postData = [
            'profile_id' => $profile->profile_id,
            'likeable_id' => $post->post_id,
            'likeable_type' => LikeTypeEnum::POST,
        ];

        $response = $this->postJson(route('like.add'), $postData, $header);
        $response
            ->assertStatus(201);
    }

    public function testAddDoubleLikeInPostReturnFail()
    {
        $header = [
            'token' => env('API_TOKEN')
        ];
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->user_id
        ])->makeVisible('user_id');
        $post = Post::factory()->create([
            'profile_id' => $profile->profile_id
        ])->makeVisible('user_id');
        $like = Like::factory()->create([
            'profile_id' => $profile->profile_id,
            'likeable_id' => $post->post_id
        ]);
        $postData = [
            'profile_id' => $profile->profile_id,
            'likeable_id' => $post->post_id,
            'likeable_type' => LikeTypeEnum::POST,
        ];

        $response = $this->postJson(route('like.add'), $postData, $header);
        $response
            ->assertStatus(400);
    }

    public function testAddLikeInPostWithInvalidPostProvided()
    {
        $header = [
            'token' => env('API_TOKEN')
        ];
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->user_id
        ])->makeVisible('user_id');
        $post = Post::factory()->create([
            'profile_id' => $profile->profile_id
        ])->makeVisible('user_id');

        $postData = [
            'profile_id' => $profile->profile_id,
            'likeable_id' => '1',
            'likeable_type' => LikeTypeEnum::POST,
        ];

        $response = $this->postJson(route('like.add'), $postData, $header);
        $response
            ->assertStatus(404);
    }

    public function testAddLikeInPostWithInvalidProfileProvided()
    {
        $header = [
            'token' => env('API_TOKEN')
        ];
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->user_id
        ])->makeVisible('user_id');
        $post = Post::factory()->create([
            'profile_id' => $profile->profile_id
        ])->makeVisible('user_id');

        $postData = [
            'profile_id' => '1',
            'likeable_id' => $post->post_id,
            'likeable_type' => LikeTypeEnum::POST,
        ];

        $response = $this->postJson(route('like.add'), $postData, $header);
        $response
            ->assertStatus(404);
    }

    public function testGetLikesOfProvidedPostReturnSuccess()
    {
        $header = [
            'token' => env('API_TOKEN')
        ];
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->user_id
        ])->makeVisible('user_id');
        $post = Post::factory()->create([
            'profile_id' => $profile->profile_id
        ])->makeVisible('user_id');
        $like = Like::factory()->create([
            'profile_id' => $profile->profile_id,
            'likeable_id' => $post->post_id
        ]);
        $postData = [
            'profile_id' => $profile->profile_id,
            'likeable_id' => $post->post_id,
            'likeable_type' => LikeTypeEnum::POST,
        ];

        $response = $this->postJson(route('like.count'), $postData, $header);
        $response
            ->assertStatus(200)
            ->assertJson([
                'likes_count' => 1
            ]);
    }
    # testar delete do like

    public function testDeleteExistentLikeReturnSuccess()
    {
        $header = [
            'token' => env('API_TOKEN')
        ];
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->user_id
        ])->makeVisible('user_id');
        $post = Post::factory()->create([
            'profile_id' => $profile->profile_id
        ])->makeVisible('user_id');
        $like = Like::factory()->create([
            'profile_id' => $profile->profile_id,
            'likeable_id' => $post->post_id
        ]);
        $postData = [
            'like_id' => $like->like_id,
        ];

        $response = $this->deleteJson(route('like.remove'), $postData, $header);
        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Like deleted successfully'
            ]);
    }

    public function testDeleteNotExistentLikeReturnFail()
    {
        $header = [
            'token' => env('API_TOKEN')
        ];
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->user_id
        ])->makeVisible('user_id');
        $post = Post::factory()->create([
            'profile_id' => $profile->profile_id
        ])->makeVisible('user_id');
        $like = Like::factory()->create([
            'profile_id' => $profile->profile_id,
            'likeable_id' => $post->post_id
        ]);
        $postData = [
            'like_id' => '1',
        ];

        $response = $this->deleteJson(route('like.remove'), $postData, $header);
        $response
            ->assertStatus(404);
    }
}
