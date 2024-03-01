<div class="container mt-5">
    <h2 class="text-center">Task List</h2>
    <center><a href="{{ route('employees.searchemp') }}" id="search" class="btn btn-primary"><i class="fas fa-search"> Search Employee</i></a></center>

    {{-- employee List --}}
    <div id="maincontent1">
    </div>

    <div class="container mt-5" id="k">
        <h1 class="text-center">Employee Details</h1>
        @if($employees->isEmpty())
        <div class="alert alert-warning">No Employee Found!</div>
        @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Email</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Date of Joining</th>
                        <th scope="col">Address</th>
                        <th scope="col">Category</th>
                        <th scope="col">Subcategory</th>
                        <th scope="col">Password</th>
                        <th scope="col">Profile Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                    <tr>
                        <th scope="row">{{ $employee->id }}</th>
                        <td>{{ $employee->employeeName }}</td>
                        <td>{{ $employee->employeeMobile }}</td>
                        <td>{{ $employee->employeeEmail }}</td>
                        <td>{{ $employee->employeeDOB }}</td>
                        <td>{{ $employee->employeeGender }}</td>
                        <td>{{ $employee->employeeDOJ }}</td>
                        <td>{{ $employee->employeeAddress }}</td>
                        <td>{{ $employee->employeeCategory }}</td>
                        <td>{{ $employee->employeeSubcategory }}</td>
                        <td>{{ $employee->employeePassword }}</td>
                        <td>
                            @if ($employee->employeeProfileImage)
                            <img src="{{ asset('storage/' . $employee->employeeProfileImage) }}" alt="Profile Image" class="img-thumbnail">
                            @else
                            No Image
                            @endif
                        </td>
                        <td>
                            <!-- Edit button -->
                            <a href="{{ route('employees.edit', ['id' => $employee->id]) }}" id="editEmployeeBtn" class="btn btn-primary">Edit</a>

                            <!-- Delete button -->
                            <form action="{{ route('employees.destroy', ['id' => $employee->id]) }}" method="post" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
<br>

@if (session('success'))
<div class="alert alert-success mt-3">
    {{ session('success') }}
</div>
@endif

{{-- Edit Employee --}}
<div id="editEmployee" style="display: none;">
    <div class="container mt-5">
        @if (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
        @endif

        <h1 class="text-center">Edit Employee</h1>
        <!-- Edit Employee form -->
    </div>
</div>

{{-- JavaScript --}}
<script>
    $(document).ready(function() {
        // Event listener for "Edit" button
        $("body").on("click", "#editEmployeeBtn", function(e) {
            e.preventDefault();
            var url = $(this).attr("href");

            // Ajax request to load the content of the editEmployee section
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    // Replace the content of the editEmployee container with the loaded content
                    $("#editEmployee").html(data).show();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });

        // Event listener for "Search Employee" button
        $("#search").click(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('employees.searchemp') }}",
                type: "GET",
                success: function(response) {
                    $("#maincontent1").html(response);
                },
                error: function() {
                    $("#maincontent1").html("<p>Error loading content.</p>");
                }
            });
        });
    });
</script>
