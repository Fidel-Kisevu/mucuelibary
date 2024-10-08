<?php
session_start();
include('../includes/db_connection.php');

// Initialize variables for messages
$alert = "";
$alert_type = "";

// Handle the login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $regno = $_POST['regno']; // Change from admission_number to regno
    $password = $_POST['password'];

    // Prepare the SQL query to fetch the user from the database using registration number
    $sql = "SELECT * FROM students WHERE regno = ?"; // Assuming 'regno' is the registration number field in your 'students' table
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $regno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user information in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['full_name']; // Change from 'name' to 'full_name' to match registration

            // Set success alert
            $alert = "Login successful! Welcome, " . $_SESSION['name'] . "!";
            $alert_type = "success";

            // Redirect to index page after setting the alert
            header("Location: ../index.php?alert=" . urlencode($alert) . "&type=" . $alert_type);
            exit();
        } else {
            $alert = "Invalid password!";
            $alert_type = "danger";
        }
    } else {
        $alert = "No user found with that registration number!";
        $alert_type = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - eLibrary</title>
    
    <!-- Bootstrap CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600" rel="stylesheet">
    <link href="../assets/css/custom.css" rel="stylesheet">
</head>
<body>

<div class="bg" id="login-bg">
    <div class="form-container">
        <h2 class="text-center">Library Management System</h2>
        <h4 class="text-center mb-4">Login to eLibrary</h4>

        <!-- Display alert message if any -->
        <?php if (!empty($alert)): ?>
            <div class="alert alert-<?php echo $alert_type; ?> text-center">
                <?php echo $alert; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="regno">Registration Number <span class="text-danger">*</span></label> <!-- Adjusted label -->
                <input type="text" class="form-control" id="regno" name="regno" value="<?php echo isset($regno) ? $regno : ''; ?>" placeholder="Registration Number" required>
            </div>

            <div class="form-group">
                <label for="password">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <p>Don't have an account? <a href="signup.php">Register here</a></p>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
