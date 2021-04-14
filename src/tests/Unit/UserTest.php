<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\Interfaces\UserInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private UserInterface $userService;
    private object $users;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make('App\Services\UserService');
        User::factory()->count(5)->create();
    }
    
    public function testGetAllUsers()
    {
        $users = $this->userService->getAll();

        $this->assertEquals(5, count($users));
    }
}
