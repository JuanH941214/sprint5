<?php

namespace Tests\Feature;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;


class UserTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     */

    
    public function testCanLogin(): void
    {

        $response = $this->post('api/login',[
            "email"=>"joancl@gmail.com",
            "password"=>"password"
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['token']);
        //$this->assertAuthenticated;

    }

    public function testCanLogOut(): void
    {
        $response = $this->post('api/login',[
            "email"=>"joancl@gmail.com",
            "password"=>"password"
        ]);
        $token= $response->json('token');
        $this->assertNotNull($token);
        $response = $this->withHeaders(['Authorization' =>'Bearer ' . $token])
        ->post('/api/logout');
        //$response->dd();
        $response->assertOk();
    }
/*
    public function testCanCreateUser()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123', // 
        ];

        $response = $this->json('POST', '/api/users', $userData);

        $response->assertStatus(201)
                 ->assertJson([
                    'status' => true,
                    'message' => 'user created successfully!',
                 ]);

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
        ]);
    }*/


    public function testUserCreationWithAnonymousNickname()
    {
        $userData = [
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
        ];

        $response = $this->post('/api/register', $userData);

        $response->assertStatus(201)
            ->assertJson([
                'status' => true,
                'message' => 'user created succesfully!',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'nick_name' => 'Anonymous',
        ]);
    }

    public function testUserCreationWithCustomNickname()
    {
        $userData = [
            'nick_name' =>  $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
        ];

        $response = $this->post('/api/register', $userData);

        $response->assertStatus(201)
            ->assertJson([
                'status' => true,
                'message' => 'user created succesfully!',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'nick_name' => $userData['nick_name']
        ]);
    }
 




}
