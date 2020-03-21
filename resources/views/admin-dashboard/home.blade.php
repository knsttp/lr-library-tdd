@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Books to return</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <td>Book</td>
                                <td>User</td>
                                <td>Checked Out At</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $reservation)
                            <tr>
                                <td><a href="{{ url('/books/'.$reservation->book->id) }}">{{ $reservation->book->title }}</a></td>
                                <td>{{ $reservation->user->name }}</td>
                                <td>{{ $reservation->checked_out_at }}</td>
                                <td><a class="btn btn-primary" href="{{ url('/checkin/'.$reservation->book->id) }}">Return book</a></td>
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
