@extends('layouts.app')

@section('content')
<div class="container">
<h1 class="page-header text-center">Tasks Management</h1>
<div class="row justify-content-center">
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h2>Tasks</h2>
                <ul class="list-group list-group-flush">
                    @foreach ($tasks as $task)
                    <li class="list-group-item {{ $task->is_done ? 'task-done' : '' }} d-flex justify-content-between align-items-center">

                        <div class="ms-2 me-auto">
                            <form action="{{ url('tasks/'.$task->id.'/toggle') }}" method="post">
                                @csrf
                                @method('patch')
                                <input type="submit" value="{{ $task->name }}" id="toggle_task_{{ $task->id }}" class="btn btn-link no-padding">
                            </form>
                            {{ $task->description }}
                        </div>

                        <div class="float-end">
                            <a href="{{ url('tasks') }}?action=edit&id={{ $task->id }}" id="edit_task_{{ $task->id }}" class="float-end">
                                edit
                            </a>
                            <form action="{{ route('tasks.delete', $task->id) }}" method="post"
                                onsubmit="return confirm('Are you sure to delete this task?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm float-end" id="delete_task_{{$task->id}}">X</button>

                            </form>

                        </div>





                    </li>
                    @endforeach
                </ul>

            </div>
        </div>



    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">

                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (! is_null($editableTask) && request('action') == 'edit')
                    <h2>Edit Task {{ $editableTask->name }}</h2>
                    <form id="edit_task_{{ $editableTask->id }}" action="{{ url('tasks/'.$editableTask->id) }}" method="post">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label for="exampleInputname1" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" aria-describedby="nameHelp" value="{{ old('name', $editableTask->name) }}">
                            <div id="nameHelp" class="form-text">We'll never share your name with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Description</label>
                            <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ old('description', $editableTask->description) }}</textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Task</button>
                    </form>

                @else
                    <h2>New Task</h2>
                    <form action="{{ route('tasks.index') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputname1" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" aria-describedby="nameHelp">
                            <div id="nameHelp" class="form-text">We'll never share your name with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Description</label>
                            <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Task</button>
                    </form>

                @endif


            </div>
        </div>


    </div>
</div>
</div>

@endsection
