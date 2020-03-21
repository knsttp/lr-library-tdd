<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Book;
use App\User;
use App\Reservation;

class BookReservationTest extends TestCase
{

    use WithFaker;
    use RefreshDatabase;
    
    public function test_book_can_checked_out() {
        $book = factory(Book::class)->create([
            'author_id' => 123
        ]);
        $user = factory(User::class)->create();
        $book->checkout($user);
        
        $this->assertCount(1, Reservation::all());
        $this->assertEquals( $user->id, Reservation::first()->user_id );
        $this->assertEquals( $book->id, Reservation::first()->book_id );
        $this->assertEquals(now(), Reservation::first()->checked_out_at );
    }
    
    public function test_book_can_checked_in() {
        $book = factory(Book::class)->create([
            'author_id' => 123
        ]);
        $user = factory(User::class)->create();
        $book->checkout($user);
        $book->checkin($user);
        
        $this->assertCount(1, Reservation::all());
        $this->assertEquals( $user->id, Reservation::first()->user_id );
        $this->assertEquals( $book->id, Reservation::first()->book_id );
        $this->assertNotNull( Reservation::first()->checked_in_at );
        $this->assertEquals(now(), Reservation::first()->checked_in_at );
    }
    
    public function test_book_can_checked_out_twice() {
        $this->withoutExceptionHandling();
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        
        $book->checkout($user);
        $book->checkin($user);
        
        $book->checkout($user);
        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::find(2)->user_id);
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertNull(Reservation::find(2)->checked_in_at);
        $this->assertEquals(now(), Reservation::find(2)->checked_out_at);
        
        $book->checkin($user);
        $this->assertNotNull(Reservation::find(2)->checked_out_at);
    }
    
}
