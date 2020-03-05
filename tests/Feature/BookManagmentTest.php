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
    
    public function book_data(){
        return [
            'title' => $this->faker->sentence(3),
            'author_id' => 11,
        ];
    }
    
    public function test_book_can_be_created(){
        $this->withExceptionHandling();
        $response = $this->post('/books',$this->book_data() );
        $book = Book::first();
        
        $this->assertCount(1, Book::all());
        $response->assertRedirect('/books/'.$book->id);
    }

    public function test_book_can_be_read(){
        $this->post('/books',$this->book_data() );
        $book = Book::first();
        
        $response = $this->get('/books/'.$book->id);
        $response->assertSeeText($book->title);
    }

    public function test_book_can_be_delete(){
        $this->post('/books',$this->book_data() );
        $book = Book::first();
        $this->assertCount(1, Book::all());
        
        $response = $this->delete('/books/'.$book->id);
        $this->assertCount(0, Book::all());
        
        $response->assertRedirect('/books');
    }
    
    public function test_book_can_be_updated(){
        
        $this->withoutExceptionHandling();
        
        $this->post('/books',$this->book_data());
        $book = Book::first();
        
        $response = $this->patch('/books/'.$book->id,[
            'title'  => 'New title',
            'author_id' => 6,
        ]);
        
        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals(6, Book::first()->author_id);
        
        $response->assertRedirect('/books/'.$book->id);
    }    
    
    public function test_book_title_is_required(){
        
        $response = $this->post('/books', array_merge($this->book_data(), ['title' => '']));
        $response->assertSessionHasErrors('title');
    }
    
    public function test_book_author_is_required(){
        
        $response = $this->post('/books', array_merge($this->book_data(), ['author_id' => '']));
        $response->assertSessionHasErrors('author_id');
    }
    
}
