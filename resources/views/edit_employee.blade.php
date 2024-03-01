{{-- Edit Employee --}}

<div class="container mt-5">
    @if (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif

    <h1 class="text-center">Edit Employee</h1>
    <form method="post" action="{{ route('employees.update', ['id' => $employee->id]) }}" id="editEmployeeForm" enctype="multipart/form-data">
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
            <div class="form-group col-md-6">
                <label for="editEmployeeCategory">Category</label>
                <select class="form-control" id="editEmployeeCategory" name="editEmployeeCategory" required>
                    <option value="hr" @if ($employee->employeeCategory == 'hr') selected @endif>HR</option>
                    <option value="developer" @if ($employee->employeeCategory == 'developer') selected @endif>Developer</option>
                    <option value="tester" @if ($employee->employeeCategory == 'tester') selected @endif>Tester</option>
                </select>
            </div>
        </div>

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
                <input type="password" class="form-control" id="editEmployeePassword" name="editEmployeePassword"
                    placeholder="Enter password" value="{{ $employee->employeePassword }}" required>
            </div>
        </div>

        <!-- Profile Image -->
        <div class="form-row">
            <div class="form-group">
                <label for="editEmployeeProfileImage">Profile Image</label>
                @if ($employee->employeeProfileImage)
                    <img src="{{ asset('storage/' . $employee->employeeProfileImage) }}" alt="Current Profile Image"
                        class="img-thumbnail">
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

<script>
    $(document).ready(function () {
        // Function to populate subcategory options based on selected category
        function populateSubcategories(category, defaultSubcategory) {
            var subcategories = {
                "hr": ["Recruiter", "Payrole Manager", "Training and Development Manager"],
                "developer": ["Frontend", "Backend", "Fullstack", "Data Scientist"],
                "tester": ["Automated", "Manual"]
            };

            $('#editEmployeeSubcategory').empty();

            if (subcategories[category]) {
                // Populate options based on selected category
                $.each(subcategories[category], function (index, value) {
                    $('#editEmployeeSubcategory').append($('<option>', {
                        value: value.toLowerCase().replace(/\s+/g, ''),
                        text: value
                    }));
                });

                // Set default subcategory value
                $('#editEmployeeSubcategory').val(defaultSubcategory);
            } else {
                // If no subcategories defined for the selected category, hide the subcategory field
                $('#editEmployeeSubcategoryRow').hide();
            }
        }

        // Event listener for change in category select
        $('#editEmployeeCategory').on('change', function () {
            var selectedCategory = $(this).val();
            var defaultSubcategory = "{{ $employee->employeeSubcategory }}"; // Fetch default subcategory value from PHP variable
            populateSubcategories(selectedCategory, defaultSubcategory);
        });

        // Initial population of subcategories based on selected category
        var initialCategory = $('#editEmployeeCategory').val();
        var defaultSubcategory = "{{ $employee->employeeSubcategory }}"; // Fetch default subcategory value from PHP variable
        populateSubcategories(initialCategory, defaultSubcategory);
    });
</script>
