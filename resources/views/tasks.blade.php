@extends('layouts.app')


@section('content')
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Showing All Tasks
                            </span>



                            <div class="btn-group pull-right btn-group-xs">

                                <button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal"
                                    data-target="#createTask">

                                    Create New Task
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('tasks.search') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search in title" name="search">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>



                        </form>


                        <div class="table-responsive tasks-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="user_count">
                                </caption>
                                <thead class="thead">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Complete Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody id="tasks_table">
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td>{{ $task->id }}</td>

                                            <td>{{ $task->title }}</td>
                                            <td>{{ $task->description }}</td>

                                            <td>

                                                <span
                                                    class="badge  {{ $task->completed == 0 ? 'badge-danger' : 'badge-success' }}">{{ $task->completed == 1 ? 'Completed' : 'Not Completed' }}</span>
                                            </td>

                                            </td>
                                            <td>

                                                <button type="button" class=" btn btn-sm btn-success btn-block"
                                                    data-toggle="modal" data-target="#edit{{ $task->id }}">
                                                    Edit Task
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger btn-block"
                                                    data-toggle="modal" data-target="#delete{{ $task->id }}">
                                                    Delete Task
                                                </button>

                                            </td>

                                        </tr>



                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit{{ $task->id }}"
                                            tabindex="-{{ $task->id }}"
                                            aria-labelledby="#deleteLable{{ $task->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="#deleteLable{{ $task->id }}">Edit
                                                            {{ $task->title }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <form action="{{ route('tasks.update', $task) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')



                                                                <div class="form-group">
                                                                    <label for="title{{ $task->id }}">Title</label>
                                                                    <input type="text" class="form-control"
                                                                        name="title" placeholder="Task Title"
                                                                        aria-label="Title" aria-describedby="basic-addon1"
                                                                        maxlength="250"
                                                                        value="{{ old('title', $task->title) }}" required
                                                                        id="title{{ $task->id }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label
                                                                        for="Description{{ $task->id }}">Description</label>
                                                                    <textarea class="form-control" id="Description{{ $task->id }}" name="description" rows="4" maxlength="1000">{{ old('description', $task->description) }}</textarea>
                                                                </div>
                                                                <div class="form-group form-check">
                                                                    <input id="completed{{ $task->id }}"
                                                                        type="checkbox" class="form-check-input"
                                                                        name="completed"
                                                                        {{ $task->completed == 1 ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="completed{{ $task->id }}">Completed</label>
                                                                </div>




                                                                <button type="submit" class="btn btn-primary">Save</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete{{ $task->id }}"
                                            tabindex="-{{ $task->id }}"
                                            aria-labelledby="#deleteLable{{ $task->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="#deleteLable{{ $task->id }}">Are
                                                            you sure?</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to proceed with this action?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>



                                                                <a href="{{ route('tasks.delete', $task->id) }}"
                                                                    class="btn btn-danger">Confirm</a>
                                                            </div>




                                                </div>
                                            </div>
                                        </div>
                                    @endforeach



                                </tbody>

                            </table>
                            {{ $tasks->links() }} <!-- Display pagination links -->

                            <div class="modal fade" id="createTask" tabindex="-1" aria-labelledby="#createLable"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createLable">Add Office
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <form action="{{ route('tasks.store') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('POST')
                                                    <div class="form-group">
                                                        <label for="Createtitle">Title</label>
                                                        <input type="text" class="form-control" name="title"
                                                            placeholder="Task Title" aria-label="Title"
                                                            aria-describedby="basic-addon1" maxlength="250" required
                                                            id="Createtitle">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Description">Description</label>
                                                        <textarea class="form-control" id="Description"name="description" rows="4" maxlength="1000"></textarea>
                                                    </div>
                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" name="completed"
                                                            id="completed">
                                                        <label class="form-check-label" for="completed">Completed</label>
                                                    </div>


                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
