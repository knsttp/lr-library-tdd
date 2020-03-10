@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Actions</th>
                    </tr>
                </thead>    
                <tbody>
                @foreach ($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author->name }}</td>
                    <td>
                        @auth
                        <a href="{{ url('/checkout/'.$book->id) }}" class="btn btn-primary">Check Out</a>
                        <a href="{{ url('/checkin/'.$book->id) }}" class="btn btn-primary">Check In</a>
                        @endauth
                        <a href="{{ url('/books/'.$book->id) }}" class="btn btn-primary">Details</a>
                    </td>
                </tr>
                @endforeach
                </tbody>    
            </table>
        </div>
    </div>
</div>
@endsection
