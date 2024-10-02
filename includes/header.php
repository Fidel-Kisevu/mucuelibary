<?php

session_start();
include('includes/db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['name'])) {
    header("Location: ../public/login.php");
    exit();
}

// Fallback image if the profile image is not set
$profileImage = isset($_SESSION['profile_image']) && !empty($_SESSION['profile_image']) ? '../uploads/images/' . $_SESSION['profile_image'] : '../uploads/images/default_profile.jpg';

// Get the user's name from the session
$userName = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eLIB</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <style>
      
    </style>
</head>
<body>

<header class="header bg-primary d-flex text-primary">
    <div class="profile-dropdown mr-3">
        <!-- Display user profile image and name from session -->
        <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="Profile" class="profile-image">
        <span class="ms-2 text-white"><?php echo htmlspecialchars($userName); ?></span>
        <div class="dropdown-arrow"></div> 
        <div class="dropdown-menu">
            <a href="#">My Profile</a>
            <a href="#">Settings</a>
            <a href="../public/logout.php">Logout</a>
        </div>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle dropdown on click
    document.querySelector('.profile-dropdown').addEventListener('click', function () {
        const dropdownMenu = this.querySelector('.dropdown-menu');
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Close dropdown when clicking outside
    window.addEventListener('click', function (e) {
        const dropdownMenu = document.querySelector('.dropdown-menu');
        if (!document.querySelector('.profile-dropdown').contains(e.target)) {
            dropdownMenu.style.display = 'none';
        }
    });
</script>
</body>
</html>
