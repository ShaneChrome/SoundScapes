<?php

	require 'init.php';
	$title = "Admin";

	

	if(!is_admin())
	{
		redirect('login');
	}

	$section = $_GET['section'] ?? "dashboard";
	$page_to_load = 'includes/'.strtolower($section).'.php';

	define("ADMIN", true);
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin</title>
	<link rel="stylesheet" type="text/css" href="assets_admin/css/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="assets_admin/css/styles.css?3266">
</head>
<body>

	
	<div class="class_1" >
		<div class="class_2" >
			<div class="class_3" >
			<img src="<?=get_image(user('image'))?>" class="class_4" >
				<h1 class="class_5"   spellcheck="false" data-listener-added_996b756a="true">
					<?=user('first_name')?> <?=user('last_name')?>
				</h1>
				<span id="monica-writing-entry-btn-root" class="class_6">
				</span>
			</div>
			<a href="admin.php" class="class_7"   spellcheck="false" data-listener-added_996b756a="true">
				<div class="class_8" >
					<div class="class_9" >
					Dashboard
					</div>
					<div class="class_10" >
						<i  class="bi bi-list class_11">
						</i>
					</div>
				</div>
			</a>
			<a href="admin.php?section=users" class="class_7"   spellcheck="false">
				<div class="class_8" >
					<div class="class_12" >
						Users
					</div>
					<div class="class_10" >
						<i  class="bi bi-people class_11">
						</i>
					</div>
				</div>
			</a>
			<a href="admin.php?section=soundscapes" class="class_7"   spellcheck="false" data-listener-added_996b756a="true">
				<div class="class_8" >
					<div class="class_13" >
						Soundscapes
					</div>
					<div class="class_10" >
						<i  class="bi bi-music-note-beamed class_11">
						</i>
					</div>
				</div>
			</a>

			<a href="index.php" class="class_7"   spellcheck="false" data-listener-added_996b756a="true">
				<div class="class_8" >
					<div class="class_14" >
						Frontend
					</div>
					<div class="class_10" >
						<i  class="bi bi-music-note-beamed class_11">
						</i>
					</div>
				</div>
			</a>
			
			
			<a href="logout.php" class="class_7"   spellcheck="false" data-listener-added_996b756a="true">
				<div class="class_8" >
					<div class="class_12" >
						Logout
					</div>
					<div class="class_10" >
						<i  class="bi bi-box-arrow-right class_11">
						</i>
					</div>
				</div>
			</a>
		</div>
		<div class="class_15"  fill="#C3C3C3FF">
			<h2 class="class_16"   spellcheck="false">
			<?=ucwords($section)?>

			</h2>
			
			<!-- begin page content-->
			<?php
				if(file_exists($page_to_load))
				{
					require $page_to_load;
				}else{
					echo "Page not found";
				}

			?>
			<!-- end page content-->


			

			</div>	
	</div>
	
</body>
</html>