<?php
session_start();
include 'db_connection.php';

// Redirect to login if user is not logged in
if (!isset($_SESSION['name'])) {
    header('Location: ../public/login.php');
    exit();
}

// Get notification count for book requests
$not = 0;
$query = "SELECT * FROM request_books WHERE read1 = 'no'";
if ($res = mysqli_query($conn, $query)) {
    $not = mysqli_num_rows($res);
}

// Initialize a variable for the user's photo (default image)
$user_photo = '../public/uploads/default.jpg'; // Default image path

// Check if the user is logged in and fetch the user's profile photo from the database
if (isset($_SESSION['name'])) {
    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT photo FROM users WHERE name = ?");
    $stmt->bind_param("s", $_SESSION['name']);
    $stmt->execute();
    
    // Get the result of the query
    $result = $stmt->get_result();

    // Fetch the user data and set the photo
    if ($row = $result->fetch_assoc()) {
        // If the photo field is not empty, use the photo from the database
        $user_photo = !empty($row['photo']) ? $row['photo'] : '../public/uploads/default.jpg'; // Default image if none is set
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library Management System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!--- Custom CSS --->
    <link href="../assets/css/custom.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <div id="navbar-brand"> <!-- Navbar Brand -->
            <a class="navbar-brand" href="#">
                <i class="fas fa-book"></i> MUCU E-Library
            </a>
        </div>

        <!-- Right section -->
        <div class="navbar-custom-menu d-flex">
            <!-- Sidebar toggle button -->
            <a href="#" class="sidebar-toggle" id="menu-toggle" role="button">
                <i class="fas fa-bars"></i>
            </a>

            <div class="right-most d-flex ml-0">
                <!-- Notification Icon -->
                <div class="position-relative mr-4">
                    <a href="requested-books.php" class="text-light" title="Notifications">
                        <i class="fas fa-bell fa-lg"></i>
                        <span class="badge badge-custom"><?php echo $not; ?></span>
                    </a>
                </div>

                <!-- User Menu -->
                <div class="dropdown user-menu mr-0">
                <a href="#" class="dropdown-toggle text-primary" data-toggle="dropdown">
                        <img src="<?php echo htmlspecialchars($user_photo); ?>" class="rounded-circle user-image" alt="Profile" height="40" width="40">
                        <span class="text-primary"><?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'User'; ?></span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right shadow bg-primary">
                        <!-- User image and name -->
                        <li class="user-header p-0">
                            <p class="text-primary p-1"><?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'User'; ?> Librarian</p>
                        </li>
                        <!-- Menu Footer -->
                        <li class="user-footer">
                            <a href="../public/profile.php" class="btn btn-primary p-1">Profile</a>
                            <a href="logout.php" class="btn btn-danger p-1">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <script src="../assets/js/jquery-3.5.1.min.js"></script>
    <script src="../assets/js/bundle.min.js"></script>

    <script>
        document.querySelector(".btn-danger").addEventListener("click", function () {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php"; // Redirect to logout page
            }
        });
    </script>

</body>
</html>
