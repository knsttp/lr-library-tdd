<?php

namespace Tests\Feature;

use App\Book;
use App\Reservation;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BookManagmentTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;
    
    private function data(){
        return [
            'title' => $this->faker->sentence(3),
            'author_id' => 11,
        ];
    }
    
    public function test_book_can_be_created(){
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('/books',$this->data() );
        $book = Book::first();
        
        $this->assertCount(1, Book::all());
        $response->assertRedirect('/books/'.$book->id);
    }
    
    public function test_unsigned_user_can_see_books(){
        $books = factory(Book::class,10)->create();
        $this->assertCount(10, Book::all());
        $this->get('/')->assertSee($books[0]->title);
    }

    public function test_book_can_be_read(){
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('/books',$this->data() );
        $book = Book::first();
        
        $response = $this->get('/books/'.$book->id);
        $response->assertSeeText($book->title);
    }

    public function test_book_can_be_delete(){
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('/books',$this->data() );
        $book = Book::first();
        $this->assertCount(1, Book::all());
        
        $response = $this->delete('/books/'.$book->id);
        $this->assertCount(0, Book::all());
        
        $response->assertRedirect('/books');
    }
    
    public function test_book_can_be_updated(){
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('/books',$this->data());
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
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('/books', array_merge($this->data(), ['title' => '']));
        $response->assertSessionHasErrors('title');
    }
    
    public function test_book_author_is_required(){
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('/books', array_merge($this->data(), ['author_id' => '']));
        $response->assertSessionHasErrors('author_id');
    }
    
    public function test_book_can_be_checked_out_by_signed_in_user() {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        $admin = factory(User::class)->create(['is_admin'=>1]);
        $response = $this->actingAs($admin)->get('/checkout/'.$book->id.'/'.$user->id);     
        $this->assertCount(1, Reservation::all());
        $reservation = Reservation::where('book_id',$book->id)->where('user_id',$user->id)->first();
        $this->assertEquals( $user->id, $reservation->user_id );
        $this->assertEquals( $book->id, $reservation->book_id );
        $this->assertNotNull( $reservation->checked_out_at );
        $response->assertRedirect('/books');
    }
    
    public function test_if_multiple_checked_out_exception_is_thrown(){
        
        $this->expectException(\Exception::class);
        
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        $book->checkout($user);
        $book->checkout($user);
    }    
    
    public function test_if_not_checked_out_exception_is_thrown(){
        
        $this->expectException(\Exception::class);
        
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        
        $book->checkin($user);
    }    
    
    public function test_book_cant_be_checked_out_without_authorization() {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        $response = $this->get('/checkout/'.$book->id.'/'.$user->id);     
        $response->assertRedirect('/login');
    }
    
    public function test_only_admin_can_checkin_book(){
        $user = factory(User::class)->create();
        $admin = factory(User::class)->create(['is_admin'=>1]);
        $book = factory(Book::class)->create();
        $this->actingAs($admin)->get('/checkout/'.$book->id.'/'.$user->id);
        
        Auth::logout();
        
        $this->get('/checkin/'.$book->id.'/'.$user->id)->assertRedirect('/login');
        $this->assertCount(1, Reservation::all());
        $this->assertNull(Reservation::first()->checked_in_at);
        
    }
    
    public function test_404_if_book_isnt_checked_out_first() {
        $this->withoutExceptionHandling();
        $book = factory(Book::class)->create();
        $admin = factory(User::class)->create(['is_admin'=>1]);
        $user = factory(User::class)->create();
        
        $response = $this->actingAs($admin)->get('/checkin/'.$book->id.'/'.$user->id);
        $response->assertStatus(404);
    }
    
    public function test_unknown_book_cant_be_checkout() {
        $user = factory(User::class)->create();
        $book_id = 123;
        $response = $this->actingAs($user)->get('/checkout/'.$book_id);     
        $response->assertStatus(404);
    }
    
}
