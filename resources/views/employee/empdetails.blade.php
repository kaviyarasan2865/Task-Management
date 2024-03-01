<div class="container mt-5" id="k">
<h1 class="text-center">Employee Details</h1>
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

                       
                    </td>
                </tr>
        </tbody>
    </table>
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
    <form method="post" action="{{ route('employees.update', ['id' => $employee->id]) }}" id="editEmployeeForm"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Employee Name -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="editEmployeeName">Employee Name</label>
                <input type="text" class="form-control" id="editEmployeeName" name="editEmployeeName"
                    placeholder="Enter employee name" value="{{ $employee->employeeName }}" required>
            </div>

            <!-- Mobile -->
            <div class="form-group col-md-6">
                <label for="editEmployeeMobile">Mobile</label>
                <input type="tel" class="form-control" id="editEmployeeMobile" name="editEmployeeMobile"
                    placeholder="Enter mobile number" value="{{ $employee->employeeMobile }}" required>
            </div>
        </div>

        <!-- Email -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="editEmployeeEmail">Email</label>
                <input type="email" class="form-control" id="editEmployeeEmail" name="editEmployeeEmail"
                    placeholder="Enter email" value="{{ $employee->employeeEmail }}" required>
            </div>

            <!-- Date of Birth -->
            <div class="form-group col-md-6">
                <label for="editEmployeeDOB">Date of Birth</label>
                <input type="date" class="form-control" id="editEmployeeDOB" name="editEmployeeDOB"
                    value="{{ $employee->employeeDOB }}" required>
            </div>
        </div>

        <!-- Gender -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="editEmployeeGender">Gender</label>
                <select class="form-control" id="editEmployeeGender" name="editEmployeeGender" required>
                    <option value="male" @if ($employee->employeeGender == 'male') selected @endif>Male</option>
                    <option value="female" @if ($employee->employeeGender == 'female') selected @endif>Female</option>
                    <option value="other" @if ($employee->employeeGender == 'other') selected @endif>Other</option>
                </select>
            </div>

            <!-- Date of Joining -->
            <div class="form-group col-md-6">
                <label for="editEmployeeDOJ">Date of Joining</label>
                <input type="date" class="form-control" id="editEmployeeDOJ" name="editEmployeeDOJ"
                    value="{{ $employee->employeeDOJ }}" required>
            </div>
        </div>

        <!-- Address -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="editEmployeeAddress">Address</label>
                <input type="text" class="form-control" id="editEmployeeAddress" name="editEmployeeAddress"
                    placeholder="Enter address" value="{{ $employee->employeeAddress }}" required>
            </div>

            <!-- Category -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="editEmployeeCategory">Category</label>
                    <select class="form-control" id="editEmployeeCategory" name="editEmployeeCategory" required>
                        <option value="hr" @if ($employee->employeeCategory == 'hr') selected @endif>HR</option>
                        <option value="developer" @if ($employee->employeeCategory == 'developer') selected @endif>Developer
                        </option>
                        <option value="tester" @if ($employee->employeeCategory == 'tester') selected @endif>Tester</option>
                    </select>
                </div>
            </div>

            <!-- Subcategory -->
            <div class="form-row" id="editEmployeeSubcategoryRow" style="display: none;">
                <div class="form-group col-md-6">
                    <label for="editEmployeeSubcategory">Subcategory</label>
                    <select class="form-control" id="editEmployeeSubcategory" name="editEmployeeSubcategory">
                        <!-- HR Subcategories -->
                        <optgroup label="HR">
                            <option value="recruiter" @if ($employee->employeeSubcategory == 'recruiter' && $employee->employeeCategory == 'hr') selected @endif>Recruiter
                            </option>
                            <option value="payrolemanager" @if ($employee->employeeSubcategory == 'payrolemanager' && $employee->employeeCategory == 'hr') selected @endif>
                                Payrole Manager</option>
                            <option value="trainingmanager" @if ($employee->employeeSubcategory == 'trainingmanager' && $employee->employeeCategory == 'hr') selected @endif>
                                Training Manager</option>
                        </optgroup>
                        <!-- Developer Subcategories -->
                        <optgroup label="Developer">
                            <option value="frontend" @if ($employee->employeeSubcategory == 'frontend' && $employee->employeeCategory == 'developer') selected @endif>Frontend
                            </option>
                            <option value="backend" @if ($employee->employeeSubcategory == 'backend' && $employee->employeeCategory == 'developer') selected @endif>Backend
                            </option>
                            <option value="fullstack" @if ($employee->employeeSubcategory == 'fullstack' && $employee->employeeCategory == 'developer') selected @endif>Fullstack
                            </option>
                            <option value="datascientist" @if ($employee->employeeSubcategory == 'datascientist' && $employee->employeeCategory == 'developer') selected @endif>Data
                                Scientist</option>
                        </optgroup>
                        <!-- Tester Subcategories -->
                        <optgroup label="Tester">
                            <option value="automated" @if ($employee->employeeSubcategory == 'automated' && $employee->employeeCategory == 'tester') selected @endif>Automated
                            </option>
                            <option value="manual" @if ($employee->employeeSubcategory == 'manual' && $employee->employeeCategory == 'tester') selected @endif>Manual
                            </option>
                        </optgroup>
                    </select>
                </div>
            </div>

        </div>

        <!-- Subcategory -->
        <div class="form-row">
            <!-- Subcategory -->

                <div class="form-group col-md-6" id="editEmployeeSubcategoryRow">
                    <label for="editEmployeeSubcategory">Subcategory</label>
                    <select class="form-control" id="editEmployeeSubcategory" name="editEmployeeSubcategory">
                        <!-- Options will be dynamically updated based on selected category -->
                    </select>
                </div>



            <!-- Password -->
            <div class="form-group col-md-6">
                <label for="editEmployeePassword">Password</label>
                <input type="password" class="form-control" id="editEmployeePassword"
                    name="editEmployeePassword" placeholder="Enter password"
                    value="{{ $employee->employeePassword }}" required>
            </div>
        </div>

        <!-- Profile Image -->
        <div class="form-row">
            <div class="form-group">
                <label for="editEmployeeProfileImage">Profile Image</label>
                @if ($employee->employeeProfileImage)
                    <img src="{{ asset('storage/' . $employee->employeeProfileImage) }}"
                        alt="Current Profile Image" class="img-thumbnail">
                    <p>Keep the existing image or upload a new one:</p>
                @endif
                <input type="file" class="form-control" id="editEmployeeProfileImage"
                    name="editEmployeeProfileImage">
            </div>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary mx-auto d-block">Update</button>
    </form>
</div>
</div>


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
});
</script>
