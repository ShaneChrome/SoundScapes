<?php 

	defined("ADMIN") or die("Access denied");

	$limit = 30;
    $offset=($page_number-1)*$limit;

	$query = "select *  from users order by id desc limit $limit offset $offset";
    $users = query($query);

?>

<table class="item_class_0"   spellcheck="false">
    
    <thead >
        
        <tr >
            
            <th scope="col" >
                #
            </th>
            
            <th scope="col" >
                Username
            </th>
            
            <th scope="col" >
                First Name            
		    </th>
            
            <th scope="col" >
                Role
            </th>
            
            <th scope="col" >
                Email
            </th>
            
            <th  class="class_22">
                Image
            </th>
            <th >
                Action
            </th>
        </tr>
        
    </thead>
    
    <tbody >
		<?php if(!empty($users)): ?> 
        <?php foreach($users as $user): ?>
        <tr >
            
            <th >
                1
            </th>
            
            <td >
                Mary
            </td>
            
            <td >
                Jane
            </td>
            
            <td >
                21
            </td>
            
            <td >
                mary@email.com
            </td>
            
            <td >
                <img src="assets_admin/images/pexels-photo-1066137.jpeg" class="class_23" >
            </td>
            <td >
                <button class="class_24"  >
                    Edit
                </button>
                <button class="class_25"  >
                    Delete
                </button>
            </td>
        </tr>
        <?php endforeach?>
		
        <?php endif; ?>
        
    </tbody>
</table>
<div class="class_26" >
    <div class="class_27" >
    </div>
    <button class="class_28"   spellcheck="false">
        Prev_Page
    </button>
    <button class="class_29"   spellcheck="false">
        Next_Page
    </button>
</div>
	