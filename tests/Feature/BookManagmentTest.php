<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Book;

class BookManagmentTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;
    
    public function test_book_can_be_created(){
        
        $response = $this->post('/books',[
            'title'  => $this->faker->sentence(3),
            'author' => $this->faker->name,
        ]);
        $book = Book::first();
        
        $this->assertCount(1, Book::all());
        $response->assertRedirect('/books/'.$book->id);
    }

    public function test_book_can_be_read(){
        $this->post('/books',[
            'title'  => $this->faker->sentence(3),
            'author' => $this->faker->name,
        ]);
        $book = Book::first();
        
        $response = $this->get('/books/'.$book->id);
        $response->assertSeeText($book->title);
    }

    public function test_book_can_be_delete(){
        $this->post('/books',[
            'title'  => $this->faker->sentence(3),
            'author' => $this->faker->name,
        ]);
        $book = Book::first();
        $this->assertCount(1, Book::all());
        
        $response = $this->delete('/books/'.$book->id);
        $this->assertCount(0, Book::all());
        
        $response->assertRedirect('/books');
    }
    
    public function test_book_can_be_updated(){
        
        $this->withoutExceptionHandling();
        
        $this->post('/books',[
            'title'  => 'Cool Book Title',
            'author' => 'Victor',
        ]);
        $book = Book::first();
        
        $response = $this->patch('/books/'.$book->id,[
            'title'  => 'New title',
            'author' => 'New author',
        ]);
        
        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New author', Book::first()->author);
        
        $response->assertRedirect('/books/'.$book->id);
    }    
    
    public function test_book_title_is_required(){
        
        $response = $this->post('/books',[
            'title'  => '',
            'author' => 'Victor',
        ]);
        $response->assertSessionHasErrors('title');
    }
    
    public function test_book_author_is_required(){
        
        $response = $this->post('/books',[
            'title'  => 'Cool Book Title',
            'author' => '',
        ]);
        $response->assertSessionHasErrors('author');
    }
    
}
