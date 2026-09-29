<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
        <li>{{$task->id}}</li>
        <li>{{$task->title}}</li>
        <li>{{$task->description}}</li>
        <li>{{$task->priority}}</li>
        <li>{{$task->status}}</li>
        <li>{{$task->creator->name}}</li>
        <li>{{$task->assignee?->name ?? 'Nepriradena' }}</li>
        <li>{{$task->deadline}}</li>
        <li>{{$task->created_at}}</li>
        <li>{{$task->updated_at}}</li>
    </ul>
    
    <a href="{{ route('tasks.index') }}">Back to list</a>
</body>
</html>