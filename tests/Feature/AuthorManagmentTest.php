<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Author;

class AuthorManagmentTest extends TestCase
{
    
    use RefreshDatabase;
    use WithFaker;
    
    public function test_author_can_be_created() {
        $this->withoutExceptionHandling();
        
        $response = $this->post('/author',[
            'name' => $this->faker->name,
            'dob' => $this->faker->date('m/d/Y')
        ]);
        $author = Author::first();
        
        $this->assertCount(1, Author::all() );
        
        $response->assertRedirect('/author/'.$author->id);
    }
    
}
