@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0 text-center">Registrácia</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Meno -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Meno a priezvisko</label>
                        <input type="text" name="name" id="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mailová adresa</label>
                        <input type="email" name="email" id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Heslo -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Heslo (min. 8 znakov)</label>
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Potvrdenie hesla -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Potvrdenie hesla</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="form-control" required>
                    </div>

                    <!-- Tlačidlo -->
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Zaregistrovať sa</button>
                    </div>

                    <div class="text-center mt-3">
                        <small>Už máš účet? <a href="{{ route('login') }}">Prihlás sa tu</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
