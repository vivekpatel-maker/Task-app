<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">📋 Task Manager</h2>

        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Logout</button>
        </form>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
           <form method="GET" class="row g-3 align-items-end" id="filterForm">
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="" {{ request('status') == '' ? 'selected' : '' }}>All</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Due Date</label>
        <input type="date" name="due_date" class="form-control" value="{{ request('due_date') }}">
    </div>

    <div class="col-md-4">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
</form>

        </div>
    </div>

    <div class="mb-3 text-end">
        <a href="/tasks/create" class="btn btn-success">+ Add Task</a>
    </div>

    <div class="row">
        @foreach($tasks as $task)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-body">

                        <h5 class="card-title fw-semibold">{{ $task->title }}</h5>

                        <span class="badge 
                            @if($task->status == 'pending') bg-warning
                            @elseif($task->status == 'in_progress') bg-info
                            @else bg-success
                            @endif
                        ">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>

                        <p class="mt-2 text-muted">
                            📅 {{ $task->due_date }}
                        </p>

                        <div class="d-flex justify-content-between mt-3">

                            <a href="/tasks/{{ $task->id }}/edit" class="btn btn-outline-primary btn-sm">
                                Edit
                            </a>

                            <form method="POST" action="/tasks/{{ $task->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">
                                    Delete
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
    @if(session('success'))
    <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif
</div>
<script>
document.getElementById('filterForm').addEventListener('submit', function(e) {
    e.preventDefault(); 

    const status = this.querySelector('select[name="status"]').value;
    const due_date = this.querySelector('input[name="due_date"]').value;

    let url = '/tasks';
    const params = new URLSearchParams();
    if (status) params.append('status', status);
    if (due_date) params.append('due_date', due_date);
    if (params.toString()) url += '?' + params.toString();

    window.location.href = url;
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var toastEl = document.getElementById('successToast');
    if(toastEl){
        var toast = new bootstrap.Toast(toastEl, { delay: 3000 }); 
        toast.show();
    }
});
</script>
</body>
</html>