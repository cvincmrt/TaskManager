@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4">Môj profil</h2>

        <!-- Karta 1: Osobné údaje -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Osobné informácie</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Meno -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Meno a priezvisko</label>
                        <input type="text" name="name" id="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mailová adresa</label>
                        <input type="email" name="email" id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Uložiť zmeny</button>
                </form>
            </div>
        </div>

        <!-- Karta 2: Zmena hesla -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Zmena hesla</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Aktuálne heslo -->
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Aktuálne heslo</label>
                        <input type="password" name="current_password" id="current_password" 
                               class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nové heslo -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Nové heslo (min. 8 znakov)</label>
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Potvrdenie nového hesla -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Potvrdenie nového hesla</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-warning">Zmeniť heslo</button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
