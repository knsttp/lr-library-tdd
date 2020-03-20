<?php

use Illuminate\Database\Seeder;
use App\Reservation;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Reservation::class)->create(['user_id' => 2, 'book_id' => 1, 'checked_out_at' => '2019-12-09 09:04:02', 'checked_in_at' => '2019-12-15 11:15:35']);
        factory(Reservation::class)->create(['user_id' => 2, 'book_id' => 3, 'checked_out_at' => '2020-01-02 13:44:02']);
        factory(Reservation::class)->create(['user_id' => 2, 'book_id' => 6, 'checked_out_at' => '2020-01-15 08:44:02', 'checked_in_at' => '2020-01-25 08:15:35']);
        factory(Reservation::class)->create(['user_id' => 2, 'book_id' => 7, 'checked_out_at' => '2020-02-20 16:35:02', 'checked_in_at' => '2020-02-27 13:06:35']);
        factory(Reservation::class)->create(['user_id' => 2, 'book_id' => 4, 'checked_out_at' => '2020-03-09 12:02:44', 'checked_in_at' => '2020-03-12 12:27:05']);
        factory(Reservation::class)->create(['user_id' => 2, 'book_id' => 2, 'checked_out_at' => '2020-03-01 12:02:44', 'checked_in_at' => '2020-03-12 12:27:05']);
        factory(Reservation::class)->create(['user_id' => 2, 'book_id' => 9, 'checked_out_at' => '2020-02-10 08:51:44']);
        factory(Reservation::class)->create(['user_id' => 2, 'book_id' => 8, 'checked_out_at' => '2020-02-10 09:11:44']);
    }
}
