<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Author;

class AuthorTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    
    public function test_dob_is_nullable() {
        Author::firstOrCreate([
           'name' => $this->faker->name
        ]);
        
        $this->assertCount(1, Author::all());
    }
}
