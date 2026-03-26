<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditUserRolesTest extends TestCase
{
    use RefreshDatabase; // Datenbank wird für jeden Test zurückgesetzt

    public function test_user_can_have_roles_assigned()
    {
        // Arrange: Benutzer & Rollen erstellen
        $user = User::factory()->create();
        $roles = Role::factory()->count(3)->create(); // Erstelle 3 Rollen

        // Act: API-Request simulieren
        $response = $this->actingAs($user)->post("/edit-user-roles/{$user->id}", [
            'options' => $roles->pluck('id')->toArray(),
        ]);

        // Assert: Datenbank prüfen
        $this->assertEquals($roles->pluck('id')->toArray(), $user->roles()->pluck('roles.id')->toArray());

        // Erfolgreiche Weiterleitung prüfen
        $response->assertRedirect()->assertSessionHas('msg', 'Rollen erfolgreich gesetzt!');
    }

    public function test_validation_fails_if_no_roles_are_provided()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post("/edit-user-roles/{$user->id}", [
            'options' => [], // Keine Rollen gesendet
        ]);

        // Prüfen, dass Validierung fehlschlägt
        $response->assertSessionHasErrors('options');
    }

    public function test_validation_fails_for_invalid_roles()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post("/edit-user-roles/{$user->id}", [
            'options' => ['99999'], // Ungültige Rollen-ID
        ]);

        $response->assertSessionHasErrors('options.0'); // Erste Rolle ist fehlerhaft
    }
}
