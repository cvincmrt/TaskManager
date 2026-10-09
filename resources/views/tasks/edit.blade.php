@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0">Uprav ulohu {{ $task->title }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Názov úlohy -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Názov úlohy *</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $task->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Popis -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Popis</label>
                        <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="row">
                        <!-- Riešiteľ -->
                        <div class="col-md-6 mb-3">
                            <label for="assigned_to_id" class="form-label">Priradiť riešiteľovi</label>
                            <select name="assigned_to_id" id="assigned_to_id" class="form-select">
                                <option value="">-- Bez priradenia --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to_id', $task->assigned_to_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Priorita -->
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">Priorita</label>
                            <select name="priority" id="priority" class="form-select">
                                <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Nízka</option>
                                <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Stredná</option>
                                <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>Vysoká</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Stav -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Stav</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" {{ old('status', $task->status, 'pending') == 'pending' ? 'selected' : '' }}>Čaká (Pending)</option>
                                <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>V riešení</option>
                                <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Dokončená</option>
                            </select>
                        </div>

                        <!-- Termín (Deadline) -->
                        <div class="col-md-6 mb-3">
                            <label for="deadline" class="form-label">Termín (Deadline)</label>
                            <input type="date" name="deadline" id="deadline" class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline', $task->deadline) }}">
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Tlačidlá -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Zrušiť</a>
                        <button type="submit" class="btn btn-success">Uložiť zmeny</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
