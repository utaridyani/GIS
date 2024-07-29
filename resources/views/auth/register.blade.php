@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="register-container">
        <h2 class="text-center">Register</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            @if($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '{{ $errors->first() }}',
                    });
                </script>
            @endif

            {{-- @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '{{ session('success') }}',
                    });
                </script>
            @endif --}}

            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
            <div style="text-align: center; font-size: 11px">
                <p>Sudah memiliki akun? <a href="{{ route('login') }}">Login disini</a></p>
            </div>
        </form>
    </div>
@endsection
