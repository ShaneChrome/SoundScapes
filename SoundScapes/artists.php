<?php

require 'init.php';
$title = 'Artists';

$limit = 30;
$offset = ($page_number - 1) * $limit;

// Fetching users from the database
$query = "SELECT * FROM users WHERE role ='user' ORDER BY id DESC LIMIT $limit OFFSET $offset";
$users = query($query);  

?>

<?php require 'header.php'; ?>

<h1 class="class_16" spellcheck="false" data-listener-added_4502553f="true">
    Artists Profiles
</h1>

<div class="class_17">
    <?php if (!empty($users)): ?>
        <?php foreach ($users as $user): ?>
            <div class="class_18">
                <!-- Here we ensure that the 'id' of the selected user is passed correctly -->
                <a href="profile.php?id=<?= $user['id'] ?>&page=<?= $page_number ?>"> <!-- Link to profile.php with the ID and page number -->
                    <img src="<?= get_image($user['image']) ?>" class="class_19 item_class_4">
                    <h3 class="class_20" spellcheck="false">
                        &nbsp; &nbsp; &nbsp;By <?= $user['first_name'] ?>&nbsp;
                        &nbsp; &nbsp; &nbsp;<?= $user['last_name'] ?>&nbsp;
                    </h3>
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="class_22" style="text-align: center;">
            <h3>No Artist Found.</h3>
        </div>
    <?php endif; ?>

    <div class="class_43">
        <!-- Pagination: handle "Prev Page" and "Next Page" functionality -->
        <a href="artists.php?page=<?= ($page_number - 1) ?>">
            <button class="class_44" spellcheck="false" style="float:left">
                Prev Page
            </button>
        </a>

        <a href="artists.php?page=<?= ($page_number + 1) ?>">
            <button type="button" class="class_45" spellcheck="false">
                Next Page
            </button>
        </a>
        <div class="class_46"></div>
    </div>
</div>

<?php require 'footer.php'; ?>
