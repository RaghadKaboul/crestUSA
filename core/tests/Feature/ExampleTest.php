<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */

    use RefreshDatabase;
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->withServerVariables(['REMOTE_ADDR' => '127.0.0.1'])
            ->get('/');

        // التأكد من أن الاستجابة كانت ناجحة
        $response->assertStatus(200);
    }

}
