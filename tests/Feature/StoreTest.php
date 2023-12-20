<?php

namespace Tests\Feature;

use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testHasntStore(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get('/store')
        ->assertRedirect('/store/onboarding')->assertStatus(302);;
    }
    public function testCreateStore(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post('/store',[
            'name'=>'inu',
            'address'=>'enog'
        ])
        ->assertRedirect('/store')->assertStatus(302);;
    }
    public function testHasStore()
    {
        $user = User::factory()->create();
        Store::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);
    
        $this->get('/store')->assertStatus(200);

    }
    public function testEditStore()
    {
        $user = User::factory()->create();
        $store=Store::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $this->patch("/store/$store->id",[
            'name'=>'inu',
            'address'=>'jalan mawar'
        ])->assertStatus(302);
    }
}
