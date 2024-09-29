@extends('users.layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card" style="background-color: rgba(0, 0, 0, 0.45);">
            <div class="card-body">
                <h2>Register</h2>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number:</label>
                        <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="pin">PIN:</label>
                        <input type="password" class="form-control" name="pin" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
@endsection
