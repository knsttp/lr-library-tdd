<?php

namespace Tests\Feature;

use App\Book;
use App\Reservation;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserDashboardTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;
    
    public function test_dashboard_show_user_books_to_return(){
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create(['email'=>'user@example.com']);
        
        $this->actingAs($user)->get('/checkout/'.$book->id); 
        $this->assertCount(1, Reservation::all());
        $this->assertNull(Reservation::first()->checked_in_at);
        
        $response = $this->actingAs($user)->get('/home');
        $response->assertSuccessful();
        $response->assertSeeText($book->title);
    }
    
    public function test_dashboard_show_user_history(){
        $this->withoutExceptionHandling();
        $book  = factory(Book::class)->create();
        $book2 = factory(Book::class)->create();
        $user  = factory(User::class)->create(['email'=>'user@example.com']);
        $this->actingAs($user)->get('/checkout/'.$book->id); 
        $this->actingAs($user)->get('/checkout/'.$book2->id); 
        $this->actingAs($user)->get('/checkin/'.$book->id); 
        
        $response = $this->actingAs($user)->get('/history');
        $response->assertSuccessful();
        $response->assertSeeTextInOrder([$book->title, $book2->title]);
    }
    
}
