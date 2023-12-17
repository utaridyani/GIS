@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="login-container">
        <h2 class="text-center">Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
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

            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '{{ session('success') }}',
                    });
                </script>
            @endif
            
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
@endsection
