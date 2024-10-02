<?php
include('includes/db_connection.php');
include ('includes/header.php');

// Check if user is logged in
if (!isset($_SESSION['name'])) {
    header("Location: ../public/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eLibrary - Student Dashboard</title>
    
    <!-- Bootstrap CSS -->
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="../assets/css/custom.css" rel="stylesheet">

    <style>
       
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <!-- Menu Icon for Mobile View -->
    <div class="menu-icon text-light">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Sidebar -->
    <nav id="sidebar" class="col-md-3 col-lg-2 bg-primary">
        
        <div class="sidebar-menu">
            <h2>eLibrary</h2>
            <hr>

            <ul class="list-unstyled">
                <li class="menu-item <?php if($page == 'home'){ echo 'active';} ?>">
                    <a href="#" data-page="dashboard" onclick="loadPage('../public/dashboard.php')"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li class="menu-item <?php if($page == 'profile'){ echo 'active';} ?>">
                    <a href="#" data-page="profile" onclick="loadPage('../public/profile.php')"><i class="fas fa-id-card"></i> Profile</a>
                </li>
                <li class="menu-item menu-toggle">
                    <a href="#" class="toggle-submenu"><i class="fas fa-book"></i> Manage Books <span class="fa fa-chevron-down"></span></a>
                    <ul class="submenu list-unstyled">
                        <li class="submenu-item"><a href="#" onclick="loadPage('../public/add_book.php')">Add Book</a></li>
                        <li class="submenu-item"><a href="#" onclick="loadPage('../public/view_books.php')">View Books</a></li>
                        <li class="submenu-item"><a href="#" onclick="loadPage('../public/borrow_books.php')">Borrow Books</a></li>
                    </ul>
                </li>
                <hr>
                <li class="menu-item menu-toggle">
                    <a href="#" class="toggle-submenu"><i class="fas fa-users"></i> Manage Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="submenu list-unstyled">
                        <li class="submenu-item"><a href="#" onclick="loadPage('../public/add_student.php')">Add Student</a></li>
                        <li class="submenu-item"><a href="#" onclick="loadPage('../public/add_teacher.php')">Add Teacher</a></li>
                    </ul>
                </li>
                <li class="menu-item <?php if($page == 'notification'){ echo 'active';} ?>">
                    <a href="#" onclick="loadPage('../public/notification.php')"><i class="fas fa-bell"></i> Notifications</a>
                </li>
                <li class="menu-item <?php if($page == 'settings'){ echo 'active';} ?>">
                    <a href="#" class="toggle-submenu"><i class="fas fa-cog"></i> Settings <span class="fa fa-chevron-down"></span></a>
                    <ul class="submenu list-unstyled">
                        <li class="submenu-item"><a href="#" onclick="loadPage('../public/change_password.php')">Change Password</a></li>
                        <li class="submenu-item"><a href="#" onclick="loadPage('../public/update_info.php')">Update Info</a></li>
                    </ul>
                </li>
                <hr>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="dynamic-content bg-secondary">
    <div id="content" class="mt-4 text-center">
    <h1 class=" font-weight-bold text-secondary">Maseno Univeristy Christian Union eLibrary</h1>
    <p class="lead text-muted">Welcome, <strong><?php echo $_SESSION['name']; ?></strong>!</p>
    <hr class="my-4">
    <p class="text-secondary">Explore our extensive collection of resources designed to enrich your academic and spiritual journey.</p>
    
    <div class="mt-4">
        <h2 class="h5 font-weight-bold text-success">Why Choose Our E-Library?</h2>
        <ul class="list-unstyled">
            <li class="my-2">📚 **Diverse Collection:** Access a variety of books, articles, and multimedia content.</li>
            <li class="my-2">🔍 **Search & Discover:** Use our powerful search feature to find resources quickly.</li>
            <li class="my-2">🤝 **Community Support:** Join discussions and connect with fellow students.</li>
        </ul>
    </div>
    
    <blockquote class="blockquote mt-4">
        <p class="mb-0">"The beautiful thing about learning is that no one can take it away from you." - B.B. King</p>
    </blockquote>
    
    <a href="#" class="btn btn-primary btn-lg mt-4">Explore Resources</a>
</div>

    </main>
</div>

<!-- jQuery and AJAX -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    // Load content dynamically using AJAX
    function loadPage(page) {
        $.ajax({
            url: page,
            method: "GET",
            success: function(data) {
                $('#content').html(data);

                // Close sidebar on mobile after clicking a menu item
                if ($(window).width() <= 768) {
                    $('#sidebar').removeClass('show');
                }
            },
            error: function() {
                $('#content').html('<p>Coming Soon.</p>');
            }
        });
    }

    // Submenu toggle functionality
    $(document).ready(function() {
        $('.toggle-submenu').click(function(e) {
            e.preventDefault();
            var $submenu = $(this).next('.submenu');
            $('.submenu').not($submenu).slideUp();  // Close other open submenus
            $submenu.slideToggle();  // Toggle the clicked submenu
        });

        // Sidebar toggle functionality for mobile
        $('.menu-icon').click(function() {
            $('#sidebar').toggleClass('show');
        });

        // Close the sidebar when a menu item is clicked on mobile
        $('#sidebar .menu-item li').click(function() {
            if ($(window).width() <= 768) {
                $('#sidebar').removeClass('show');
            }
        });

        // Close the sidebar when clicking outside of it on mobile
        $(document).click(function(event) {
            var $target = $(event.target);

            // Check if the click was outside the sidebar and menu icon
            if (!$target.closest('#sidebar').length && !$target.closest('.menu-icon').length) {
                if ($(window).width() <= 768 && $('#sidebar').hasClass('show')) {
                    $('#sidebar').removeClass('show');
                }
            }
        });
    });
</script>


</body>
</html>
