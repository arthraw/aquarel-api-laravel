<?php

namespace Tests\Feature\Http\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;
    public function testPostUserCreateSuccess()
    {
        $fakeUser = [
            'username' => 'Carlos Alberto',
            'password' => 'Teste1234',
            'email' => 'carlos_alberto@gmail.com',
        ];
        $header = [
            'token' => env('API_TOKEN')
        ];
        $user = User::factory()->make($fakeUser);
        $response = $this->postJson(route('users.register'), $user->getUserAttributes(), $header);
        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => 'User updated successfully',
            ]);
    }

    public function testCreateDuplicatedUser()
    {
        $fakeUser = [
            'username' => 'etevaldo',
            'email' => 'etevaldo@teste.com',
            'password' => 'teste1234',
        ];
        $header = [
            'token' => env('API_TOKEN')
        ];
        $user = User::factory()->make($fakeUser);
        $response = $this->postJson(route('users.register'), $user->getUserAttributes(), $header);
        $response
            ->assertStatus(400)
            ->assertJson([
                'message' => 'An account already exists with the email provided.',
            ]);
    }

    public function testPostUserCreateWithoutPassword()
    {
        $userAttributes = [
            'username' => 'Carlos Alberto',
            'email' => 'carlos_alberto@gmail.com',
        ];
        $header = [
            'token' => env('API_TOKEN')
        ];
        $response = $this->postJson(route('users.register'), $userAttributes, $header);
        $response
            ->assertStatus(400);
    }

    public function testExistentUserLogin()
    {
        $fakeUser = [
            'email' => 'etevaldo@teste.com',
            'password' => 'teste123',
        ];
        $header = [
            'token' => env('API_TOKEN')
        ];
        $response = $this->postJson(route('users.login'), $fakeUser, $header);
        $response
            ->assertStatus(200)
            ->assertJson([
                'token' => 'teste',
            ]);
    }

    public function testNotExistentUserEmailLogin()
    {
        $fakeUser = [
            'email' => 'bola_de_gude@gmail.com',
            'password' => 'teste123',
        ];
        $header = [
            'token' => env('API_TOKEN')
        ];
        $response = $this->postJson(route('users.login'), $fakeUser, $header);
        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'No users found with provided email',
            ]);
    }

    public function testLoginUserWithWrongPassword()
    {
        $fakeUser = [
            'email' => 'etevaldo@teste.com',
            'password' => 'senhaqualquer123',
        ];
        $header = [
            'token' => env('API_TOKEN')
        ];
        $response = $this->postJson(route('users.login'), $fakeUser, $header);
        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'Failed to auth user with provided credentials',
            ]);
    }

    public function testLoginUserWithoutEmail()
    {
        $fakeUser = [
            'password' => 'senhaqualquer123',
        ];
        $header = [
            'token' => env('API_TOKEN')
        ];
        $response = $this->postJson(route('users.login'), $fakeUser, $header);
        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'Email field is required',
            ]);
    }
}
