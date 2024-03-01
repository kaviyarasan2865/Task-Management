

<div class="content" id="dashboard">
    <div class="container">
        <h1 class="text-center">Add Employee</h1>

        <!-- Display any form validation errors -->
        <div class="alert alert-danger" style="display:none">
            <ul>
            </ul>
        </div>

        <div class="alert alert-success" id="successMessage" style="display:none">
            <ul>
            </ul>
        </div>

        <form id="employeeForm" action="{{ url('add_employee') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="employeeName">Employee Name</label>
                    <input type="text" class="form-control" id="employeeName" name="employeeName"
                        placeholder="Enter employee name">
                </div>

                <div class="form-group col-md-6">
                    <label for="employeeMobile">Mobile</label>
                    <input type="tel" class="form-control" id="employeeMobile" name="employeeMobile"
                        placeholder="Enter mobile number">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="employeeEmail">Email</label>
                    <input type="email" class="form-control" id="employeeEmail" name="employeeEmail"
                        placeholder="Enter email">
                </div>

                <div class="form-group col-md-6">
                    <label for="employeeDOB">Date of Birth</label>
                    <input type="date" class="form-control" id="employeeDOB" name="employeeDOB">
                </div>
            </div>


            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="employeeGender">Gender</label>
                    <select class="form-control" id="employeeGender" name="employeeGender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

        <div class="form-group col-md-6">
            <label for="employeeDOJ">Date of Joining</label>
            <input type="date" class="form-control" id="employeeDOJ" name="employeeDOJ">
        </div>
        </div>

        <div class="form-row">
        <div class="form-group col-md-6">
            <label for="employeeAddress">Address</label>
            <input type="text" class="form-control" id="employeeAddress" name="employeeAddress" placeholder="Enter address">
        </div>

        <div class="form-group col-md-6">
            <label for="employeePassword">Password</label>
            <input type="password" class="form-control" id="employeePassword" name="employeePassword" placeholder="Enter password">
        </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="employeeCategory">Category</label>
                <select class="form-control" id="employeeCategory" name="employeeCategory">
                    <option value="hr">HR</option>
                    <option value="developer">Developer</option>
                    <option value="tester">Tester</option>
                </select>
            </div>

            <div class="form-group col-md-6" id="subcategoryContainer" style="display: none;">
                <label for="employeeSubcategory">Subcategory</label>
                <select class="form-control" id="employeeSubcategory" name="employeeSubcategory">
                    <!-- Subcategory options will be dynamically added here -->
                </select>
            </div>
        </div>

        <div class="form-row">


            <div class="form-group">
                <label for="employeeProfileImage">Profile Image</label>
                <input type="file" class="form-control" id="employeeProfileImage" name="employeeProfileImage">
            </div>
        </div>

            <button type="button"  id="submitForm" class="btn btn-primary mx-auto d-block">Add Employee</button>
        </form>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $("#submitForm").click(function () {
            var formData = new FormData($("#employeeForm")[0]);

            $.ajax({
                type: 'POST',
                url: '{{ url('add_employee') }}',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    $(".alert-danger").hide();
                    $("#successMessage").html(data.message).show(); // Show success message
                    $("#employeeForm")[0].reset();
                },
                error: function (xhr, status, error) {
                    // Handle other errors, display error messages, etc.
                    console.error(JSON.parse(xhr.responseText));
                    var data = JSON.parse(xhr.responseText);
                    var errorMessage = data.errors.join('');
                    console.log(errorMessage);
                    $(".alert-danger").show();
                    $(".alert-danger").html('<ul>' + data.errors.join('') + '</ul>').show();
                }
            });
        });
    });
</script>

{{-- for sub category --}}
<script>
    $(document).ready(function () {
    $("#employeeCategory").change(function () {
        var category = $(this).val();
        var subcategories = [];

        // Clear existing options
        $("#employeeSubcategory").empty();

        // Populate subcategories based on selected category
        switch (category) {
            case 'hr':
                subcategories = ['Recruiter', 'Payroll Manager', 'Training and Development Manager'];
                break;
            case 'developer':
                subcategories = ['Frontend', 'Backend', 'Fullstack', 'Data Scientist'];
                break;
            case 'tester':
                subcategories = ['Automated', 'Manual'];
                break;
            default:
                subcategories = [];
                break;
        }

        // Add subcategory options to the dropdown
        $.each(subcategories, function (index, subcategory) {
            $("#employeeSubcategory").append('<option value="' + subcategory.toLowerCase() + '">' + subcategory + '</option>');
        });

        // Show subcategory dropdown if subcategories exist, otherwise hide it
        if (subcategories.length > 0) {
            $("#subcategoryContainer").show();
        } else {
            $("#subcategoryContainer").hide();
        }
    });

    // Trigger change event to populate subcategories initially
    $("#employeeCategory").trigger('change');
});
</script>
