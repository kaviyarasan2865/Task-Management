<!-- resources/views/tasks/search_results.blade.php -->

<div class="container mt-5">
    <h2>Search Results</h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Task Name</th>
                        <th scope="col">Employee Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Subcategory</th>
                        <th scope="col">Scheduled Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $task)
                    <tr>
                        <td scope="row">{{ $task->id }}</td>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->employee_name }}</td>
                        <td>{{ $task->category }}</td>
                        <td>{{ $task->subcategory }}</td>
                        <td>{{ $task->scheduled_time }}</td>
                        <td>{{ $task->status }}</td>
                        <td>
                            <button type="button" class="btn btn-primary updateStatusBtn"
                                data-task-id="{{ $task->id }}">Update Status</button>
                            <form method="post" action="{{ route('tasks.delete', ['id' => $task->id]) }}"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<br>
<br>

<script>
    $(document).ready(function() {
        $('.updateStatusBtn').click(function() {
            var taskId = $(this).data('task-id');
            var updateStatusDiv = $('#updatestatus');

            $.ajax({
                url: "{{ route('tasks.showUpdateForm', ['id' => ':id']) }}".replace(':id',
                    taskId),
                type: 'GET',
                success: function(response) {
                    updateStatusDiv.html(
                        response); // Set the content of updatestatus div with the response
                    updateStatusDiv.show(); // Show the updatestatus div
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle error response
                }
            });
        });
    });
</script>
