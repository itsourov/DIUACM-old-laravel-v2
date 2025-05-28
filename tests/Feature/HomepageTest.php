<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    /**
     * Test if homepage is accessible and contains welcome text.
     *
     * @return void
     */
    public function test_homepage_is_accessible_and_contains_welcome_text()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Welcome to DIUACM!');
    }
}
