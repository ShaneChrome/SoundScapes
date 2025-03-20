<?php

   require 'init.php';
   $title = 'Popular';
   $limit = 30;
   $offset=($page_number-1)*$limit;
  // Fetching soundscapes from the database
    $query = "SELECT * FROM soundscapes ORDER BY popularity DESC LIMIT $limit OFFSET $offset";
    $soundscapes = query($query);  

   if (!empty($soundscapes)) {
    foreach ($soundscapes as $key => $row) {
        $id = $row['user_id'];
        $query = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
        $artist = query($query);
        if (!empty($artist)) {
            $soundscapes[$key]['artist'] = $artist[0];
        }
    }
}
?>
	
	<?php require 'header.php'; ?>

	 
		<h1  class="class_16"  spellcheck="false" data-listener-added_4502553f="true">
			Popular Soundscapes
		</h1>
	
	
	
		<div class="class_17">
    <?php if (!empty($soundscapes)):$num=0 ?>
        <?php foreach ($soundscapes as $soundscape):$num++?>
            <div class="class_18">
                <a href="soundscapes.php?id=<?= $soundscape['id'] ?>"> <!-- Link to soundscapes.php with ID -->
                    <div style ="background-color: #ccc; padding:2px; font-size:20px;"><?=$num?></div>
					<img src="<?= get_image($soundscape['image']) ?>" class="class_19 item_class_4">
					
                    <h3 class="class_20" spellcheck="false">
                        <?= esc($soundscape['title']) ?>
                    </h3>
                </a>
                <div class="class_21">
                    <i class="bi bi-person-check class_22"></i>
                    <div class="class_23" spellcheck="false">
                        &nbsp; &nbsp; &nbsp;By <?= $soundscape['artist']['first_name'] ?? 'Unknown' ?>&nbsp;
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="class_22" style="text-align: center;">
            <h3>No soundscapes available at the moment.</h3>
        </div>
    <?php endif; ?>

	<div class="class_43" >
	   <a href="popular.php?page=<?=($page_number-1)?>">
            <button class="class_44" spellcheck="false" style="float:left">
            Prev Page
            </button>
	    </a>

        <a href="popular.php?page=<?=($page_number+1)?>">
            <button type="button" class="class_45" spellcheck="false">
                Next Page
            </button>
        </a>
            <div class="class_46"></div>
        </div>
</div>
		<?php require 'footer.php'; ?>