@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0">Vytvoriť novú úlohu</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <!-- Názov úlohy -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Názov úlohy *</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Popis -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Popis</label>
                        <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <div class="row">
                        <!-- Riešiteľ -->
                        <div class="col-md-6 mb-3">
                            <label for="assigned_to_id" class="form-label">Priradiť riešiteľovi</label>
                            <select name="assigned_to_id" id="assigned_to_id" class="form-select">
                                <option value="">-- Bez priradenia --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Priorita -->
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">Priorita</label>
                            <select name="priority" id="priority" class="form-select">
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Nízka</option>
                                <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Stredná</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Vysoká</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Stav -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Stav</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Čaká (Pending)</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>V riešení</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Dokončená</option>
                            </select>
                        </div>
                        <!-- Termín (Deadline) -->
                        <div class="col-md-6 mb-3">
                            <label for="deadline" class="form-label">Termín (Deadline)</label>
                            <input type="date" name="deadline" id="deadline" class="form-control" value="{{ old('deadline') }}">
                        </div>
                    </div>
                    <!-- Tlačidlá -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Zrušiť</a>
                        <button type="submit" class="btn btn-success">Uložiť úlohu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
