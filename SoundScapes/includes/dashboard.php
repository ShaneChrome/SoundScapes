<?php 

	defined("ADMIN") or die("Access denied");

	$query = "select count(*) as total from users where role = 'admin' ";
	$admins = query($query);
	$total_admins = $admins[0]['total'];

	$query = "select count(*) as total from users where role = 'user' ";
	$users = query($query);
	$total_users = $users[0]['total'];

	$query = "select count(*) as total from soundscapes";
	$soundscapes = query($query);
	$total_soundscapes = $soundscapes[0]['total'];

	$query = "select sum(plays) as total from soundscapes";
	$plays = query($query);
	$total_views = $plays[0]['total'];

?>

<div class="class_17" >
    <div class="class_18" >
        <i  class="bi bi-person-fill-gear class_19">
        </i>
        <h1 class="class_20"   spellcheck="false">
        <?=$total_admins?>
            <br >
        </h1>
        <h1 class="class_21"   spellcheck="false">
            Admins
        </h1>
    </div>
    <div class="class_18" >
        <i  class="bi bi-people class_19">
        </i>
        <h1 class="class_20"   spellcheck="false">
        <?=$total_users?>
        </h1>
        <h1 class="class_21"   spellcheck="false">
            Users
            <br >
        </h1>
    </div>
    <div class="class_18" >
        <i  class="bi bi-music-note-beamed class_19">
        </i>
        <h1 class="class_20"   spellcheck="false">
        <?=$total_soundscapes?>
        </h1>
        <h1 class="class_21"   spellcheck="false">
            Soundscapes
        </h1>
    </div>
    <div class="class_18" >
        <i  class="bi bi-stickies-fill class_19">
        </i>
        <h1 class="class_20"   spellcheck="false">
        <?=$total_views?>
        </h1>
        <h1 class="class_21"   spellcheck="false" data-listener-added_996b756a="true">
            Plays
        </h1>
    </div>
</div>

