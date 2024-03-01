<div id="success-message" style="color: green;"></div>
<div id="error-message" style="color: red;"></div>
    <div class="container mt-5">
        <h2 class="mb-4">Assign Task to Employee</h2>
        <form action="{{ route('tasks.store') }}" method="POST" id="assignTaskForm">
            @csrf
            <div class="form-group">
                <label for="category">Select Category:</label>
                <select class="form-control" id="category" name="category">
                    <option value="">Select Category</option>
                    <option value="HR">HR</option>
                    <option value="Developer">Developer</option>
                    <option value="Tester">Tester</option>
                </select>
            </div>
            <div class="form-group">
                <label for="subcategory">Select Subcategory:</label>
                <select class="form-control" id="subcategory" name="subcategory" disabled>
                    <option value="">Select Subcategory</option>
                    <!-- Options will be populated via JavaScript based on the selected category -->
                </select>
            </div>
            <div class="form-group">
                <label for="employee_id">Select Employee:</label>
                <select class="form-control" id="employee_id" name="employee_id" disabled>
                    <option value="">Select Employee</option>
                    <!-- Options will be populated via AJAX based on the selected subcategory -->
                </select>
            </div>
            <div class="form-group">
                <label for="employee_name">Employee Name:</label>
                <input type="text" class="form-control" id="employee_name" name="employee_name" readonly>
            </div>
            <div class="form-group">
                <label for="task_name">Task Name:</label>
                <input type="text" class="form-control" id="task_name" name="task_name" required>
            </div>
            <div class="form-group">
                <label for="scheduled_time">Scheduled Time:</label>
                <input type="datetime-local" class="form-control" id="scheduled_time" name="scheduled_time" required>
            </div>
            <!-- Hidden field to store the selected employee's ID -->
            <input type="hidden" id="selected_employee_id" name="selected_employee_id">
            <button type="submit" class="btn btn-primary">Assign Task</button>
        </form>
    </div>
    <div id="message" class="mt-3"></div>
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            // When a category is selected, populate the subcategory dropdown accordingly
            $('#category').change(function() {
                var category = $(this).val();
                $('#subcategory').html('<option value="">Select Subcategory</option>');
                switch (category) {
                    case 'HR':
                        var subcategories = ['Recruiter', 'Payroll Manager', 'Training and Development Manager'];
                        break;
                    case 'Developer':
                        var subcategories = ['Frontend', 'Backend', 'Fullstack', 'Data Scientist'];
                        break;
                    case 'Tester':
                        var subcategories = ['Automated', 'Manual'];
                        break;
                    default:
                        var subcategories = [];
                }
                // Populate the subcategory dropdown
                subcategories.forEach(function(subcategory) {
                    $('#subcategory').append('<option value="' + subcategory.toLowerCase().replace(/\s+/g, '') + '">' + subcategory + '</option>');
                });
                $('#subcategory').prop('disabled', false);
            });

            // When a subcategory is selected, populate the employee dropdown accordingly
$('#subcategory').change(function() {
    var subcategory = $(this).val();
    if (subcategory) {
        $('#employee_id').prop('disabled', false);
        $('#employee_id').html('<option value="">Loading...</option>');
        $.ajax({
            type: 'GET',
            url: '/employees/' + subcategory,
            success: function(data) {
                $('#employee_id').html(data);
            },
            error: function() {
                $('#employee_id').html('<option value="">Unable to fetch employees</option>');
            }
        });
    } else {
        $('#employee_id').prop('disabled', true);
        $('#employee_id').html('<option value="">Select Employee</option>');
    }
});


            // Store the selected employee's ID and name in hidden input fields when an employee is selected
            $('#employee_id').change(function() {
                var selectedEmployeeId = $(this).val();
                var selectedEmployeeName = $(this).find('option:selected').text();
                $('#selected_employee_id').val(selectedEmployeeId);
                $('#employee_name').val(selectedEmployeeName);
            });
        });




        //
        //
        document.getElementById('assignTaskForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            fetch('/assign-task', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                var messageElement = document.getElementById('message');
                if (data.success) {
                    // Task assigned successfully
                    messageElement.className = 'alert alert-success';
                    messageElement.innerText = data.message;
                    document.getElementById('task_name').value = ''; // Clear the task name input field
                } else {
                    // Error occurred
                    messageElement.className = 'alert alert-danger';
                    var errorMessage = "Error:\n";
                    data.errors.forEach(function(error) {
                        errorMessage += error + "\n";
                    });
                    messageElement.innerText = errorMessage;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('message').innerText = "An error occurred while processing your request.";
            });
        });

    </script>
