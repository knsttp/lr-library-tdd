<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Author;
use App\User;

class AuthorManagmentTest extends TestCase
{
    
    use RefreshDatabase;
    use WithFaker;
    
    private function data(){
        return [
            'name' => $this->faker->name,
            'dob' => $this->faker->date('m/d/Y')
        ];
    }
    
    public function test_author_dob_is_required(){
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('/authors', array_merge($this->data(), ['dob' => '']));
        $response->assertSessionHasErrors('dob');
    }
    
    public function test_author_name_is_required(){
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('/authors', array_merge($this->data(), ['name' => '']));
        $response->assertSessionHasErrors('name');
    }
    
    public function test_author_can_be_created() {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('/authors', $this->data());
        $author = Author::first();
        
        $this->assertCount(1, Author::all() );
        
        $response->assertRedirect('/author/'.$author->id);
    }
    
}
