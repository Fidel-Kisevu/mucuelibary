<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle the file upload
    $name = htmlspecialchars($_POST['name']);
    $uploadDir = 'uploads/'; // Corrected path
    $uploadFile = $uploadDir . basename($_FILES['photo']['name']);

    // Move the uploaded file to the designated directory
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
        $message = "File is valid, and was successfully uploaded.\n";
        $uploadedPhoto = $uploadFile; // Store the path of the uploaded photo
    } else {
        $message = "Possible file upload attack!\n";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Registration Form</h1>
        <form action="" method="post" enctype="multipart/form-data" class="mt-4">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="photo">Upload Photo:</label>
                <input type="file" name="photo" id="photo" class="form-control-file" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <?php if (isset($uploadedPhoto)): ?>
            <div class="mt-4 text-center">

                
                <img src="<?php echo $uploadedPhoto; ?>" alt="Uploaded Photo" class="img-fluid" style="max-width: 300px;">
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
