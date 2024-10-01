<?php 
require_once 'includes/header.php'; 
include 'includes/db_connection.php';

$page = 'home';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library Management System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">


    <!-- Custom Styles -->

    <link href="../assets/css/custom.css" rel="stylesheet">
    <style>
       
    </style>
</head>
<body>

    <div class="container-fluid p-0">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 sidebar">
            <div class="sidebar-menu">
                <hr style="border: none; height: 2px; background-color: whitesmoke; opacity: 0.8;">
                <ul class="list-unstyled">
                    <li class="menu-home <?php if($page == 'home'){ echo 'active'; } ?>">
                        <a href="dashboard.php" data-page="dashboard"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li class="menu-item <?php if($page == 'profile'){ echo 'active'; } ?>">
                        <a href="profile.php" data-page="profile"><i class="fas fa-id-card"></i> Profile</a>
                    </li>
                    <li class="menu-item <?php if($page == 'sinfo'){ echo 'active'; } ?>">
                        <a href="all-student-info.php" data-page="all-student-info"><i class="fas fa-desktop"></i> All Student Information</a>
                    </li>
                    <li class="menu-item <?php if($page == 'tinfo'){ echo 'active'; } ?>">
                        <a href="all-teacher-info.php" data-page="all-teacher-info"><i class="fas fa-desktop"></i> All Administrator Information</a>
                    </li>
                    <li class="menu-item menu-toggle">
                        <a href="#" class="toggle-submenu"><i class="fas fa-location-arrow"></i> Manage Book <span class="fa fa-chevron-down"></span></a>
                        <ul class="submenu list-unstyled">
                            <li class="submenu-item"><a href="add-book.php" data-page="add-book">Add Book</a></li>
                            <li class="submenu-item"><a href="display-books.php" data-page="display-books">Display Books</a></li>
                        </ul>
                    </li>
                    <li class="menu-item menu-toggle">
                        <a href="#" class="toggle-submenu"><i class="fas fa-list-alt"></i> Issue Book <span class="fa fa-chevron-down"></span></a>
                        <ul class="submenu list-unstyled">
                            <li class="submenu-item"><a href="student-issue-book.php" data-page="student-issue-book">Student Issue Book</a></li>
                            <li class="submenu-item"><a href="teacher-issue-book.php" data-page="teacher-issue-book">Teacher Issue Book</a></li>
                        </ul>
                    </li>
                    <li class="menu-item menu-toggle">
                        <a href="#" class="toggle-submenu"><i class="fas fa-users"></i> Manage Users <span class="fa fa-chevron-down"></span></a>
                        <ul class="submenu list-unstyled">
                            <li class="submenu-item"><a href="add-student.php" data-page="add-student">Add Student</a></li>
                            <li class="submenu-item"><a href="add-teacher.php" data-page="add-teacher">Add Teacher</a></li>
                        </ul>
                    </li>
                    <li class="menu-item <?php if($page == 'ibook'){ echo 'active'; } ?>">
                        <a href="issued-books.php" data-page="issued-books"><i class="fas fa-bookmark"></i> Issued Books</a>
                    </li>
                    <li class="menu-item <?php if($page == 'rbook'){ echo 'active'; } ?>">
                        <a href="requested-books.php" data-page="requested-books"><i class="fas fa-book"></i> View Requested Books</a>
                    </li>
                    <li class="menu-item menu-toggle">
                        <a href="#" class="toggle-submenu"><i class="far fa-share-square"></i> Send Message to User <span class="fa fa-chevron-down"></span></a>
                        <ul class="submenu list-unstyled">
                            <li class="submenu-item"><a href="send-to-student.php" data-page="send-to-student">Send to Student</a></li>
                            <li class="submenu-item"><a href="send-to-teacher.php" data-page="send-to-teacher">Send to Teacher</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="dynamic-content">
            <div id="content" class="mt-4">
                <!-- Default content will be loaded here -->
            </div>
        </main>
    </div>

    <!-- jQuery, Bootstrap JS, and FontAwesome -->
    <script src="../assets/js/jquery-3.5.1.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Script for Sidebar Menu and AJAX Loading -->
    <script>
        $(document).ready(function() {
            // Load default content (dashboard page)
            $("#content").load("dashboard.php");

            // Handle sidebar menu clicks
            $('#sidebar a').click(function(e) {
                e.preventDefault(); // Prevent default link behavior
                
                var $this = $(this);
                var page = $this.data('page');

                // Check if the clicked item has a submenu
                if ($this.siblings('ul').length > 0) {
                    var $submenu = $this.siblings('ul');

                    // Close all other submenus
                    $('#sidebar ul.submenu').not($submenu).slideUp(300); // Close other submenus
                    // Toggle the clicked submenu with a sliding effect
                    $submenu.slideToggle(300);
                } else {
                    // Load the content via AJAX if no submenu
                    $('#content').load(page + '.php', function() {
                        // Set active class for menu items
                        $('#sidebar li').removeClass('active');
                        $this.parent().addClass('active');
                    });
                }
            });

            // Handle the hamburger menu toggle if you plan to implement it
            // Uncomment if you have a button for toggling the sidebar
        
            $('#menu-toggle').click(function() {
                $('#sidebar').toggleClass('show'); // Toggle sidebar visibility
                $('.dynamic-content').toggleClass('sidebar-open'); // Adjust main content
            });
        });
    </script>

</body>
</html>
