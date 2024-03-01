
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Employee-dash</title>
  <link rel="website icon" type="png"  href="images/logo1.png">

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="icon" type="image/png" sizes="32x32" href="https://www.google.com/s2/favicons?domain=example.com">
  <style>
    body {
      font-family: "Arial", sans-serif;
      background-color: white;/* background-image: linear-gradient(to bottom, #b7feff, #8b9ed3); */
    }

    .sidenav,.list-group-item{
      background-color: #146678;
      color:white;
    }
    #wrapper {
      overflow-x: hidden;
    }

    #sidebar-wrapper {
      min-height: 100vh;
      margin-left: -15rem;
      transition: margin 0.5s;
    }

    #sidebar-wrapper .sidebar-heading {
      padding: 0.875rem 1.25rem;
      font-size: 1.2rem;
    }

    #sidebar-wrapper .list-group {
      width: 15rem;
    }

    #page-content-wrapper {
      width: 100%;
    }

    #menu-toggle {
      cursor: pointer;
    }

    #wrapper.toggled #sidebar-wrapper {
      margin-left: 0;
    }

    #menu-icon {
      transition: transform 0.3s;
    }

    #wrapper.toggled #menu-icon {
      transform: rotate(180deg);
    }

    /* Responsive Styles */
    @media (max-width: 992px) {
      #sidebar-wrapper {
        margin-left: 0;
      }

      #wrapper.toggled #sidebar-wrapper {
        margin-left: -15rem;
      }
    }

    /* Additional styles for the dropdown menu */
    .dropdown-menu {
      min-width: 200px;
    }

    #adminDropdown {
      cursor: pointer;
    }

    /* Adjustments for uniform spacing */
    .list-group-item {
      display: flex;
      align-items: center;
      padding: 0.5rem 1.25rem;
    }

    .list-group-item i {
      margin-right: 10px;
      width: 20px;
    }
  </style>

</head>

<body>


  <div class="d-flex" id="wrapper">




    <div class="sidenav" id="sidebar-wrapper">
      <div class="sidebar-heading">Employee Dashboard</div>
      <div class="list-group list-group-flush">

        <a href="#" class="list-group-item list-group-item-action" data-content="stores" id="viewemp">
          <i class="fas fa-users"></i> View Your Details
        </a>

        <a href="#" class="list-group-item list-group-item-action"data-content="products" id="viewtask">
          <i class="far fa-id-card"></i> View Task
        </a>

      </div>
    </div>


    <!-- Page Content -->
    <div id="page-content-wrapper">
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-default" id="menu-toggle">
          <i id="menu-icon" class="fa fa-align-justify"></i>
        </button>

        <div class="ml-auto dropdown">
            <a class="dropdown-item" href="{{route('logout')}}">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>

        </div>
      </nav>

<div class="container-fluid">
  <!--page content -->
  <div class="row">
    <div class="col-lg-12" id="mainContent">
      <h2>Employee Dashboard</h2>
      <h2>Hi, {{ \Illuminate\Support\Str::limit($employee->employeeEmail, -10) }}</h2>
      <p>As our {{$employee->employeeCategory}} ,Welcome to Your Dashboard</p>
{{-- <p>Your id is{{$employee->id}}</p> --}}
    </div>
  </div>
</div>
    </div>
    <!-- /#page-content-wrapper -->
  </div>
  <!-- /#wrapper -->

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    $("#menu-toggle").click(function (e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
      $("#menu-icon").toggleClass("fa-align-right fa-arrow-left");
    });




    $(document).ready(function() {
        $("#viewemp").click(function (event) {
            event.preventDefault();

            $.ajax({
                url: "{{ url('employee/'.$employee->id) }}",
                type: "GET",
                success: function (response) {
                    $("#mainContent").html(response);
                },
                error: function () {
                    $("#mainContent").html("<p>Error loading content.</p>");
                }
            });
        });
    });


    $(document).ready(function() {
        $("#viewtask").click(function (event) {
            event.preventDefault();

            $.ajax({
                url: "{{ url('employee.task/'.$employee->id) }}",
                type: "GET",
                success: function (response) {
                    $("#mainContent").html(response);
                },
                error: function () {
                    $("#mainContent").html("<p>Error loading content.</p>");
                }
            });
        });
    });


</script>



</body>

</html>
