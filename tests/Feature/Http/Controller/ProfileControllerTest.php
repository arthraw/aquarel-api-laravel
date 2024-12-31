<?php

namespace Tests\Feature\Http\Controller;

use App\Models\Profile;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testUpdateUserEmailReturnSuccess()
    {
        $fakeProfile = [
            'profile_id' => '34486aa4-55d2-4dbe-ab0d-0d2fffaf441a',
            'email' => 'etevaldo@example.com',
        ];
        $header = [
            'token' => env('API_TOKEN')
        ];
        $response = $this->patchJson(route('profile.update'), $fakeProfile, $header);
        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'User updated successfully',
            ]);
    }

    public function testUpdateUserEmailReturnFail()
    {
        $fakeProfile = [
            'profile_id' => '1',
            'email' => 'etevaldo@example.com',
        ];
        $header = [
            'token' => env('API_TOKEN')
        ];
        $response = $this->patchJson(route('profile.update'), $fakeProfile, $header);
        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'The profile_id provided not exists',
            ]);
    }

    public function testUpdateUserPasswordReturnSuccess()
    {
        $fakeProfile = [
            'profile_id' => '34486aa4-55d2-4dbe-ab0d-0d2fffaf441a',
            'password' => 'Senhasegura123',
            'password_check' => 'teste1234',
        ];
        $header = [
            'token' => env('API_TOKEN')
        ];
        $response = $this->patchJson(route('profile.update'), $fakeProfile, $header);
        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'User updated successfully',
            ]);
    }

    public function testUpdateUserPasswordReturnFail()
    {
        $fakeProfile = [
            'profile_id' => '34486aa4-55d2-4dbe-ab0d-0d2fffaf441a',
            'password' => 'Senhasegura123',
        ];
        $header = [
            'token' => env('API_TOKEN')
        ];
        $response = $this->patchJson(route('profile.update'), $fakeProfile, $header);
        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'Not possible update user data',
            ]);
    }

    public function testUpdateUserProfileNameAndBioSuccess()
    {
        $fakeProfile = [
            'profile_id' => '34486aa4-55d2-4dbe-ab0d-0d2fffaf441a',
            'name' => 'Ete Valdo',
            'bio' => '🌸 Oiê! Bem-vindos ao meu universo artístico! Sou uma artista apaixonada por desenhar e pintar animais. Aqui, cada traço é uma jornada pela fauna, e cada cor conta uma história selvagem. Vamos explorar juntos esse reino encantado onde a imaginação e a natureza se encontram! 🐾✨',
        ];
        $header = [
            'token' => env('API_TOKEN')
        ];
        $response = $this->patchJson(route('profile.update'), $fakeProfile, $header);
        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'User updated successfully',
            ]);
    }

    public function testGetProfileWithIdReturnSuccess()
    {
        $fakeProfile = [
            'profile_id' => '34486aa4-55d2-4dbe-ab0d-0d2fffaf441a',
        ];
        $header = [
            'token' => env('API_TOKEN')
        ];
        $response = $this->postJson(route('profile.my'), $fakeProfile, $header);
        $response
            ->assertStatus(200);
    }

    public function testGetProfileWithNoExistentProfileId()
    {
        $fakeProfile = [
            'profile_id' => '1',
        ];
        $header = [
            'token' => env('API_TOKEN')
        ];
        $response = $this->postJson(route('profile.my'), $fakeProfile, $header);
        $response
            ->assertStatus(404);
    }
}
