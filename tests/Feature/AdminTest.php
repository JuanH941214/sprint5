<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\User;
use App\Models\Play;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;

class AdminTest extends TestCase
{
   //
    /**
     * A basic feature test example.
     */
    public function testAdminCanSeePlayers(): void
    {
        $response = $this->post('/api/login',[
            "email"=>"joancl@gmail.com",
            "password"=>"password"
        ]);
        $user = auth()->user();
        $token = $response->json('token');
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
        ->get('/api/players');   
         //$response->dd();
        $response->assertOk();
        $response->assertJson([
            "users" => [],
            "status" => true
        ]);
    }

    public function testAdminCanSeeRanking(): void
    {
        $response = $this->post('/api/login',[
            "email"=>"joancl@gmail.com",
            "password"=>"password"
        ]);
        $user = auth()->user();
        $token = $response->json('token');
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
        ->get('/api/players/ranking');   
         //$response->dd();
        $response->assertOk();
        $response->assertJson([
            "ranking" => [],
            "status" => true
        ]);
    }
    /*
    public function testCanCalculatePlaysWonPerPlayer(): void
    { 
    $user=User::factory()->create();
     Play::factory(5)->create(['user_id' => $user->id, 'result' => 7]);
     //dd(Play::where('user_id', $user->id)->get());
     $result = $this->gamesWonPerPlayer($user->id);
     $this->assertEquals(5, $result);

    }*/

    public function gamesWonPerPLayer($id)
    {
        
        $user= User::find($id);
        $totalPlays= Play::where('user_id',$user->id)->where('result',7)->count();
        if($totalPlays){
            return $totalPlays;
        }
        else {
            return 0;
        }   
    }


    public function testUserCanUpdateNickName()
    {
        $name=\Faker\Factory::create()->name;
        $this->assertDatabaseMissing('users', [
            'nick_name' => $name,
        ]);  
        $response = $this->post('/api/login', [
            "email" => "gkuphal@example.com",
            "password" => "password"
        ]);
        $user = auth()->user();
        $token = $response->json('token');
        $userId = $user->id;
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->put('/api/players/' . $userId,['nick_name' => $name]);
        $userToUpdate = User::find($userId); 
        $response->assertOk();     
        $this->assertDatabaseHas('users', [
            'nick_name' => $name,
        ]);    
        

    }
    public function testHighestWinRate(): void
    { 
        $response = $this->post('/api/login',[
            "email"=>"joancl@gmail.com",
            "password"=>"password"
        ]);
        $userId = auth()->user();
        $token = $response->json('token');
        $maxValueWinRate=DB::table('users')->max('win_rate');
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
        ->get('/api/players/ranking/winner');
        $tableResult=$response->json('win_rate');
       // $response->dd();
        assertSame($maxValueWinRate,$tableResult);

    }

    public function testLowesttWinRate(): void
    { 
        $response = $this->post('/api/login',[
            "email"=>"joancl@gmail.com",
            "password"=>"password"
        ]);
        $userId = auth()->user();
        $token = $response->json('token');
        $minValueWinRate=DB::table('users')->min('win_rate');
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
        ->get('/api/players/ranking/lowest');
        $tableResult=$response->json('win_rate');
       // $response->dd();
        assertSame($minValueWinRate,$tableResult);

    }

}
