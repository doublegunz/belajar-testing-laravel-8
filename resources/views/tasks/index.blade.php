<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks Management</title>
</head>
<body>
    <form action="{{ route('tasks.store') }}" method="post">
        @csrf
        <input type="text" name="name" id="name">
        <textarea name="description" id="" cols="30" rows="10"></textarea>
        <input type="submit" value="Create Task">
    </form>
    <h1>Tasks Management</h1>
    <ul>
        @foreach ($tasks as $task)
        <li>
            {{ $task->name }} <br>
            {{ $task->description }}
        </li>
        @endforeach
    </ul>
</body>
</html>
