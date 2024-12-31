<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $header = [
            'token' => env('API_TOKEN')
        ];
        $response = $this->get('v1/', $header);
        $response->assertStatus(200);
    }
}
