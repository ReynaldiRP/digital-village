<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_read_users_data(): void
    {
        $response = $this->getJson('/api/users');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data'
            ]);
    }

    public function test_read_users_data_with_search_query_and_limit(): void
    {
        User::factory()->create(
            ['name' => 'John Doe']
        );

        $response = $this->getJson('/api/users?search=John&limit=5');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data'
            ])
            ->assertJsonFragment(['name' => 'John Doe'])
            ->assertJsonCount(1, 'data');
    }

    public function test_read_users_data_paginated(): void
    {
        User::factory()->count(10)->create();

        $response = $this->getJson('/api/users/all/paginated?row_per_page=5&page=2');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'items',
                    'meta'
                ]
            ])
            ->assertJsonCount(5, 'data.items')
            ->assertJsonFragment(['current_page' => 2]);
    }

    public function test_read_empty_users_data(): void
    {
        $response = $this->getJson('/api/users');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data'
            ])
            ->assertJsonCount(0, 'data');
    }

    public function test_create_user_data(): void
    {
        $userData = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->postJson('/api/users', $userData);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'email'
                ]
            ])
            ->assertJsonFragment([
                'data' => [
                    'id' => $response['data']['id'],
                    'name' => $userData['name'],
                    'email' => $userData['email']
                ]
            ]);
    }

    public function test_create_user_data_not_filled_required_fields(): void
    {
        $userData = [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => ''
        ];

        $response = $this->postJson('/api/users', $userData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_create_user_data_with_invalid_email_format(): void
    {
        $userData = [
            'name' => 'Jane Doe',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->postJson('/api/users', $userData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_create_user_data_with_duplicate_email(): void
    {
        User::factory()->create([
            'email' => 'jane.doe@example.com'
        ]);

        $userData = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->postJson('/api/users', $userData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_create_user_data_with_non_matching_password_confirmation(): void
    {
        $userData = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password456'
        ];

        $response = $this->postJson('/api/users', $userData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_create_user_data_with_too_short_password(): void
    {
        $userData = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => 'pass',
            'password_confirmation' => 'pass'
        ];

        $response = $this->postJson('/api/users', $userData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_view_user_by_id(): void
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'email'
                ]
            ])
            ->assertJsonFragment([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ]);
    }

    public function test_view_user_by_non_existent_id(): void
    {
        $response = $this->getJson('/api/users/999');
        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Data User Tidak Ditemukan',
                'data' => null
            ]);
    }

    public function test_update_user_data(): void
    {
        $user = User::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated.email@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ];

        $response = $this->putJson("/api/users/{$user->id}", $updateData);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Data User Berhasil Diupdate',
                'data' => [
                    'id' => $user->id,
                    'name' => 'Updated Name',
                    'email' => 'updated.email@example.com'
                ]
            ]);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated.email@example.com'
        ]);
    }

    public function test_update_user_data_with_non_existent_id(): void
    {
        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated.email@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ];

        $response = $this->putJson("/api/users/999", $updateData);
        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Data User Tidak Ditemukan',
                'data' => null
            ]);
        $this->assertDatabaseMissing('users', [
            'name' => 'Updated Name',
            'email' => 'updated.email@example.com'
        ]);
    }

    public function test_update_user_data_with_invalid_email_format(): void
    {
        $user = User::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'invalid-email',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ];

        $response = $this->putJson("/api/users/{$user->id}", $updateData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'email' => 'invalid-email'
        ]);
    }

    public function test_update_user_data_with_duplicate_email(): void
    {
        $user1 = User::factory()->create([
            'email' => 'user1@example.com'
        ]);

        $user2 = User::factory()->create([
            'email' => 'user2@example.com'
        ]);

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'user1@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ];

        $response = $this->putJson("/api/users/{$user2->id}", $updateData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
        $this->assertDatabaseMissing('users', [
            'id' => $user2->id,
            'email' => 'user1@example.com'
        ]);
    }

    public function test_delete_user_data(): void
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");
        $response->assertStatus(204);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_delete_user_data_with_non_existent_id(): void
    {
        $response = $this->deleteJson('/api/users/999');
        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Data User Tidak Ditemukan',
                'data' => null
            ]);
    }
}
