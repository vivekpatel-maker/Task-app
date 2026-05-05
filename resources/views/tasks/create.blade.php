<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Task</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h4 class="mb-4 text-center fw-bold">➕ Create New Task</h4>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="/tasks">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input 
                                type="text" 
                                name="title" 
                                class="form-control" 
                                placeholder="Enter task title"
                                maxlength="50"
                            >
                                <small class="text-danger error-title"></small>

                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea 
                                name="description" 
                                class="form-control" 
                                rows="3"
                                    maxlength="300"

                                placeholder="Write task details..."
                            ></textarea>
                                <small class="text-danger error-description"></small>

                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                                <small class="text-danger error-status"></small>

                        </div>

                        <div class="mb-4">
                            <label class="form-label">Due Date</label>
                            <input 
                                type="date" 
                                name="due_date" 
                                class="form-control"
                                    min="{{ date('Y-m-d') }}"

                            >
                                <small class="text-danger error-due_date"></small>

                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/tasks" class="btn btn-secondary">← Back</a>
                            <button type="submit" class="btn btn-success">
                                💾 Save Task
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<script>
document.querySelector("form").addEventListener("submit", function(e) {

    document.querySelectorAll(".text-danger").forEach(el => el.textContent = "");

    let title = document.querySelector("[name='title']");
    let description = document.querySelector("[name='description']");
    let status = document.querySelector("[name='status']");
    let dueDate = document.querySelector("[name='due_date']");

    let today = new Date().toISOString().split('T')[0];

    let valid = true;

    if (title.value.trim() === "") {
        document.querySelector(".error-title").textContent = "Title is required";
        valid = false;
    } else if (title.value.length > 50) {
        document.querySelector(".error-title").textContent = "Max 50 characters allowed";
        valid = false;
    }

    if (description.value.length > 300) {
        document.querySelector(".error-description").textContent = "Max 300 characters allowed";
        valid = false;
    }

    if (!status.value) {
        document.querySelector(".error-status").textContent = "Please select status";
        valid = false;
    }

    if (dueDate.value && dueDate.value < today) {
        document.querySelector(".error-due_date").textContent = "Past date not allowed";
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
    }
});
</script>
</body>
</html>