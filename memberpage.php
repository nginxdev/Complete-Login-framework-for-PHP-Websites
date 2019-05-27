<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'Members Page';

//include header template
require('layout/navbar.php'); 
?>

<div class="container" >
	<div class="row">
	    hi bro
	</div>
</div>
<?php 
//include header template
require('layout/footer.php'); 
?>
