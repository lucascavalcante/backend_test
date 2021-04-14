<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserResourceGet()
    {
        $response = $this->get('/api/users');

        $response->assertStatus(200);
    }

    public function testUserResourcePost()
    {
        $response = $this->post('/api/users');

        $response->assertStatus(400);
    }

    public function testUserResourcePut()
    {
        $response = $this->put('/api/users/1');

        $response->assertStatus(400);
    }

    public function testUserResourceDelete()
    {
        $response = $this->delete('/api/users/1');

        $response->assertStatus(204);
    }
}
