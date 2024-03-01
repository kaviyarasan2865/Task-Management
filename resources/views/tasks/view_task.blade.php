<div class="container mt-5">
    <h2 class="text-center">Task List</h2>

    {{-- search task --}}
    <center><a href="{{ route('task.search') }}" id="search" class="btn btn-primary"><i class="fas fa-search"> Search Task</i></a></center>

        {{-- Task List --}}
        <div id="maincontent3">
        </div>


    @if ($tasks->isEmpty())
        <div class="alert alert-info">No tasks assigned to employees.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Employee ID</th>
                        <th scope="col">Employee Name</th>
                        <th scope="col">Task Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Subcategory</th>
                        <th scope="col">Scheduled Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">Updated Time</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->employee_id }}</td>
                            <td>{{ $task->employee_name }}</td>
                            <td>{{ $task->task_name }}</td>
                            <td>{{ $task->category }}</td>
                            <td>{{ $task->subcategory }}</td>
                            <td>{{ $task->scheduled_time }}</td>
                            <td>{{$task->status}}</td>
                            <td>
                                @if($task->updated_time==null)
                                No Updates
                                @else
                                {{$task->updated_time}}
                                @endif
                            </td>
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
    @endif
</div>

{{-- Update Status Section --}}
<div id="updatestatus" style="display:none;">
    <div class="container mt-5">
        <h2 class="text-center">update List</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Employee ID</th>
                        <th scope="col">Employee Name</th>
                        <th scope="col">Task Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Subcategory</th>
                        <th scope="col">Scheduled Time</th>
                        <th scope="col">Updated Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->employee_id }}</td>
                            <td>{{ $task->employee_name }}</td>
                            <td>{{ $task->task_name }}</td>
                            <td>{{ $task->category }}</td>
                            <td>{{ $task->subcategory }}</td>
                            <td>{{ $task->scheduled_time }}</td>
                            <td>{{ $task->updated_time }}</td>
                            <td>
                                <form method="post" action="{{ route('tasks.update', ['id' => $task->id]) }}">
                                    @csrf
                                    <select class="form-control task-status-dropdown" name="status" data-task-id="{{ $task->id }}">
                                        <option value="yet-to-start" {{ $task->status === 'yet-to-start' ? 'selected' : '' }}>Yet to Start</option>
                                        <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in-progress" {{ $task->status === 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="parked" {{ $task->status === 'parked' ? 'selected' : '' }}>Parked</option>
                                        <option value="complete" {{ $task->status === 'complete' ? 'selected' : '' }}>Complete</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                </form>
                            </td>
                        </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

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


 // Event listener for "Search Task" button
 $("#search").click(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('task.search') }}",
                type: "GET",
                success: function(response) {
                    $("#maincontent3").html(response);
                },
                error: function() {
                    $("#maincontent3").html("<p>Error loading content.</p>");
                }
            });
        });

</script>
