<?php 

require 'init.php';
$title = 'Signup';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    
    $username = trim($_POST['username']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid Email';
    }
    if (!preg_match("/^[a-zA-Z0-9 ]+$/", $first_name)) {
        $errors['first_name'] = 'Invalid First Name';
    }
    if (!preg_match("/^[a-zA-Z0-9 ]+$/", $last_name)) {
        $errors['last_name'] = 'Invalid Last Name';
    }
    if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $errors['username'] = 'Invalid Username';
    }
    if (strlen($password) < 8) {
        $errors['password'] = 'Password should be at least 8 characters long';
    }

    if (empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $date = date('Y-m-d H:i:s');
        $role = 'user';
        
        $query = "INSERT INTO users (username, first_name, last_name, email, password, role, date) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssss", $username, $first_name, $last_name, $email, $password, $role, $date);
        $stmt->execute();
        
        $message = "User created successfully";
        redirect('login');
    }
}

?>

<?php require 'header.php'; ?>
    
<div class="class_81">
    <div class="class_82">
        <form method="post" enctype="multipart/form-data" class="class_83">
            <h1 class="class_84" spellcheck="false">Sign Up</h1>
            <div class="class_85">
                <img src="assets/images/img_2.jpg" class="class_71">
            </div>
            <div style="color:red; padding: 10px;">
                <?php if (!empty($errors)) { echo implode("<br>", $errors); } ?>
            </div>
            <div class="class_87">
                <label class="class_88">Username</label>
                <input type="text" name="username" class="class_14" value="<?= htmlspecialchars($username ?? '') ?>">
            </div>
            <div class="class_87">
                <label class="class_89">First Name</label>
                <input type="text" name="first_name" class="class_14" value="<?= htmlspecialchars($first_name ?? '') ?>">
            </div>
            <div class="class_87">
                <label class="class_88">Last Name</label>
                <input type="text" name="last_name" class="class_14" value="<?= htmlspecialchars($last_name ?? '') ?>">
            </div>
            <div class="class_87">
                <label class="class_88">Email</label>
                <input type="text" name="email" class="class_14" value="<?= htmlspecialchars($email ?? '') ?>">
            </div>
            <div class="class_87">
                <label class="class_89">Password</label>
                <input type="password" name="password" class="class_14">
            </div>
            <div> Already have an account? <a href="login.php">Login here</a></div>
            <button class="class_90">SignUp</button>
        </form>
    </div>
</div>

<?php require 'footer.php'; ?>
