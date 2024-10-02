<?php
// Start the session at the beginning of the script
session_start();

// Include your database connection file
include('../includes/db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['name'])) { // Assuming you store user ID in session
    header("Location: ../public/login.php");
    exit();
}

// Fetch user details from the database
$userId = $_SESSION['name']; // Get user ID from session

// Check if the database connection is established
if ($conn === null) {
    die("Database connection failed.");
}

// Prepare the SQL statement to fetch user details
$query = "SELECT * FROM students WHERE full_name = ?";
$stmt = $conn->prepare($query); // Prepare the SQL statement
$stmt->bind_param("i", $userId); // Bind the user ID parameter
$stmt->execute(); // Execute the statement
$result = $stmt->get_result(); // Get the result

// Check if the user exists
if ($result->num_rows > 0) {
    $userDetails = $result->fetch_assoc(); // Fetch the user details as an associative array
} else {
    echo "User not found.";
    exit();
}
?>

<h2>Your Profile</h2>
<p>Welcome, <?php echo htmlspecialchars($userDetails['full_name']); ?>! Here are your profile details:</p>

<table class="table">
    <tr>
        <th>Name</th>
        <td><?php echo htmlspecialchars($userDetails['full_name']); ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?php echo htmlspecialchars($userDetails['email']); ?></td>
    </tr>
    <tr>
        <th>Phone</th>
        <td><?php echo htmlspecialchars($userDetails['phone']); ?></td>
    </tr>
    <tr>
        <th>Address</th>
        <td><?php echo htmlspecialchars($userDetails['address']); ?></td>
    </tr>
    
</table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
