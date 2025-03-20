<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$title?> |<?=APP_NAME?></title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="assets/css/styles.css?8843">
</head>
<body>

<header class="class_1" >
		<div class="class_2" >
			<img src="assets/images/pexels-photo-1649771.jpeg" class="class_3" >
		</div>
		<div  class="item_class_0 class_4">
			<div  class="item_class_1 class_5">
				<svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
					<path d="m22 16.75c0-.414-.336-.75-.75-.75h-18.5c-.414 0-.75.336-.75.75s.336.75.75.75h18.5c.414 0 .75-.336.75-.75zm0-5c0-.414-.336-.75-.75-.75h-18.5c-.414 0-.75.336-.75.75s.336.75.75.75h18.5c.414 0 .75-.336.75-.75zm0-5c0-.414-.336-.75-.75-.75h-18.5c-.414 0-.75.336-.75.75s.336.75.75.75h18.5c.414 0 .75-.336.75-.75z" fill-rule="nonzero" >
					</path>
				</svg>
			</div>
			<div  class="item_class_2 class_6">
				<a href="index.php"  class="class_7"  spellcheck="false" data-listener-added_4502553f="true">
					Home
				</a>
				
				<?php if (is_logged_in()):?>

				<a href="profile.php?id=<?= user('id') ?>" spellcheck="false" data-listener-added_4502553f="true" backup="display:flex;display:block;min-width:100px;text-align:center;text-decoration:none;background-color:#eee;padding: 10px;border-right: solid thin #aaa;cursor: pointer;" class="class_7 item_class_3">
                       Profile
                </a>
                <a href="upload.php"  class="class_8"  spellcheck="false" data-listener-added_4502553f="true">
	            Upload&nbsp;
                </a>
                 <?php endif;?>
				<a href="latest.php"  spellcheck="false" data-listener-added_4502553f="true" backup="display:flex;display:block;min-width:100px;text-align:center;text-decoration:none;background-color:#eee;padding: 10px;border-right: solid thin #aaa;cursor: pointer;" class="class_9 item_class_3">
					Latest
				</a>
				<a href="popular.php"  spellcheck="false" data-listener-added_4502553f="true" backup="display:flex;display:block;min-width:100px;text-align:center;text-decoration:none;background-color:#eee;padding: 10px;border-right: solid thin #aaa;cursor: pointer;" class="class_7 item_class_3">
					Popular
				</a>
				<a href="top-10.php"  spellcheck="false" data-listener-added_4502553f="true" backup="display:flex;display:block;min-width:100px;text-align:center;text-decoration:none;background-color:#eee;padding: 10px;border-right: solid thin #aaa;cursor: pointer;" class="class_7 item_class_3">
					Top 10
				</a>
				<a href="artists.php"  spellcheck="false" data-listener-added_4502553f="true" backup="display:flex;display:block;min-width:100px;text-align:center;text-decoration:none;background-color:#eee;padding: 10px;border-right: solid thin #aaa;cursor: pointer;" class="class_7 item_class_3">
					Artists
				</a>
				<a href="contact-us.php"  class="class_8"  spellcheck="false" data-listener-added_4502553f="true">
					Contact us
				</a>
				<a href="about-us.php"  class="class_8"  spellcheck="false" data-listener-added_4502553f="true">
					About us
				</a>
				<?php if(is_logged_in()):?>
				<a href="admin.php"  class="class_8"  spellcheck="false" data-listener-added_4502553f="true">
					Admin
				</a>
                <?php endif;?>
                
			

			</div>
			
		</div>
		
		<div  class="class_10"  spellcheck="false" data-listener-added_4502553f="true">
			<?php if(is_logged_in()):?>
			<img src="<?=get_image(user('image'))?>" class="class_11" >
		<div>Hi, <?=user('username')?><br><a href="logout.php">	[Logout]</a></div>
			
			<?php else:?>
			<a href="login.php"  >	Login</a>
				
			<?php endif;?>
		</div>
	</header>
	<form method ="get" action ="search.php"class="class_12" >
		<label  class="class_13"  spellcheck="false" data-listener-added_4502553f="true">
			Search:
		</label>
		<input value = "<?=$_GET['q'] ?? ''?>" placeholder="" type="text" name="q" class="class_14" >
	</form>