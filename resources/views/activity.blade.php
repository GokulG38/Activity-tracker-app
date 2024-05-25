
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .compact-container {
            max-width: 600px;
            margin: auto;
        }
    </style>
</head>
<body>

<div class="compact-container mt-5">
    <h1 class="text-center mb-4">Activity Management</h1>


    <form id="activityForm" action="{{ route('activity.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="row g-3 align-items-center">
            <input type="hidden" id="activityId" name="activityId">
            <div class="col-md-3">
                <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-md-3">
                <input type="date" id="date" name="date" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="text" id="description" name="description" class="form-control" placeholder="Description" required>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="completed" name="completed" value="1">
                    <label class="form-check-label" for="completed">Completed</label>
                </div>
            </div>
            <div class="col-md-12 mt-2">
                <button type="submit" class="btn btn-dark w-100">Add</button>
            </div>
        </div>
    </form>

    <form action="{{ route('activity.index') }}" method="GET" class="mb-4">
        @csrf
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <input type="date" id="calendar" name="date" onchange="this.form.submit()" class="form-control">
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-secondary w-100" onclick="clearDate()">Clear Filter</button>
            </div>
        </div>
    </form>

    <ul class="list-group">
        @foreach($activity as $item)
        <li class="list-group-item">
                    @if ($item->completed)
                        <del>
                            <strong>Name:</strong> {{ $item->name}} <br>
                            <strong>Description:</strong> {{ $item->description}}
                        </del>
                    @else
                        <strong>Name:</strong> {{ $item->name}} <br>
                        <strong>Description:</strong> {{ $item->description}}
                    @endif
                    
                    <strong>Completed:</strong> {{ $item->completed ? 'Yes' : 'No' }}
                <div>
                    <form action="{{ route('activity.delete', ['id' => $item->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger me-2">Delete</button>
                        <button type="button" class="btn btn-info me-2" onclick="populateForm({{ json_encode($item) }})">Update</button>
                    </form>
                    @unless($item->completed)
                        <form action="{{ route('activity.markAsDone', ['id' => $item->id]) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">Done</button>
                        </form>
                    @endunless

                </div>
            </li>
        @endforeach
    </ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function clearDate() {
        document.getElementById('calendar').value = '';
        document.querySelector('form[action="{{ route('activity.index') }}"]').submit(); 
    }

    function populateForm(activity) {
        document.getElementById('activityForm').action = activity.id ? "{{ route('activity.update', ['id' => ':id']) }}".replace(':id', activity.id) : "{{ route('activity.store') }}";
        document.getElementById('activityId').value = activity.id; 
        document.getElementById('name').value = activity.name;
        document.getElementById('date').value = activity.date;
        document.getElementById('description').value = activity.description;
        document.getElementById('completed').checked = activity.completed;
    }
</script>
</body>
</html>
