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
        $admin = factory(User::class)->create(['is_admin'=>1]);
        $user = factory(User::class)->create();
        
        $this->actingAs($admin)->postJson('/checkout', ['book_id' => $book->id, 'user_id' => $user->id]);
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
        $user  = factory(User::class)->create();
        $admin  = factory(User::class)->create(['is_admin'=>1]);
        $this->actingAs($admin)->postJson('/checkout', ['book_id' => $book->id, 'user_id' => $user->id]);
        $this->actingAs($admin)->postJson('/checkout', ['book_id' => $book2->id, 'user_id' => $user->id]);
        $this->actingAs($admin)->get('/checkin/'.$book->id.'/'.$user->id); 
        
        $response = $this->actingAs($user)->get('/history');
        $response->assertSuccessful();
        $response->assertSeeTextInOrder([$book->title, $book2->title]);
    }
    
}
