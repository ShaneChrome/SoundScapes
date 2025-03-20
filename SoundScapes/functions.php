<?php
// functions.php

// Database connection function using mysqli
function db_connect() {
    $servername = "sql311.infinityfree.com";
    $username   = "if0_38549212";
    $password   = "9bgNmxwVzue";
    $dbname     = "if0_38549212_sound_scapes_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
$conn = db_connect(); // Assign the connection to $conn
session_start();

function is_logged_in(): bool {
    return !empty($_SESSION['USER']) && is_array($_SESSION['USER']);
}

function is_admin(): bool {
    return !empty($_SESSION['USER']) && is_array($_SESSION['USER']) && $_SESSION['USER']['role'] === 'admin';
}

function auth($row) {
    $_SESSION['USER'] = $row;
}

function get_image($path) {
    return (file_exists($path ?? '')) ? $path : 'assets/images/2.jpg?1';
}

function user($key) {
    return !empty($_SESSION['USER'][$key]) ? $_SESSION['USER'][$key] : '';
}

function esc($str) {
    return htmlspecialchars($str);
}

function redirect($page) {
    header("Location: " . $page . ".php");
    die;
}

function message($message = "", $delete = false) {
    if (!empty($message)) {
        $_SESSION['message'] = $message;
    } else {
        if (!empty($_SESSION['message'])) {
            $msg = $_SESSION['message'];
            if ($delete) {
                unset($_SESSION['message']);
            }
            return $msg;
        }
    }
    return "";
}

function old_value($key, $default = "") {
    return !empty($_POST[$key]) ? $_POST[$key] : $default;
}

function query($query) {
    /* Note: $con should be defined in your connection initialization */
    global $con;
    $result = mysqli_query($con, $query);
    if (!is_bool($result) && mysqli_num_rows($result) > 0) {
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    return false;
}

function add_page_view($soundscape_id) {
    $query = "UPDATE soundscapes SET plays = plays + 1 WHERE id = '$soundscape_id' LIMIT 1";
    query($query);
}

function add_rating($soundscape_id, $rating) {
    $user_id = user('id'); 
    if ($rating < 1 || $rating > 5) return false;

    if (!user_has_rated($user_id, $soundscape_id)) {
        $query = "INSERT INTO ratings (user_id, soundscape_id, rating, created_at) VALUES ('$user_id', '$soundscape_id', '$rating', NOW())";
        query($query);
    }
}

function get_user_rating($user_id, $soundscape_id) {
    $query = "SELECT rating FROM ratings WHERE user_id = '$user_id' AND soundscape_id = '$soundscape_id' LIMIT 1";
    $result = query($query);
    return !empty($result) ? $result[0]['rating'] : null;
}

function user_has_rated($user_id, $soundscape_id) {
    $query = "SELECT * FROM ratings WHERE user_id = '$user_id' AND soundscape_id = '$soundscape_id' LIMIT 1";
    return query($query) ? true : false;
}

function get_average_rating($soundscape) {
    $soundscape_id = $soundscape['id'];
    $query = "SELECT AVG(rating) as average_rating FROM ratings WHERE soundscape_id = '$soundscape_id'";
    $result = query($query);
    return !empty($result) ? round($result[0]['average_rating'], 1) : 0;
}

function get_reviews($soundscape_id) {
    $query = "SELECT r.review, r.created_at, u.first_name, u.last_name, u.username 
              FROM reviews r 
              LEFT JOIN users u ON r.user_id = u.id 
              WHERE r.soundscape_id = '$soundscape_id' 
              ORDER BY r.created_at DESC";
    return query($query);
}

// Updated add_review function without the rating field,
// since ratings are managed in the ratings table
function add_review($soundscape_id, $user_id, $review) {
    $soundscape_id = (int)$soundscape_id;
    $user_id       = (int)$user_id;
    $review        = addslashes($review); // Escape for SQL safety

    // Validate parameters
    if ($user_id <= 0 || empty($review)) {
        return "Invalid parameters";
    }

    // Connect to the database using mysqli
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        return "Connection failed: " . mysqli_connect_error();
    }

    // Insert the review record into the database without the rating column
    $query = "INSERT INTO reviews (soundscape_id, user_id, review, created_at) 
              VALUES ('$soundscape_id', '$user_id', '$review', NOW())";

    if (mysqli_query($conn, $query)) {
        mysqli_close($conn);  // Close connection upon success
        return true;
    }

    // Capture error information before closing the connection
    $error_message = mysqli_error($conn);
    mysqli_close($conn);
    return "Database error: " . $error_message;
}

// Get current page number
$page_number = $_GET['page'] ?? 1;
$page_number = (int)$page_number;
if ($page_number < 1) {
    $page_number = 1;
}

function create_tables() {
    $query = "
        CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(30) NOT NULL,
        `first_name` varchar(30) NOT NULL,
        `last_name` varchar(30) NOT NULL,
        `email` varchar(100) NOT NULL,
        `password` varchar(255) NOT NULL,
        `role` varchar(6) NOT NULL,
        `date` datetime NOT NULL,
        PRIMARY KEY (`id`),
        KEY `username` (`username`),
        KEY `email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ";
    query($query);

    $query = "
        CREATE TABLE IF NOT EXISTS `soundscapes` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `file` varchar(1024) NOT NULL,
        `image` varchar(1024) NOT NULL,
        `title` varchar(100) NOT NULL,
        `plays` int(11) DEFAULT 0 NOT NULL,
        `ratings` int(11) DEFAULT 0 NOT NULL,
        `review` int(11) DEFAULT 0 NOT NULL,
        `date` datetime NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        KEY `title` (`title`),
        KEY `views` (`views`),
        KEY `popularity` (`popularity`),
        KEY `downloads` (`downloads`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ";
    query($query);
}
?>
