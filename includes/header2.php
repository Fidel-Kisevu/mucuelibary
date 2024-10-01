<?php
session_start();
include 'db_connection.php';

// Redirect to login if user is not logged in
if (!isset($_SESSION['name'])) {
    echo '<script type="text/javascript">window.location="../public/login.php";</script>';
    exit();
}

// Get notification count for book requests
$not = 0;
$res = mysqli_query($conn, "SELECT * FROM request_books WHERE read1 = 'no'");
$not = mysqli_num_rows($res);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUCU E-LIB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="../assets/css/custom.css" rel="stylesheet">

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .header {
            background-color: #444444; /* Charcoal color */
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header .menu-icon {
            font-size: 1.5rem;
            cursor: pointer;
        }
        .header .icons {
            display: flex;
            align-items: center;
        }
        .header .icons .icon {
            margin-right: 20px;
            font-size: 1.5rem;
            cursor: pointer;
        }
        .profile-dropdown {
            position: relative;
        }
        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
        }
        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 50px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            display: none;
            z-index: 1;
        }
        .dropdown-menu a {
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
            display: block;
        }
        .dropdown-menu a:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="menu-icon">
            <i class="fas fa-bars"></i>
        </div>

        <div class="icons">
            <div class="icon">
                <i class="fas fa-bell"></i>
            </div>
        
            <div class="profile-dropdown">
                <img src="profile.jpg" alt="Profile" class="profile-image" id="profileImage">
               
                <div class="dropdown-menu" id="dropdownMenu">
                <a href="profile.php" class="btn btn-primary p-1">Profile</a>
                <a href="logout.php" class="btn btn-danger p-1">Logout</a>
       
                </div>
            </div>
        </div>
    </header>

    <script>
        $(document).ready(function() {
            // Toggle the dropdown menu on profile image click
            $('#profileImage').click(function() {
                $('#dropdownMenu').toggle();
            });

            // Close the dropdown when clicking outside of it
            $(document).click(function(event) {
                if (!$(event.target).closest('#profileImage, #dropdownMenu').length) {
                    $('#dropdownMenu').hide();
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>