<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">

<style>
    form select{
        color:rgb(110, 110, 110);
        border-radius:5px;
        width:525px;
        height:40px;
        background-color: rgb(255, 255, 255);
        border-color:rgb(206, 206, 206);
    }
    </style>
<div class="container mt-5">
    <form action="{{ route('employees.search') }}" method="GET" id="result">
        <div class="row">
            <div class="col-md-6 mb-3">
                <input type="text" name="id" class="form-control" placeholder="Search by ID">
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" name="name" class="form-control" placeholder="Search by Name">
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" name="email" class="form-control" placeholder="Search by Email">
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" name="mobile" class="form-control" placeholder="Search by Mobile">
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" name="address" class="form-control" placeholder="Search by Address">
            </div>
            <div class="col-md-6 mb-3">
                <select name="gender" class="form-select">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <select name="category" class="form-select">
                    <option value="">Select Category</option>
                    <option value="hr">HR</option>
                    <option value="developer">Developer</option>
                    <option value="tester">Tester</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <select name="subcategory" class="form-select">
                    <option value="">Select Subcategory</option>
                    <option value="recruiter">Recruiter</option>
                    <option value="payrolemanager">Payroll Manager</option>
                    <option value="trainingmanager">Training Manager</option>
                    <option value="frontend">Frontend</option>
                    <option value="backend">Backend</option>
                    <option value="fullstack">Fullstack</option>
                    <option value="datascientist">Data Scientist</option>
                    <option value="automated">Automated</option>
                    <option value="manual">Manual</option>
                </select>
            </div>
        </div>
        <center><div class="col-md-4 mb-3">
            <!-- Search button with icon -->
            <button type="submit" id="s" class="btn btn-warning w-100">
                <i class="fas fa-search"></i> Search
            </button>
        </div></center>
    </form>
</div>

<div id="maincontent2"></div>

<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Include Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<script>
    $(document).ready(function() {
        // Target the search button click event
        $("button[type='submit']").click(function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Collect form data
            var formData = $("#result").serialize();

            // Send AJAX request
            $.ajax({
                url: "{{ route('employees.search') }}",
                type: "GET",
                data: formData, // Send the form data
                success: function(response) {
                    $("#maincontent2").html(response);
                },
                error: function() {
                    $("#maincontent2").html("<p>Error loading content.</p>");
                }
            });
        });
    });
</script>
