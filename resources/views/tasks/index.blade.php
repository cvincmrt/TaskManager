<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Zoznam úloh</h1>
    <ul>
        @foreach ($tasks as $task)
            <li>
                <strong>{{ $task->title }}</strong>
                - Rieši: {{$task->assignee?->name ?? 'Nepriradene'}}
                - Zadal: {{$task->creator->name}}
                — Stav: {{ $task->status }}
                — Priorita: {{ $task->priority }}
            </li>
        @endforeach
    </ul>
</body>
</html>