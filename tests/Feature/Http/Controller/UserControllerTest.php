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
            'email' => 'carlos_alberto@gmail.com'
        ];

        $user = User::factory()->make($fakeUser);
        $response = $this->postJson(route('users.register'), $user->getUserAttributes());
        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Usuário criado com sucesso.',
            ]);
    }

    public function testCreateDuplicatedUser()
    {
        $fakeUser = [
            'username' => 'etevaldo',
            'email' => 'etevaldo@teste.com',
            'password' => 'teste1234'
        ];

        $user = User::factory()->make($fakeUser);
        $response = $this->postJson(route('users.register'), $user->getUserAttributes());
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
            'email' => 'carlos_alberto@gmail.com'
        ];
        $response = $this->postJson(route('users.register'), $userAttributes);
        $response
            ->assertStatus(400);
    }

    public function testExistentUserLogin()
    {
        $fakeUser = [
            'email' => 'etevaldo@teste.com',
            'password' => 'teste123'
        ];

        $response = $this->postJson(route('users.login'), $fakeUser);
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
            'password' => 'teste123'
        ];

        $response = $this->postJson(route('users.login'), $fakeUser);
        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'Nenhum usuário encontrado com o email passado.',
            ]);
    }

    public function testLoginUserWithWrongPassword()
    {
        $fakeUser = [
            'email' => 'etevaldo@teste.com',
            'password' => 'senhaqualquer123'
        ];

        $response = $this->postJson(route('users.login'), $fakeUser);
        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'Falha ao tentar realizar a autenticação com as credenciais passadas.',
            ]);
    }

    public function testLoginUserWithoutEmail()
    {
        $fakeUser = [
            'password' => 'senhaqualquer123'
        ];

        $response = $this->postJson(route('users.login'), $fakeUser);
        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'O campo email é obrigatório.',
            ]);
    }
}
