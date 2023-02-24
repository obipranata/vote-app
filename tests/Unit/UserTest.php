<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_check_if_user_is_an_admin(){
        $user = User::factory()->make([
            'name' => 'Obi',
            'email' => 'obi@gmail.com'
        ]);

        $userB = User::factory()->make([
            'name' => 'Isman',
            'email' => 'isman@gmail.com'
        ]);

        $this->assertTrue($user->isAdmin());
        $this->assertFalse($userB->isAdmin());
    }
}
