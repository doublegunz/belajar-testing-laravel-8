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
                    <li class="list-group-item">


                        {{ $task->name }}<br>
                        {{ $task->description }}
                        <a href="{{ url('tasks') }}?action=edit&id={{ $task->id }}" id="edit_task_{{ $task->id }}" class="pull-end">
                            edit
                        </a>
                    </li>
                    @endforeach
                </ul>

            </div>
        </div>



    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h2>New Task</h2>
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
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

            </div>
        </div>


    </div>
</div>
</div>

@endsection
