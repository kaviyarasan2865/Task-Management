<!-- employees.blade.php -->

<div class="container mt-5">
    <h1 class="text-center">Search Results</h1>
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
                                <img src="{{ asset('storage/' . $employee->employeeProfileImage) }}"
                                    alt="Profile Image" class="img-thumbnail">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                            <!-- Edit button -->
                            <a href="{{ route('employees.edit', ['id' => $employee->id]) }}" id="editEmployeeBtn"
                                class="btn btn-primary">Edit</a>

                            <!-- Delete button -->
                            <form action="{{ route('employees.destroy', ['id' => $employee->id]) }}" method="post"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this employee?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif
