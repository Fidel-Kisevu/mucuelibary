<?php 
session_start(); // Start the session

include '../includes/db_connection.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    echo '<script>window.location="login.php";</script>';
    exit();
}

// Sanitize the input and query the database
$name = mysqli_real_escape_string($conn, $_SESSION['name']); // Sanitize the input
$query = "SELECT * FROM users WHERE name = '$name'"; // Query for user data
$res = mysqli_query($conn, $query);

// Check if the query executed successfully
if (!$res) {
    die("Query Failed: " . mysqli_error($conn));
}

// Fetch the user data, and check if user data is available
$user = mysqli_fetch_array($res);
if (!$user) {
    die("User data not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        .dashboard-content {
            padding: 30px 0;
        }

        .dashboard-header {
            background-color: #007bff;
            color: #fff;
            padding: 20px 0;
            margin-bottom: 30px;
        }

        .dashboard-header p {
            font-size: 24px;
            font-weight: bold;
        }

        .dashboard-header .left {
            padding-left: 15px;
        }

        .dashboard-header .right {
            padding-right: 15px;
        }

        .dashboard-header a {
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            margin-right: 10px;
        }

        .profile-content {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .details {
            margin-top: 20px;
        }

        .form-group label {
            font-weight: bold;
            color: #333; /* Updated label color */
        }

        .form-control {
            border-radius: 5px;
            box-shadow: none;
            border: 1px solid #ced4da;
        }

        .btn-info {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .btn-info:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .photo img {
            border-radius: 30%;
        }

        .uploadPhoto .btn {
            width: 100%;
        }

        .disabled {
            color: #6c757d;
        }

        .back-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!--dashboard area-->
<div class="dashboard-content">
    <div class="dashboard-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="left">
                        <p><span>dashboard</span> User panel</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right text-right">
                        <a href="dashboard.php"><i class="fas fa-home"></i> home</a>
                        <span class="disabled">profile</span>
                    </div>
                </div>
            </div>

            <!-- Profile content -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Display User's Current Profile Photo -->
                        <div class="photo">
                            <img src="<?php echo $user['photo']; ?>" alt="Profile Photo" height="150" width="150" class="img-thumbnail">
                        </div>
                        <!-- Upload New Photo Form -->
                        <div class="uploadPhoto mt-3">
                            <form action="profile.php" method="post" enctype="multipart/form-data">
                                <input type="file" name="image" class="form-control mb-2" id="image" required>
                                <input type="submit" class="btn btn-info" value="Upload Image" name="submit">
                            </form>
                        </div>
                        
                       <!-- Handle the Image Upload -->
                        <?php 
                        if (isset($_POST["submit"])) {
                            $target_dir = "uploads/";
                            if (!is_dir($target_dir)) {
                                mkdir($target_dir, 0777, true);
                            }
                            $image_name = basename($_FILES["image"]["name"]);
                            $target_file = $target_dir . round(microtime(true)) . '_' . $image_name;
                            $upload_ok = 1;
                            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                            $check = getimagesize($_FILES["image"]["tmp_name"]);
                            if($check !== false) {
                                $upload_ok = 1;
                            } else {
                                echo "File is not an image.";
                                $upload_ok = 0;
                            }

                            if ($_FILES["image"]["size"] > 2000000) {
                                echo "Sorry, your file is too large.";
                                $upload_ok = 0;
                            }

                            if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
                                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                $upload_ok = 0;
                            }

                            if ($upload_ok == 1) {
                                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                    $update_query = "UPDATE users SET photo='" . $target_file . "' WHERE name='" . $_SESSION['name'] . "'";
                                    mysqli_query($conn, $update_query);
                                    echo '<script>window.location="profile.php";</script>';
                                } else {
                                    echo "Sorry, there was an error uploading your file.";
                                }
                            }
                        }
                        ?>

                    </div>

                    <!-- Display and Edit User's Profile Details -->
                    <div class="col-md-9">
                        <div class="details">
                            <form method="post">
                                <div class="form-group details-control">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control custom" name="name" value="<?php echo $user['name']; ?>" disabled />
                                </div>
                                <div class="form-group details-control">
                                    <label for="session">Session (Year, Semester):</label>
                                    <input type="text" class="form-control custom" name="session" value="<?php echo $user['session']; ?>" />
                                </div>
                                <div class="form-group details-control">
                                    <label for="email">Email:</label>
                                    <input type="text" class="form-control custom" name="email" value="<?php echo $user['email']; ?>" disabled />
                                </div>
                                <div class="form-group details-control">
                                    <label for="phone">Phone No:</label>
                                    <input type="text" class="form-control custom" name="phone" value="<?php echo $user['phone']; ?>" />
                                </div>
                                <div class="form-group details-control">
                                    <label for="address">Address:</label>
                                    <input type="text" class="form-control custom" name="address" value="<?php echo $user['address']; ?>" />
                                </div>

                                <!-- Submit updated profile details -->
                                <div class="text-right mt-3">
                                    <input type="submit" value="Save" class="btn btn-info" name="update">
                                </div>
                            </form>

                            <!-- Handle Profile Update -->
                            <?php
                            if (isset($_POST["update"])) {
                                $update_query = "UPDATE users SET 
                                    session='$_POST[session]',
                                    phone='$_POST[phone]',
                                    address='$_POST[address]'
                                    WHERE name='" . $_SESSION['name'] . "'";
                                
                                mysqli_query($conn, $update_query);
                                echo '<script>window.location="profile.php";</script>'; // Refresh the page after update
                            }
                            ?>
                        </div>

                        <!-- Back to Index Page Button -->
                        <div class="back-button">
                            <a href="../index.php" class="btn btn-secondary">Back to Index</a>
                        </div>
                    </div>  
                </div>
            </div>
        </div>                    
    </div>
</div>

<!-- Scripts -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
