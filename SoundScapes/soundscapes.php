<?php
require 'init.php';
$title = "SoundScape";

// Retrieve Soundscape ID
$soundscape_id = $_GET['id'] ?? 0; 
$soundscape_id = (int)$soundscape_id;

$query = "SELECT * FROM soundscapes WHERE id = '$soundscape_id' LIMIT 1"; 
$soundscape = query($query);

if (!empty($soundscape)) {
    $soundscape = $soundscape[0];
    $user_id = $soundscape['user_id']; 

    // Fetch the uploader details
    $query = "SELECT * FROM users WHERE id = '$user_id' LIMIT 1";
    $row = query($query);
    if (!empty($row)) {
        $row = $row[0];
    }
}

// Track page views (if user is not the uploader)
if (user('id') != $soundscape['user_id']) {
    add_page_view($soundscape['id']); 
}

// Get user rating (if exists)
$user_rating = user_has_rated(user('id'), $soundscape['id']) ? get_user_rating(user('id'), $soundscape['id']) : 0;

// Handle rating submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating']) && !isset($_POST['review'])) {
    $rating = (int)$_POST['rating'];
    if ($rating >= 1 && $rating <= 5) {
        if (!$user_rating) { // Only allow rating if not rated before
            add_rating($soundscape['id'], $rating);
        }
        header("Location: soundscapes.php?id=" . $soundscape['id']);
        exit;
    }
}

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review'])) {
    $review = trim($_POST['review']);
    if (strlen($review) >= 10) {
        $result = add_review($soundscape['id'], user('id'), $review);
        if ($result === true) {
            header("Location: soundscapes.php?id=" . $soundscape['id']);
            exit;
        } else {
            echo "<script>alert('$result');</script>";
        }
    } else {
        echo "<script>alert('Review must be at least 10 characters long.');</script>";
    }
}

// Fetch reviews
$reviews = get_reviews($soundscape['id']);

require 'header.php';
?>

<style>
    body {
        background-color: #121212;
        color: #e0e0e0;
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 800px;
        margin: auto;
        padding: 20px;
    }

    .profile-section {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }

    .audio-section {
        background: #2c2c2c;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 20px;
    }

    .stars {
        font-size: 30px;
        cursor: pointer;
    }

    .star {
        color: lightgray;
    }

    .star.filled {
        color: gold;
    }

    .review-container {
        background: #2c2c2c;
        padding: 15px;
        border-radius: 10px;
        margin-top: 20px;
    }

    .review-item {
        padding: 10px;
        background: #333;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .review-form {
        background: #2c2c2c;
        padding: 15px;
        border-radius: 10px;
        margin-top: 20px;
    }

    .review-input {
        width: 100%;
        height: 80px;
        padding: 10px;
        border-radius: 5px;
        background: #333;
        color: #e0e0e0;
        border: none;
    }

    .submit-button {
        width: 100%;
        padding: 10px;
        background: #9c27b0;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }
</style>

<div class="container">
    <div class="profile-section">
        <img src="<?= get_image($row['image']) ?>" class="profile-image">
        <h2><?= esc($row['first_name']) ?> <?= esc($row['last_name']) ?></h2>
        <p>@<?= esc($row['username']) ?></p>
    </div>

    <div class="audio-section">
        <h3><?= esc($soundscape['title']) ?></h3>
        <audio controls>
            <source src="<?= esc($soundscape['file']) ?>" type="audio/mpeg">
        </audio>
    </div>

    <p>Page Views: <?= esc($soundscape['plays']) ?></p>
    <p>Average Rating: <?= number_format(get_average_rating($soundscape), 1) ?> ⭐</p>
    <p>Your Rating: <?= $user_rating ? "$user_rating ⭐" : "Not rated yet" ?></p>

    <!-- Rating Section -->
    <form method="POST">
        <input type="hidden" name="rating" id="rating" value="0">
        <div class="stars">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <span class="star <?= ($i <= $user_rating) ? 'filled' : '' ?>" data-value="<?= $i ?>">★</span>
            <?php endfor; ?>
        </div>
        <button type="submit" class="submit-button" <?= $user_rating ? 'disabled' : '' ?>>Submit Rating</button>
    </form>

    <!-- Reviews Section -->
    <div class="review-container">
        <h3>Reviews</h3>
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review-item">
                    <p><strong><?= esc($review['first_name']) ?> <?= esc($review['last_name']) ?> (@<?= esc($review['username']) ?>)</strong></p>
                    <p><?= esc(htmlspecialchars($review['review'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet.</p>
        <?php endif; ?>
    </div>

    <!-- Review Form -->
    <div class="review-form">
        <form method="POST">
            <textarea name="review" class="review-input" placeholder="Write your review..."></textarea>
            <button type="submit" class="submit-button">Submit Review</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star');
        let selectedRating = <?= $user_rating ?>;

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                if (selectedRating === 0) { // Allow selecting only if not rated before
                    selectedRating = index + 1;
                    document.getElementById('rating').value = selectedRating;

                    stars.forEach((s, i) => {
                        s.classList.toggle('filled', i < selectedRating);
                    });
                }
            });
        });
    });
</script>

<?php require 'footer.php'; ?>
