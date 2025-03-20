<?php
require 'init.php';
$title = 'Profile';


if(!is_logged_in())
{
    redirect('login');
}

// Check if the 'id' is passed in the URL and is a valid numeric value
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // If 'id' is passed, use it to fetch the profile of that user
    $profile_user_id = $_GET['id'];

    // Fetch user profile data based on the ID from the URL
    $query = "SELECT * FROM users WHERE id = '$profile_user_id' LIMIT 1";
    $user_profile = query($query);

    if (!empty($user_profile)) {
        $user_profile = $user_profile[0]; // Only fetch the first result, as we're using LIMIT 1
        $profile_user_id = $user_profile['id'];

        // Fetch soundscapes uploaded by the user
        $query = "SELECT * FROM soundscapes WHERE user_id = '$profile_user_id' LIMIT 10";
        $soundscapes = query($query);

        // Get total number of soundscapes uploaded
        $query = "SELECT COUNT(*) AS total FROM soundscapes WHERE user_id = '$profile_user_id'";
        $total_soundscapes = query($query);
        $total_soundscapes = $total_soundscapes[0]['total'];
    } else {
        // Handle error if the user does not exist
        echo "User profile not found.";
        exit;
    }
} else {
    // If no valid ID is passed, redirect to the artists page (view logged-in user's profile)
    $profile_user_id = user('id'); // Fetch the logged-in user's ID
    $query = "SELECT * FROM users WHERE id = '$profile_user_id' LIMIT 1";
    $user_profile = query($query);

    if (!empty($user_profile)) {
        $user_profile = $user_profile[0];
        // Fetch soundscapes for the logged-in user
        $query = "SELECT * FROM soundscapes WHERE user_id = '$profile_user_id' LIMIT 10";
        $soundscapes = query($query);

        // Get total number of soundscapes uploaded
        $query = "SELECT COUNT(*) AS total FROM soundscapes WHERE user_id = '$profile_user_id'";
        $total_soundscapes = query($query);
        $total_soundscapes = $total_soundscapes[0]['total'];
    } else {
        echo "User profile not found.";
        exit;
    }
}

require 'header.php';
?>

<div class="class_47">
    <h1 class="class_48" spellcheck="false">
        User Profile
    </h1>
</div>

<div class="class_49">
    <?php if (!empty($user_profile)): ?>
    <div class="class_50">
        <div class="class_51">
            <!-- Display user profile image and basic info -->
            <img src="<?= get_image($user_profile['image']) ?>" class="class_52">
            <h1 class="class_53" spellcheck="false">
                <?= $user_profile['first_name'] ?> <?= $user_profile['last_name'] ?>
            </h1>
            <div><?= $user_profile['username'] ?></div>
            <div class="class_54">
                <div class="class_55">
                    <i class="bi bi-people class_56"></i>
                    <h2 class="class_57" spellcheck="false">
                        <?= $total_soundscapes ?> Uploads
                    </h2>
                </div>
                <div class="class_55">
                    <i class="bi bi-play-circle class_56"></i>
                    <h2 class="class_57" spellcheck="false">
                        <?php
                            // Get plays for the user (this can be fetched by soundscape or in bulk)
                            $plays = array_sum(array_column($soundscapes, 'plays'));
                            echo $plays; 
                        ?> Plays
                    </h2>
                </div>
                <div class="class_55">
                    <i class="bi bi-binoculars class_56"></i>
                    <h2 class="class_57" spellcheck="false">
                        <?php
                            // Count total reviews for all soundscapes
                            $total_reviews = 0;
                            foreach ($soundscapes as $soundscape) {
                                $reviews = get_reviews($soundscape['id']);
                                $total_reviews += is_array($reviews) ? count($reviews) : 0;
                            }
                            echo $total_reviews;
                        ?> Reviews
                    </h2>
                </div>
                <div class="class_55">
                    <i class="bi bi-sort-numeric-up-alt class_56"></i>
                    <h2 class="class_58" spellcheck="false">
                        <?php
                            // Calculate total ratings (average of all soundscapes)
                            $total_ratings = 0;
                            foreach ($soundscapes as $soundscape) {
                                $total_ratings += get_average_rating($soundscape);
                            }
                            $avg_rating = count($soundscapes) > 0 ? number_format($total_ratings / count($soundscapes), 1) : 0;
                            echo $avg_rating;
                        ?> Ratings
                    </h2>
                </div>
            </div>
            <?php if (user('id') == $user_profile['id']): ?>
                <!-- If the logged-in user is viewing their own profile, allow editing -->
                <a href="settings.php">
                    <button class="class_66" spellcheck="false">Edit Profile</button>
                </a>
            <?php endif; ?>
        </div>
        <div class="class_59">
            <?php if (!empty($soundscapes)): ?>
                <?php foreach ($soundscapes as $soundscape): ?>
                    <div class="class_60">
                        <div class="class_61">
                            <img src="<?= get_image($soundscape['image']) ?>" class="class_62">
                        </div>
                        <div class="class_63">
                            <h3 class="class_64" spellcheck="false">
                                <?= esc($soundscape['title']) ?>
                            </h3>
                            <div class="class_37">
                                <audio controls="" class="class_38">
                                    <source src="<?= $soundscape['file'] ?>" type="audio/mpeg">
                                </audio>
                            </div>
                        </div>
                        <div class="class_65">
                           

                            <?php if (user('id') == $user_profile['id']): ?>
                                <a href="upload.php?mode=edit&id=<?= $soundscape['id'] ?>">
                                    <button class="class_66" spellcheck="false">Edit</button>
                                </a>
                                <a href="upload.php?mode=delete&id=<?= $soundscape['id'] ?>">
                                    <button class="class_67" spellcheck="false">Delete</button>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="padding: 20px; text-align: center;">
                    <h2>No Soundscapes Found<br><a href="upload.php">Upload a SoundScape</a></h2>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>

<!-- CSS for the Profile -->
<style>
.profile-page {
    width: 100%;
    margin: 0 auto;
    padding: 20px;
}

.soundscape-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.soundscape-item {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.soundscape-title {
    font-size: 1.5em;
    margin-bottom: 10px;
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
}

.soundscape-item p {
    font-size: 1em;
    color: #333;
    margin: 5px 0;
}

.audio-controls {
    width: 100%;
    margin: 10px 0;
}

@media (max-width: 768px) {
    .soundscape-item {
        font-size: 0.9em;
    }
}
</style>
