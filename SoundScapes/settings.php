<?php 
require 'init.php';
$title = "Settings";

if (!is_logged_in()) {
    redirect('login');
}

$id = user('id');

$query = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
$row = query($query);

if (!empty($row)) {
    $row = $row[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $username = addslashes($_POST['username']);
    $first_name = addslashes($_POST['first_name']);
    $last_name = addslashes($_POST['last_name']);
    $email = addslashes($_POST['email']);
    $password = addslashes($_POST['password']);
    $password_string = "";
    $image_string = "";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid Email';
    }

    if (!preg_match("/^[a-zA-Z0-9 ]+$/", $first_name)) {
        $errors['first_name'] = 'Invalid First Name';
    }
    if (!preg_match("/^[a-zA-Z0-9 ]+$/", $last_name)) {
        $errors['last_name'] = 'Invalid Last Name';
    }
    if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        $errors['username'] = 'Invalid Username';
    }
    if (!empty($password) && strlen($password) < 8) {
        $errors['password'] = 'Password should be at least 8 characters long';
    }

    // 🔥 **Handle Image Upload**
    if (!empty($_FILES['image']['name'])) {
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = time() . "_" . basename($_FILES['image']['name']);
        $image_path = "uploads/" . $image_name;

        if (in_array($_FILES['image']['type'], $allowed)) {
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $image_string = ", image = '$image_path' ";

                // ✅ **Delete old image (if exists)**
                if (!empty($row['image']) && file_exists($row['image']) && $row['image'] !== 'assets/images/user.jpg') {
                    unlink($row['image']);
                }
            } else {
                $errors['image'] = "Image upload failed.";
            }
        } else {
            $errors['image'] = "Image type not supported.";
        }
    }

    if (empty($errors)) {
        if (!empty($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $password_string = ", password = '$password'";
        }

        // 🔥 **Update the database correctly**
        $query = "UPDATE users SET 
                    username = '$username', 
                    first_name = '$first_name', 
                    last_name = '$last_name', 
                    email = '$email' 
                    $password_string 
                    $image_string 
                  WHERE id = '$id'";
        
        query($query);

        // ✅ **Update Session**
        if (!empty($image_string)) {
            $_SESSION['USER']['image'] = $image_path;
        }

        redirect('profile');
    }
}

require 'header.php';
?>

<!-- ✅ Fixed Form Layout & Styling -->
<div class="settings-container">
    <h1 class="settings-title">Artist Settings</h1>

    <form method="post" enctype="multipart/form-data" class="settings-form">
        <!-- Display errors -->
        <div class="error-message">
            <?php
            if (!empty($errors)) {
                echo implode("<br>", $errors);
            }
            ?>
        </div>

        <!-- Profile Image Upload -->
        <div class="image-container">
            <img src="<?= get_image($row['image']) ?>" class="profile-image" id="profilePreview">
            <input onchange="previewImage(event)" type="file" name="image" class="file-input">
        </div>

        <!-- Form Fields -->
        <div class="input-group">
            <label>Username</label>
            <input value="<?= old_value('username', $row['username']) ?>" type="text" name="username">
        </div>
        <div class="input-group">
            <label>First Name</label>
            <input value="<?= old_value('first_name', $row['first_name']) ?>" type="text" name="first_name">
        </div>
        <div class="input-group">
            <label>Last Name</label>
            <input value="<?= old_value('last_name', $row['last_name']) ?>" type="text" name="last_name">
        </div>
        <div class="input-group">
            <label>Email</label>
            <input value="<?= old_value('email', $row['email']) ?>" type="text" name="email">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input placeholder="Leave empty to keep old password" type="password" name="password">
        </div>

        <!-- Buttons -->
        <div class="button-group">
            <button type="submit" class="save-button">Save</button>
            <a href="profile.php">
                <button type="button" class="cancel-button">Cancel</button>
            </a>
        </div>
    </form>
</div>

<?php require 'footer.php'; ?>

<!-- ✅ Image Preview Script -->
<script>
function previewImage(event) {
    const imagePreview = document.getElementById("profilePreview");
    imagePreview.src = URL.createObjectURL(event.target.files[0]);
}
</script>

<!-- ✅ Fixed CSS -->
<style>
body {
    background-color: #121212; /* Dark background */
    color: #e0e0e0; /* Light gray text */
}

.settings-container {
    max-width: 500px; /* Set a reasonable width */
    margin: auto;
    padding: 20px;
    background: #2c2c2c; /* Dark background for container */
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
}

.settings-title {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
    color: #9c27b0; /* Purple color for title */
}

.error-message {
    color: red;
    text-align: center;
    margin-bottom: 10px;
}

.image-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 15px;
}

.profile-image {
    width: 120px;  /* Set fixed size */
    height: 120px;
    border-radius: 50%;
    object-fit: cover; /* Prevent distortion */
    border: 2px solid #9c27b0; /* Purple border */
    margin-bottom: 10px;
}

.file-input {
    text-align: center;
}

.input-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 10px;
}

.input-group label {
    font-weight: bold;
    margin-bottom: 5px;
    color: #9c27b0; /* Purple color for labels */
}

.input-group input {
    padding: 8px;
    border: 1px solid #9c27b0; /* Purple border for input fields */
    border-radius: 5px;
    font-size: 16px;
    background-color: #333; /* Dark background for input fields */
    color: #e0e0e0; /* Light text color for inputs */
}

.button-group {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}

.save-button, .cancel-button {
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
}

.save-button {
    background-color: #9c27b0; /* Purple background for save button */
    color: white;
}

.cancel-button {
    background-color: #f44336; /* Red background for cancel button */
    color: white;
}
</style>
