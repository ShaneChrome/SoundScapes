<?php

   require 'init.php';
   $title = 'Login';

   if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$email = addslashes($_POST['email']) ;
	$password = addslashes($_POST['password']) ;

    $query = "select * from users where email = '$email'limit 1";
	$row =query($query);


		if(!empty($row)){
			
            $row = $row[0];
			if(password_verify($password, $row['password'])){
                auth($row);
                redirect('profile');}
                else{
                    $errors['email'] = 'Invalid Email or Password'; 
                }
            }
            else{
                $errors['email'] = 'Invalid Email or Password'; 
            }
			
			
		}
	

	
   
?>

	
	<?php require 'header.php'; ?>
    
						<div class="class_81" >
							<div class="class_82" >
								<form method="post" enctype="multipart/form-data" class="class_83" style="height:auto" >
									<h1  class="class_84"  spellcheck="false" data-listener-added_4502553f="true">
										Login
									</h1>
									<span  class="class_25">
									</span>
									<span id="monica-writing-entry-btn-root" class="class_25">
									</span>
									<div class="class_85" >
										<img src="assets/images/img_2.jpg" class="class_71" >
										
									</div>
                                    <div style="color:red; padding: 10px;">
										<?php
										
										if (!empty($message))
										{
                                          echo $message('',true);
										}
										
										?>
                                        <div style="color:red; padding: 10px;">
										<?php
										
										if (!empty($errors))
										{
                                          echo implode ("<br>", $errors);
										}
										
										?>
									
									<div class="class_87" >
										<label  class="class_88"  spellcheck="false" data-listener-added_4502553f="true">
											Email
										</label>
										<input placeholder="" type="text" name="email" class="class_14"  data-listener-added_4502553f="true">
									</div>
									<div class="class_87" >
										<label  class="class_89"  spellcheck="false" data-listener-added_4502553f="true">
											Password
										</label>
										<input placeholder="" type="password" name="password" class="class_14"  data-listener-added_4502553f="true">
									</div>
                                    <div> Dont have Account?<a href= "signup.php">Sign up here</a></div>
									<button  class="class_90"  spellcheck="false" data-listener-added_4502553f="true">
										Login
									</button>
								</form>
							</div>
						</div>
						
        <?php require 'footer.php'; ?>