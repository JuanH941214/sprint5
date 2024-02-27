<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Play;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class PlayTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */

     public function testPlayCanBeSave(){
        $response = $this->post('api/login',[
            "email"=>"gkuphal@example.com",
            "password"=>"password"
        ]);
        $token=$response->json('token');
        $user = auth()->user();
        $userId = $user->id;
        $initialCount=DB::table('play')->count();
        $response = $this->withHeaders(['Authorization'=> 'Bearer ' . $token])
            ->post('/api/players/' . $userId . '/games', [
            ]);
        $this->assertDatabaseCount('play',$initialCount+1);    


    } 
    public function testGameCanBePlayed(): void
    {
        $response = $this->post('/api/login', [
            "email" => "gkuphal@example.com",
            "password" => "password"
        ]);
        $user = auth()->user();
        $token = $response->json('token');
        $userId = $user->id;
        $response = $this->withHeaders(['Authorization'=> 'Bearer ' . $token])
            ->post('/api/players/' . $userId . '/games', [
                'diceOne' => 4,
                'diceTwo' => 1,
                'result' => 5,
                'user_id' => $userId,
            ]);
        $data = $response->json();
        $diceOne = $data['diceOne'];
        $diceTwo = $data['diceTwo'];
        $result = $data['result'];
        $expectedResult = $diceOne + $diceTwo;
        $response->assertOk();
        $response->assertJson([
            "result" => $expectedResult,
        ]);

    }

    public function testGameCanCreateRandomNumbers(): void
    {
        $response = $this->post('/api/login', [
            "email" => "gkuphal@example.com",
            "password" => "password"
        ]);
        $user = auth()->user();
        $token = $response->json('token');
        $userId = $user->id;
        $response = $this->withHeaders(['Authorization'=> 'Bearer ' . $token])
            ->post('/api/players/' . $userId . '/games', [
            ]);
        $responseData = $response->decodeResponseJson();
        $this->assertGreaterThanOrEqual(1, $responseData['diceOne']);
        $this->assertLessThanOrEqual(6, $responseData['diceOne']);        
        
        $this->assertGreaterThanOrEqual(1, $responseData['diceTwo']);
        $this->assertLessThanOrEqual(6, $responseData['diceTwo']);
    }

    public function testGameCanHavePlayerRole(){
        $response = $this->post('api/login',[
            "email"=>"gkuphal@example.com",
            "password"=>"password"
        ]);
        $token=$response->json('token');
        $user = auth()->user();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('player'));
    }
    public function testGameCanHaveAdminRole(){
        $response = $this->post('/api/login',[
            "email"=>"joancl@gmail.com",
            "password" => "password"
        ]);
        $token=$response->json('token');
        $user = auth()->user();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('admin'));
    }

    public function testCanShowAPlayer(): void
    {
        $response = $this->post('/api/login',[
            "email"=>"gkuphal@example.com",
            "password"=>"password"
        ]);
        $user = auth()->user();
       // $response->dd();
        $token = $response->json('token');
        $userId = $user->id;
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
        ->get('/api/players/21');   
       // $response->dd();
        $response->assertOk();
        $response->assertJson([
            "plays" => [],
            "status" => true
        ]);
    }
    public function testPlayerCanDeleteItsGames(): void
    {
        $response = $this->post('/api/login', [
            "email" => "gkuphal@example.com",
            "password" => "password"
        ]);
        $user = auth()->user();
        $token = $response->json('token');
        $userId = $user->id;
        $this->beginDatabaseTransaction();
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->delete('/api/players/21/games');
        $response->assertOk();
        $response->assertJson(["status" => 'all your plays have been deleted ',]);
        $this->assertDatabaseMissing('play', ['user_id' => $userId]);
    }


    public function testCanCreateUser()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123', 
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
    }
}
