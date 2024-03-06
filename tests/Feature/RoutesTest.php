<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class RoutesTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testPlayerRoleTryingToBeAdmin(){
        $response = $this->post('api/login',[
            "email"=>"gkuphal@example.com",
            "password"=>"password"
        ]);
        $user = auth()->user();
        $token = $response->json('token');
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
        ->get('/api/players');  
        $response->assertStatus(403);

    }
    
    public function testAdminTryingToBePlayer(){
        $response = $this->post('api/login',[
            "email"=>"joancl@gmail.com",
            "password"=>"password"
        ]);
        $user = auth()->user();
        $token = $response->json('token');
        //dd($token);
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
        ->get('/api/players/'.$user->id); 
        //$response->dd(); 
        $response->assertStatus(403);

    }   

    
}
