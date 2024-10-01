<?php
session_start();
include('../includes/db_connection.php'); // Adjusted for your project

// Initialize variables and error messages
$error_reg = $error_email = $error_phone = $error_pw = $error_pw_confirm = "";
$s_msg = $error_m = "";
$is_valid = true;
$success = false; // Variable to track successful registration

// Form submission handler
if (isset($_POST['submit'])) {
    // Retrieve and sanitize form inputs
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password_confirm = mysqli_real_escape_string($conn, $_POST['password_confirm']);
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $sem = $_POST['sem'];
    $session = mysqli_real_escape_string($conn, trim($_POST['session']));
    $regno = mysqli_real_escape_string($conn, trim($_POST['regno']));
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));

    // Validate form inputs
    if (empty($regno)) {
        $error_reg = "Registration number is required";
        $is_valid = false;
    } else {
        // Check if the registration number already exists
        $result = mysqli_query($conn, "SELECT * FROM users WHERE regno='$regno'");
        if (mysqli_num_rows($result) > 0) {
            $error_reg = "Registration number already exists";
            $is_valid = false;
        }
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_email = "Valid email is required";
        $is_valid = false;
    } else {
        // Check if email already exists
        $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($result) > 0) {
            $error_email = "Email already exists";
            $is_valid = false;
        }
    }

    if (empty($phone) || !preg_match('/^\d{10}$/', $phone)) {
        $error_phone = "Valid 10-digit phone number is required";
        $is_valid = false;
    }

    if (empty($password) || strlen($password) < 6) {
        $error_pw = "Password must be at least 6 characters long";
        $is_valid = false;
    } elseif ($password !== $password_confirm) {
        $error_pw_confirm = "Passwords do not match";
        $is_valid = false;
    }

    // If valid, insert data into the database
    if ($is_valid) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        // Insert user data into the database
        $query = "INSERT INTO users (name, password, email, phone, sem, session, regno, address, status) 
                  VALUES ('$name', '$hashed_password', '$email', '$phone', '$sem', '$session', '$regno', '$address', 'active')";

        if (mysqli_query($conn, $query)) {
            $success = true; // Set success variable to true
            // Optionally redirect after registration
            header("Location: login.php");
            exit();
        } else {
            $error_m = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eLibrary Registration</title>

    <!-- Bootstrap CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head> 
<body>
    <div class="bg" id="sign-up-bg">
        <div class="form-container">
            <h2 class="text-center">eLibrary Registration</h2>
            <h4 class="text-center mb-4">Register as a Student</h4>

            <form action="" method="post">
                <!-- Success and Error messages -->
                <?php if ($s_msg): ?>
                    <div class="alert alert-success"><?php echo $s_msg; ?></div>
                <?php endif ?>
                <?php if ($error_m): ?>
                    <div class="alert alert-danger"><?php echo $error_m; ?></div>
                <?php endif ?>

                <div class="form-group mb-3">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Your Name" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required />
                </div>

                <div class="form-group mb-3">
                    <label for="regno">Registration No <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Registration No" name="regno" value="<?php echo isset($regno) ? $regno : ''; ?>" required />
                    <?php if ($error_reg): ?>
                        <span class="error"><?php echo $error_reg; ?></span>
                    <?php endif ?>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" required />
                        <span id="togglePassword" class="input-group-text" style="cursor: pointer;"><i class="fas fa-eye"></i></span>
                    </div>
                    <?php if ($error_pw): ?>
                        <span class="error"><?php echo $error_pw; ?></span>
                    <?php endif ?>
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirm">Confirm Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirm" id="password_confirm" required />
                        <span id="togglePasswordConfirm" class="input-group-text" style="cursor: pointer;"><i class="fas fa-eye"></i></span>
                    </div>
                    <?php if ($error_pw_confirm): ?>
                        <span class="error"><?php echo $error_pw_confirm; ?></span>
                    <?php endif ?>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required />
                    <?php if ($error_email): ?>
                        <span class="error"><?php echo $error_email; ?></span>
                    <?php endif ?>
                </div>

                <div class="form-group mb-3">
                    <label for="phone">Phone No <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Phone No" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>" required />
                    <?php if ($error_phone): ?>
                        <span class="error"><?php echo $error_phone; ?></span>
                    <?php endif ?>
                </div>

                <div class="form-group mb-3">
                    <label for="sem">Select Year Semester <span class="text-danger">*</span></label>
                    <select class="form-control" name="sem" required>
                        <option value="" disabled selected>Select your semester</option>
                        <option>Yr 1 Sem 1</option>
                        <option>Yr 1 Sem 2</option>
                        <option>Yr 2 Sem 1</option>
                        <option>Yr 2 Sem 2</option>
                        <option>Yr 3 Sem 1</option>
                        <option>Yr 3 Sem 2</option>
                        <option>Yr 4 Sem 1</option>
                        <option>Yr 4 Sem 2</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="session">Course of Study <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="BSc Computer Science" name="session" value="<?php echo isset($session) ? $session : ''; ?>" required />
                </div>

                <div class="form-group mb-3">
                    <label for="address">Residence Area / Hostel <span class="text-danger">*</span></label>
                    <textarea name="address" class="form-control" placeholder="Your Address" required><?php echo isset($address) ? $address : ''; ?></textarea>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Register</button>
            </form>

            <div class="text-center mt-3">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye-slash');
            this.querySelector('i').classList.toggle('fa-eye');
        });

        // Toggle confirm password visibility
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
        const passwordConfirm = document.getElementById('password_confirm');

        togglePasswordConfirm.addEventListener('click', function () {
            const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirm.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye-slash');
            this.querySelector('i').classList.toggle('fa-eye');
        });

        // Show alert if registration was successful
        <?php if ($success): ?>
            alert("Registration successful! Please log in.");
        <?php endif; ?>
    </script>
</body>
</html>
