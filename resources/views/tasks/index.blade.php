@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Zoznam úloh</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Pridať úlohu</a>
    </div>

    <div class="card mb-3 p-3 bg-light">
        <form method="GET" action="{{ route('tasks.index') }}" class="row g-2 align-items-center">
            <div class="col-auto">
                <label for="status" class="col-form-label fw-bold">Stav:</label>
            </div>
            <div class="col-auto">
                <select name="status" id="status" class="form-select">
                    <option value="">-- Všetky stavy --</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Čaká (Pending)</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>V riešení</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Dokončená</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-secondary">Filtrovať</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>


    <ul class="list-group">
        @foreach ($tasks as $task)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>
                        <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none">
                            {{ $task->title }}
                        </a>
                    </strong>
                    <div class="text-muted small">
                        Rieši: {{ $task->assignee?->name ?? 'Nepriradené' }} | Zadal: {{ $task->creator->name }}
                    </div>
                </div>
                <div>
                    <span class="badge bg-secondary">{{ $task->status }}</span>
                    <span class="badge bg-info text-dark">{{ $task->priority }}</span>
                   
                    @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary ms-2">Upraviť</a>
                   @endcan 
                   
                   @can('delete', $task)
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline" onsubmit="return confirm('Naozaj chceš túto úlohu zmazať?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger ms-1">Zmazať</button>
                    </form>
                    @endcan
                </div>
            </li>
        @endforeach
    </ul>
    <div class="mt-3">
        {{ $tasks->links() }}
    </div>

@endsection
