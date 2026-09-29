@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Zoznam úloh</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Pridať úlohu</a>
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
                </div>
            </li>
        @endforeach
    </ul>
@endsection
