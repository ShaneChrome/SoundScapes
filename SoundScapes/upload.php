<?php

require 'init.php';
$title = 'Upload';

// Redirect if not logged in
if(!is_logged_in())
{
    redirect('login');
}

$mode = $_GET['mode'] ?? 'new';
$id = $_GET['id'] ?? 0;
$id = (int)$id;

$button_title = "Save";

if ($mode == 'edit' || $mode == 'delete') {
    if ($mode == 'delete') {
        $button_title = "Delete";
    }

    $query = "SELECT * FROM soundscapes WHERE id = '$id' LIMIT 1";
    $soundscape = query($query);
    if (!empty($soundscape)) {
        $soundscape = $soundscape[0];
        
        // Verify user owns this soundscape or is admin
        if ($soundscape['user_id'] != user('id') && !is_admin()) {
            message("You don't have permission to modify this soundscape");
            redirect('profile');
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    $title = addslashes($_POST['title']);

    // Validate title
    if (empty($title)) {
        $errors['title'] = 'Title Required';
    } else if (!preg_match("/^[a-zA-Z 0-9 \-\_\(\)\[\]\$\#\@\*\%\+]+$/", trim($title))) {
        $errors['title'] = 'Invalid Title';
    }

    // Ensure upload directory exists
    $folder = 'uploads/';
    if (!file_exists($folder)) {
        mkdir($folder, 0755, true);
    }

    // Image handling with improved security
    $image = $soundscape['image'] ?? '';
    if (!empty($_FILES['image']['name'])) {
        // Check file type using more secure method
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_info = getimagesize($image_tmp);
        $allowed = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp');
        
        if ($image_info && in_array($image_info['mime'], $allowed)) {
            // Generate unique filename to prevent overwriting
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image = $folder . uniqid('img_') . '.' . $ext;
            
            // Check file size
            if ($_FILES['image']['size'] > 5000000) { // 5MB limit
                $errors['image'] = 'Image file too large (max 5MB)';
            }
        } else {
            $errors['image'] = 'Invalid Image';
        }
    } else {
        if ($mode == 'new') {
            $errors['image'] = 'Image Required';
        }
    }

    // Audio file handling with improved security
    $file = $soundscape['file'] ?? '';
    if (!empty($_FILES['file']['name'])) {
        $file_tmp = $_FILES['file']['tmp_name'];
        $mime_type = mime_content_type($file_tmp);
        $allowed = array('audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg');
        
        if (in_array($mime_type, $allowed)) {
            // Generate unique filename
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $file = $folder . uniqid('audio_') . '.' . $ext;
            
            // Check file size
            if ($_FILES['file']['size'] > 20000000) { // 20MB limit
                $errors['file'] = 'Audio file too large (max 20MB)';
            }
        } else {
            $errors['file'] = 'Invalid Audio file';
        }
    } else {
        if ($mode == 'new') {
            $errors['file'] = 'Audio file Required';
        }
    }

    if (empty($errors)) {
        // Handle delete mode
        if ($mode == 'delete') {
            $delete_query = "DELETE FROM soundscapes WHERE id = '$id' AND user_id = '" . user('id') . "' LIMIT 1";
            query($delete_query);
            
            // Delete files
            if (!empty($soundscape['image']) && file_exists($soundscape['image'])) {
                unlink($soundscape['image']);
            }
            if (!empty($soundscape['file']) && file_exists($soundscape['file'])) {
                unlink($soundscape['file']);
            }
            
            message("Your soundscape was successfully deleted!");
            redirect('profile');
            exit;
        }
    
        // Save
        $date = date('Y-m-d H:i:s');
        $user_id = user('id');

        // Upload new image if provided
        if (!empty($_FILES['image']['name'])) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
                // Delete old image on edit
                if ($mode == 'edit' && !empty($soundscape['image']) && file_exists($soundscape['image']) && $soundscape['image'] != $image) {
                    unlink($soundscape['image']);
                }
            } else {
                $errors['image'] = 'Failed to upload image';
            }
        }

        // Upload new audio file if provided
        if (!empty($_FILES['file']['name'])) {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
                // Delete old file on edit
                if ($mode == 'edit' && !empty($soundscape['file']) && file_exists($soundscape['file']) && $soundscape['file'] != $file) {
                    unlink($soundscape['file']);
                }
            } else {
                $errors['file'] = 'Failed to upload audio file';
            }
        }

        // If no errors during file upload
        if (empty($errors)) {
            // Insert or update database
            if ($mode == 'new') {
                $query = "INSERT INTO soundscapes (user_id, file, image, title, date) VALUES ('$user_id', '$file', '$image', '$title', '$date')";
                message("Your soundscape was successfully created!");
            } else if ($mode == 'edit') {
                $query = "UPDATE soundscapes SET title = '$title'";
                
                // Only include image/file in query if they were uploaded
                if (!empty($_FILES['image']['name'])) {
                    $query .= ", image = '$image'";
                }
                if (!empty($_FILES['file']['name'])) {
                    $query .= ", file = '$file'";
                }
                
                $query .= " WHERE id = '$id' AND user_id = '$user_id' LIMIT 1";
                message("Your soundscape was successfully edited!");
            }

            query($query);
            redirect('profile');
        }
    }
}

?>

<?php require 'header.php'; ?>

<div class="class_27">
    <form method="post" enctype="multipart/form-data" class="class_28 item_class_8">
        <h1 class="class_29" spellcheck="false">
            <?php echo $mode == 'edit' ? 'Edit' : ($mode == 'delete' ? 'Delete' : 'Upload'); ?> SoundScape
        </h1>
        <div style="color: red; padding: 10px;">
            <?php
            if (!empty($errors)) {
                echo implode("<br>", $errors);
            }
            ?>
        </div>
        <div class="class_30">
            <label class="class_31" spellcheck="false">
                Title:
            </label>
            <input value="<?= old_value('title', $soundscape['title'] ?? '') ?>" placeholder="" type="text" name="title" class="class_32" <?= $mode == 'delete' ? 'readonly' : '' ?>>
        </div>
        <div class="class_33">
            <img src="<?= get_image($soundscape['image'] ?? '') ?>" class="class_34 js-image">
            <input onchange="display_image(this.files[0])" type="file" name="image" class="class_35" <?= $mode == 'delete' ? 'disabled' : '' ?>>
            <?php if ($mode != 'delete'): ?>
                <small style="color: #666; margin-top: 5px; display: block;">Supported formats: JPG, PNG, GIF, WEBP (Max 5MB)</small>
            <?php endif; ?>
        </div>
        <div class="class_36">
            <div class="class_37">
                <audio controls="" class="class_38 js-file">
                    <source src="<?= $soundscape['file'] ?? '' ?>" type="audio/mpeg">
                </audio>
            </div>
            <input onchange="load_file(this.files[0])" type="file" name="file" class="class_39" <?= $mode == 'delete' ? 'disabled' : '' ?>>
            <?php if ($mode != 'delete'): ?>
                <small style="color: #666; margin-top: 5px; display: block;">Supported formats: MP3, WAV, OGG (Max 20MB)</small>
            <?php endif; ?>
        </div>
        <div class="class_43">
            <button class="class_44" spellcheck="false">
                <?= $button_title ?>
            </button>
            <a href="profile.php">
                <button type="button" class="class_45" spellcheck="false">
                    Cancel
                </button>
            </a>
            <div class="class_46"></div>
        </div>
    </form>
</div>

<?php require 'footer.php'; ?>

<script>
    function display_image(file) {
        if (file) {
            document.querySelector(".js-image").src = URL.createObjectURL(file);
        }
    }

    function load_file(file) {
        if (file) {
            const audio = document.querySelector(".js-file");
            const source = document.createElement('source');
            source.src = URL.createObjectURL(file);
            source.type = file.type;
            
            // Remove existing sources
            while (audio.firstChild) {
                audio.removeChild(audio.firstChild);
            }
            
            audio.appendChild(source);
            audio.load();
        }
    }
</script>