@section('content')
<div class="container mt-5">
    <h2>View Assigned Tasks</h2>
    @if(count($tasks) > 0)
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Employee ID</th>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Task Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Subcategory</th>
                    <th scope="col">Scheduled Time</th>
                    <th scope="col">Remaining Time</th>
                    <th scope="col">Status</th>
                    <th scope="col">Updated Time</th>
                    <th scope="col"> Update Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                     <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->employee_id }}</td>
                    <td>{{ $task->employee_name }}</td>
                    <td>{{ $task->task_name }}</td>
                    <td>{{ $task->category }}</td>
                    <td>{{ $task->subcategory }}</td>
                    <td>{{ $task->scheduled_time }}</td>
                    <td>
                            <span id="remaining-time-{{ $task->id }}"></span> <!-- Display remaining time here -->
                    </td>
                    <td>{{ $task->status}}</td>
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
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info"><br>No tasks assigned yet.</div>
    @endif

</div>
</div>


<script>
    // Function to calculate remaining time and update the display
    function updateRemainingTime(taskId, scheduledTime) {
        var remainingTimeElement = document.getElementById('remaining-time-' + taskId);
        var scheduledDateTime = new Date(scheduledTime);
        var currentTime = new Date();
        var remainingMilliseconds = scheduledDateTime - currentTime;

        // Calculate remaining hours and minutes
        var remainingHours = Math.floor(remainingMilliseconds / (1000 * 60 * 60));
        var remainingMinutes = Math.floor((remainingMilliseconds % (1000 * 60 * 60)) / (1000 * 60));

        // Update the display
        remainingTimeElement.textContent = remainingHours + " hours " + remainingMinutes + " minutes";
    }

    // Call the updateRemainingTime function for each task
    @foreach($tasks as $task)
        updateRemainingTime('{{ $task->id }}', '{{ $task->scheduled_time }}');
    @endforeach
</script>
<script>
    $(document).ready(function() {
        $('form').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Serialize the form data
            var formData = $(this).serialize();

            // Make an AJAX request
            $.ajax({
                url: $(this).attr('action'), // Get the form action URL
                type: 'POST',
                data: formData,
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    // Display the response message
                    alert(response.message);

                    // Reload the page after showing the message
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle errors if any
                    console.error(error);
                }
            });
        });
    });
</script>

{{-- <script>
    // Function to calculate remaining time and update the display
    function updateRemainingTime(taskId, scheduledTime, status) {
        // If the status is 'finished', do not calculate remaining time
        if (status === 'finished') {
            return;
        }

        var remainingTimeElement = document.getElementById('remaining-time-' + taskId);
        var scheduledDateTime = new Date(scheduledTime);
        var currentTime = new Date();
        var remainingMilliseconds = scheduledDateTime - currentTime;

        // Calculate remaining hours and minutes
        var remainingHours = Math.floor(remainingMilliseconds / (1000 * 60 * 60));
        var remainingMinutes = Math.floor((remainingMilliseconds % (1000 * 60 * 60)) / (1000 * 60));

        // Update the display
        remainingTimeElement.textContent = remainingHours + " hours " + remainingMinutes + " minutes";
    }

    // Call the updateRemainingTime function for each task
    @foreach($tasks as $task)
        updateRemainingTime('{{ $task->id }}', '{{ $task->scheduled_time }}', '{{ $task->status }}');
    @endforeach
</script>
 --}}

