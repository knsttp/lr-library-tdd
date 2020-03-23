<?php

namespace Tests\Feature;

use App\Book;
use App\Reservation;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;
    
    public function test_admin_dashboard_show_all_books_to_be_returned(){
        // $this->withoutExceptionHandling();
        $admin = factory(User::class)->create(['is_admin'=>1]);
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $book1 = factory(Book::class)->create();
        $book2 = factory(Book::class)->create();

        $this->actingAs($admin)->postJson('/checkout', ['book_id' => $book1->id, 'user_id' => $user1->id]);
        $this->actingAs($admin)->postJson('/checkout', ['book_id' => $book2->id, 'user_id' => $user2->id]);

        $this->actingAs($admin)->get('/checkin/'.$book2->id.'/'.$user2->id);

        $this->assertCount(2, Reservation::all());
        $this->assertCount(1, Reservation::whereNull('checked_in_at')->get());

        $response = $this->actingAs($admin)->get('/home');
        $response->assertSuccessful();
        $response->assertSee($user1->name);
        $response->assertSeeText($book1->title);
        $response->assertDontSee($book2->title.'</a></td>', false);
    }

}
