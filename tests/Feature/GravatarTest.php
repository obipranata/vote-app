<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;

class GravatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_generate_grafatar_image_when_no_email_found(){
        $user = User::factory()->create([
            'name' => 'Obito',
            'email' => 'test@example.com',
        ]);

        $gravatarUrl = $user->getAvatar();
        $this->assertEquals(
            'https://www.gravatar.com/avatar/'.md5($user->email).'?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-20.png',
            $gravatarUrl
        );
    }

    /** @test */
    public function user_can_generate_grafatar_image_when_no_email_found_first_character_a(){
        $user = User::factory()->create([
            'name' => 'Obito',
            'email' => 'atest@example.com',
        ]);

        $gravatarUrl = $user->getAvatar();
        $this->assertEquals(
            'https://www.gravatar.com/avatar/'.md5($user->email).'?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-1.png',
            $gravatarUrl
        );

        $response = Http::get($user->getAvatar());

        $this->assertTrue($response->successful());
    }
}
