<?php require('includes/config.php');

//if logged in redirect to members page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); }

//if form has been submitted process it
if(isset($_POST['submit'])){

	//very basic validation
	if(strlen($_POST['fullname']) < 3){
		$error[] = 'Full name is too short';
	}
	
	if(strlen($_POST['phone']) < 10){
		$error[] = 'Phone Number is too short';
	}
	
	if(strlen($_POST['username']) < 5){
		$error[] = 'Username is too short.';
	} else {
		$stmt = $db->prepare('SELECT username FROM members WHERE username = :username');
		$stmt->execute(array(':username' => $_POST['username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}

	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	//email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}

	}


	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//create the activasion code
		$activasion = md5(uniqid(rand(),true));

		try {

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO members (fullname,phone,username,password,email,active) VALUES ( :fullname, :phone, :username, :password, :email, :active)');
			$stmt->execute(array(
			    
				':fullname' => $_POST['fullname'],
				':phone' => $_POST['phone'],
				':username' => $_POST['username'],
				':password' => $hashedpassword,
				':email' => $_POST['email'],
				':active' => $activasion
			));
			$id = $db->lastInsertId('memberID');

			//send email
			$to = $_POST['email'];
			$subject = "Registration Confirmation";
			$body = "<p>Thank you for registering at ZingerPie </p>
			<p>To activate your account, please click on this link:
			<a href='".DIR."activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p>
			<p>Regards Team ZingerPie</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to index page
			header('Location: index.php?action=joined');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Register';

//include header template
require('layout/header.php');
?>


<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="" autocomplete="off">
				<h2>Please Sign Up</h2>
				<p>Already a member? <a href='login.php'>Login</a></p>
				<hr>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<h2 class='bg-success'>Registration successful, please check your email to activate your account.</h2>";
				}
				?>
                
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input type="text" name="fullname" id="fullname" class="form-control input-lg" placeholder="Your Name" value="<?php if(isset($error)){ echo $_POST['fullname']; } ?>" tabindex="1"
					pattern="[A-Za-z\s]{1,}[ ]{0,1}[A-Za-z\s]{0,}" oninvalid="setCustomValidity('Only alphabet and spaces are Expected')"  onchange="try{setCustomValidity('')}catch(e){}" >
				</div>
				<!--
				<div class="form-group input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-cutlery"></i></span>
					<input type="text" name="restaurant" id="restaurant" class="form-control input-lg" placeholder="Restaurant Name" value="<?php if(isset($error)){ echo $_POST['restaurant']; } ?>" tabindex="1"
					pattern="[A-Za-z\s]{3,}" oninvalid="setCustomValidity('Only alphabet and spaces are Expected')"  onchange="try{setCustomValidity('')}catch(e){}" >
				</div>
				
				<div class="form-group input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
					<input type="text" name="address" id="address" class="form-control input-lg" placeholder="Restaurant Address" value="<?php if(isset($error)){ echo $_POST['address']; } ?>" tabindex="1"
					pattern=".{4,255}" oninvalid="setCustomValidity('Enter valid address')"  onchange="try{setCustomValidity('')}catch(e){}" >
				</div>
				
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-screenshot"></i></span>
							<input type="text" name="city" id="city" class="form-control input-lg" placeholder="City" tabindex="3"
							pattern=".{5,32}" oninvalid="setCustomValidity('Atleast 5 letters are expected')"  onchange="try{setCustomValidity('')}catch(e){}">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-pushpin"></i></span>
							<input type="number" name="pin" id="pin" class="form-control input-lg" placeholder="Pin Code" tabindex="4"
							min="100000" max="999999" oninvalid="setCustomValidity('6 digit pincode expected')"  onchange="try{setCustomValidity('')}catch(e){}">
						</div>
					</div>
				</div>-->
				<div class="form-group input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
					<input type="text" name="phone" id="phone" class="form-control input-lg" placeholder="Phone No." value="<?php if(isset($error)){ echo $_POST['phone']; } ?>" tabindex="1"
					 pattern="[7-9]{1}[0-9]{9}" oninvalid="setCustomValidity('10 digit number expected')"  onchange="try{setCustomValidity('')}catch(e){}" >
				</div>
				<div class="form-group input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1"
					pattern="[A-Za-z0-9]{3,32}" oninvalid="setCustomValidity('Only alphabet and numbers are Expected >3')"  onchange="try{setCustomValidity('')}catch(e){}" >
				</div>
				<div class="form-group input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="2">
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3"
							pattern=".{5,32}" oninvalid="setCustomValidity('Atleast 5 letters are expected')"  onchange="try{setCustomValidity('')}catch(e){}">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm Password" tabindex="4">
						</div>
					</div>
				</div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> I agree to the <a href="#">Terms and Conditions</a></input>
                    </label>
                </div>
				<div class="form-group">
                    <input type="submit" name="submit" value="Register" class="btn btn-primary btn-block" tabindex="5"></input>
                </div>
                <div class="form-group text-center">
                    <a href="login.php">Already Member</a>&nbsp;|&nbsp;<a href="#">Support</a>
                </div>
                </hr>
			</form>
		</div>
	</div>

</div>

<?php
//include header template
require('layout/footer.php');
?>
