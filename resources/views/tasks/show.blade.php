@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">

        <!-- Tlačidlo Späť -->
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary mb-3">
            &larr; Späť na zoznam úloh
        </a>

        <!-- Karta s detailom úlohy -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h3 class="mb-0">{{ $task->title }}</h3>
                <div>
                    <!-- Stav -->
                    <span class="badge bg-secondary fs-6">{{ $task->status }}</span>
                    <!-- Priorita -->
                    <span class="badge bg-info text-dark fs-6 ms-1">{{ $task->priority }}</span>
                </div>
            </div>

            <div class="card-body">
                <!-- Popis -->
                <h6 class="text-muted fw-bold">Popis úlohy:</h6>
                <p class="fs-5 mb-4">
                    {{ $task->description ?: 'K tejto úlohe nebol zadaný žiadny podrobnejší popis.' }}
                </p>

                <hr>

                <!-- Informácie v mriežke -->
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <strong>Zadal (Autor):</strong> {{ $task->creator->name }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Priradené riešiteľovi:</strong> 
                        <span class="text-primary fw-bold">{{ $task->assignee?->name ?? 'Nepriradené' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Termín (Deadline):</strong> {{ $task->deadline }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Vytvorené:</strong> {{ $task->created_at->format('d.m.Y H:i') }}
                    </div>
                </div>
            </div>

            <!-- Akčné tlačidlá (len pre autora úlohy) -->
            <div class="card-footer bg-white d-flex justify-content-end gap-2 py-3">
                @can('assign', $task)
                    <form action="{{ route('tasks.assign', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-success">
                            ✋ Prevziať úlohu
                        </button>
                    </form>
                @endcan

                @can('changeStatus', $task)
                    @if($task->status === 'pending')
                        <form action="{{ route('tasks.status', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="in_progress">
                            <button type="submit" class="btn btn-primary">
                                🚀 Začať riešiť
                            </button>
                        </form>
                    @elseif($task->status === 'in_progress')
                        <form action="{{ route('tasks.status', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-success">
                                ✅ Dokončiť úlohu
                            </button>
                        </form>
                    @endif
                @endcan

            
                @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary">Upraviť úlohu</a>
                @endcan

                @can('delete', $task)
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Naozaj chceš túto úlohu zmazať?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">Zmazať úlohu</button>
                    </form>
                @endcan

                @if($task->status === 'completed')
                    <span class="text-muted align-self-center me-auto">
                        🔒 Úloha je dokončená a uzamknutá.
                    </span>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection
