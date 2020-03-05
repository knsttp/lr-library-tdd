<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Book;

class BookTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    
    public function test_author_id_is_recorded() {
        Book::create([
            'title' => 'dsafds',
            'author_id' => 10,
        ]);
        
        $this->assertCount(1, Book::all());
    }
}
