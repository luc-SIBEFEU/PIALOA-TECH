<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Tests\TestCase;

class ServiceFormTest extends TestCase
{
    public function test_edit_service_form_keeps_the_current_icon_selected(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $service = Service::create([
            'nom' => 'Audit numérique',
            'description' => 'Audit complet de votre présence digitale.',
            'icone' => 'code-slash',
        ]);

        $this->actingAs($user)
            ->get(route('admin.services.edit', $service))
            ->assertOk()
            ->assertSee('value="code-slash" selected');
    }
}
