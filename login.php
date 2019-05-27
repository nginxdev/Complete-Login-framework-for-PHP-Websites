<?php
        //include config
        require_once('includes/config.php');

        //check if already logged in move to home page
        if( $user->is_logged_in() ){ header('Location: index.php'); }

        //process login form if submitted
        if(isset($_POST['submit'])){

        $username = $_POST['username'];
        $password = $_POST['password'];

        if($user->login($username,$password)){
        $_SESSION['username'] = $username;
        header('Location: memberpage.php');
        exit;

        } else {
        $error[] = 'Wrong username or password or your account has not been activated.';
        }

        }//end if submit

        //define page title
        $title = 'Login';

        //include header template
        require('layout/header.php');
?>


<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <form role="form" method="post" action="" autocomplete="off">
                <h2>Please Login</h2>
                <p><a href='./'>Back to home page</a></p>
                <hr/>
                
                <?php
                        //check for any errors
                        if(isset($error)){
                        foreach($error as $error){
                        echo '<p class="bg-danger"><i class="glyphicon glyphicon-warning-sign"></i>'.$error.'</p>';
                        }
                        }

                        if(isset($_GET['action'])){

                        //check the action
                        switch ($_GET['action']) {
                        case 'active':
                        echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
                        break;
                        case 'reset':
                        echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
                        break;
                        case 'resetAccount':
                        echo "<h2 class='bg-success'>Password changed, you may now login.</h2>";
                        break;
                        }

                        }
                ?>
                
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input class="form-control input-lg" type="text" name='username' placeholder="username"/>
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input class="form-control input-lg" type="password" name='password' placeholder="password"/>
                </div>
            
                <div class="form-group">
                    <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block" tabindex="5"></input>
                </div>
                <div class="form-group text-center">
                    <a href="reset.php">Forgot Password</a>&nbsp;|&nbsp;<a href="index.php">Dont have an Account?</a>&nbsp;|&nbsp;<a href="#">Support</a>
                </div>
                <hr/>
            </form>
        </div>
    </div>
</div>
    <?php
         //include header template
            require('layout/footer.php');
     ?>
