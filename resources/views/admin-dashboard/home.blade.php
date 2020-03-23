@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">Book Check Out</div>
                <div class="card-body">
                    <form role="form" method="POST" action="/checkout">
                        {!! csrf_field() !!}
                        <div class="form-group row{{ $errors->has('user_id') ? ' has-error' : '' }}">
                            <label for="user_id" class="col-sm-2 col-form-label">User</label>
                            <div class="col-sm-10">
                                <select id="user_id" name="user_id" class="form-control">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                                </select>
                                @if ($errors->has('user_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('user_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row{{ $errors->has('book_id') ? ' has-error' : '' }}">
                            <label for="book_id" class="col-sm-2 col-form-label">Book</label>
                            <div class="col-sm-10">
                                <select id="book_id" name="book_id" class="form-control">
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                                @endforeach
                                </select>
                                @if ($errors->has('book_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('book_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
                                <td><a class="btn btn-primary" href="{{ url('/checkin/'.$reservation->book->id.'/'.$reservation->user->id) }}">Return book</a></td>
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
