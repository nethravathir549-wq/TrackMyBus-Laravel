<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_passengers_are_redirected_to_tracking(): void
    {
        $user = User::factory()->create([
            'role' => 'passenger',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertRedirect(route('tracking'));
    }

    public function test_drivers_are_redirected_to_driver_page(): void
    {
        $user = User::factory()->create([
            'role' => 'driver',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertRedirect(route('driver'));
    }

    public function test_admins_are_redirected_to_admin_page(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertRedirect(route('admin'));
    }
}