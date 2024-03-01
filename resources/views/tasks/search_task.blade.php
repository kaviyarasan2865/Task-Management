<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">

<style>
    form select{
        color:rgb(110, 110, 110);
        border-radius:5px;
        width:300px;
        height:40px;
        background-color: rgb(255, 255, 255);
        border-color:rgb(206, 206, 206);
    }
    </style>

<div class="container mt-5">
    <form action="{{ route('task.searched') }}" method="GET" id="result">
        <div class="row">
            <!-- Search by Task Name -->
            <div class="col-md-4 mb-3">
                <input type="text" name="task_name" class="form-control" placeholder="Search by Task Name">
            </div>
            <!-- Search by Employee Name -->
            <div class="col-md-4 mb-3">
                <input type="text" name="employee_name" class="form-control" placeholder="Search by Employee Name">
            </div>
            <!-- Search by Status -->
            <div class="col-md-4 mb-3">
                <select name="status" class="form-select">
                    <option value="">Select Status</option>
                    <option value="yet-to-start">yet-to-start</option>
                    <option value="pending">pending</option>
                    <option value="in-progress">in-progress</option>
                    <option value="parked">parked</option>
                    <option value="complete">complete</option>
                </select>
            </div>


        </div>

        <center>
            <div class="col-md-4 mb-3">
                <button type="submit" id="s" class="btn btn-warning w-100">
                    <i class="fas fa-search"></i> Search
                </button>
            </div></center>
    </form>
</div>

<div id="maincontent5">

</div>

<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Include Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

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
                url: "{{ route('task.searched') }}",
                type: "GET",
                data: formData, // Send the form data
                success: function(response) {
                    $("#maincontent5").html(response);
                },
                error: function() {
                    $("#maincontent5").html("<p>Error loading content.</p>");
                }
            });
        });
    });
</script>
