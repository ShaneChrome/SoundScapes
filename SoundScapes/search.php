<?php

require 'init.php';
$title = "Search";

// Set the limit for pagination
$limit = 30;

// Retrieve search query from URL (GET request)
$find = $_GET['q'] ?? null;

if(!empty($find)) {
    // Remove the wildcards (%%) from the input before displaying it in the search bar
    $searchInput = $find;
    
    $find = '%' . $find . '%';  // Add wildcards for LIKE query
    // Modify the query to search within the soundscapes table
    $query = "SELECT * FROM soundscapes WHERE title LIKE '$find' ORDER BY id DESC LIMIT $limit";
    $soundscapes = query($query);
}

if(!empty($soundscapes)) {
    foreach($soundscapes as $key => $row) {
        $id = $row['user_id']; // Fetch the user_id from soundscapes
        $query = "SELECT * FROM users WHERE id = '$id' LIMIT 1"; // Get the artist info
        $artist = query($query);
        
        // If artist exists, add their information to the soundscape
        if(!empty($artist)) {
            $soundscapes[$key]['artist'] = $artist[0];
        }
    }
}

?>

<?php require 'header.php'; ?>

<!-- Main content wrapper for search results -->
<div class="search-results-container">
    <h1 class="search-title">Search Results</h1>

    <!-- Search Form -->
    <div class="search-form">
        <form action="" method="GET">
            <input type="text" name="q" placeholder="Search SoundScapes..." value="<?= esc($searchInput) ?>" class="search-input">
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>

    <div class="search-results">
        <?php if(!empty($soundscapes)): ?>
            <!-- Grid layout for soundscapes -->
            <div class="row">
                <?php foreach($soundscapes as $soundscape): ?>
                    <div class="col-md-4">
                        <a href="soundscapes.php?id=<?= $soundscape['id'] ?>" class="search-result-item">
                            <img src="<?= get_image($soundscape['image']) ?>" class="soundscape-image">
                            <div class="soundscape-details">
                                <h3 class="soundscape-title"><?= esc($soundscape['title']) ?></h3>
                                <div class="artist-info">
                                    <i class="bi bi-person-fill"></i>
                                    <span class="artist-name"><?= $soundscape['artist']['first_name'] ?? 'Unknown' ?> <?= $soundscape['artist']['last_name'] ?? '' ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <h3>No soundscapes found</h3>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require 'footer.php'; ?>

<!-- CSS Styling -->
<style>
    /* Container for the search results page */
    .search-results-container {
        margin: 20px auto;
        max-width: 1200px;
        padding: 10px;
        background-color: #000; /* Black background */
    }

    /* Search results heading */
    .search-title {
        text-align: center;
        font-size: 2.5em;
        margin-bottom: 20px;
        color: #800080; /* Purple font color */
    }

    /* Search form styling */
    .search-form {
        text-align: center;
        margin-bottom: 30px;
    }

    .search-input {
        padding: 10px;
        width: 60%;
        font-size: 1em;
        border-radius: 5px;
        border: 1px solid #ddd;
        background-color: #333; /* Dark background for input */
        color: #D8B6D4; /* Lighter purple font color for input text */
    }

    .search-button {
        padding: 10px 20px;
        font-size: 1em;
        margin-left: 10px;
        border: none;
        background-color: #800080; /* Purple button */
        color: white;
        cursor: pointer;
        border-radius: 5px;
    }

    .search-button:hover {
        background-color: #6a006a; /* Darker purple on hover */
    }

    /* Grid layout for soundscape items */
    .search-results .row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .search-results .col-md-4 {
        flex: 1 1 30%;
        max-width: 30%;
    }

    /* Individual soundscape result item */
    .search-result-item {
        display: block;
        text-decoration: none;
        color: #fff; /* White text for results */
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        background-color: #222; /* Dark background for items */
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .search-result-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Soundscape image styling */
    .soundscape-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    /* Details section for soundscape item */
    .soundscape-details {
        padding: 10px;
    }

    .soundscape-title {
        font-size: 1.2em;
        font-weight: bold;
        margin-bottom: 10px;
        color: #800080; /* Purple font for titles */
    }

    .artist-info {
        font-size: 0.9em;
        color: #ccc; /* Light gray text for artist info */
    }

    .artist-info i {
        margin-right: 5px;
    }

    /* No results message */
    .no-results {
        text-align: center;
        font-size: 1.5em;
        padding: 20px;
        background-color: #333; /* Dark background for no results */
        border: 1px solid #ddd;
        border-radius: 5px;
        color: #fff;
    }
</style>
