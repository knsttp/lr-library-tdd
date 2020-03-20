@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Book Reservation History</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Book Name</td><td>Checked Out At</td><td>Checked In At</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $reservation)
                            <tr>
                                <td><a href="{{ url('/books/'.$reservation->book->id) }}">{{ $reservation->book->title }}</a></td>
                                <td>{{ $reservation->checked_out_at }}</td>
                                <td>{{ $reservation->checked_in_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
