<?php 
session_start();
require_once 'main-assets/connection.php';
// if (!empty($_SESSION['email'] || !empty($_SESSION['role']))){
//     echo "<script type='text/javascript'>window.location = 'index.php';</script>";
//     die();
// }
$msg = " ";
if (isset($_POST['login'])) {
    $logEmail = $_POST["email"];
    $LogPassword = $_POST["password"];
    $sql = "SELECT * FROM `pos_users` WHERE `email`='$logEmail'";
    $result = mysqli_query($con, $sql);
    if(!$result){
        echo mysqli_error($con);
    }
    $num = mysqli_num_rows($result);
    if ($num == 1){
        
        foreach($result as $row){
            if($row['status']==1){
                $_SESSION['id'] = $row['id'];
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['password'] = $row['password'];
                if($row['password'] == $_POST["password"]){
                    header("location: index.php");
                }else{
                    $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Error!</strong> Invalid Credentials!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }else{
                $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Error!</strong> Access Denied! (Please Contact Admin for further Queries)<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        }
    }else{
        $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Error!</strong> No User With this Email!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="POS - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Login - Pos admin template</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
        <!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
		
    </head>
    <body class="account-page">
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
			<div class="account-content">
				<div class="login-wrapper">
                    <div class="login-content">
                        <form action="" method="POST" class="login-userset">
                            <div class="login-logo logo-normal">
                                <img src="assets/img/logo.png" alt="img">
                            </div>
                            <a href="" class="login-logo logo-white">
                                <img src="assets/img/logo-white.png"  alt="">
                            </a>
                            <div class="login-userheading">
                                <h3>Sign In</h3>
                                <h4>Please login to your account</h4>
                            </div>
                            <?=$msg?>
                            <div class="form-login">
                                <label>Email</label>
                                <div class="form-addons">
                                    <input type="text" required name="email" placeholder="Enter your email address">
                                    <img src="assets/img/icons/mail.svg" alt="img">
                                </div>
                            </div>
                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" required name="password" class="pass-input" placeholder="Enter your password">
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                            <!-- <div class="form-login">
                                <div class="alreadyuser">
                                    <h4><a href="forgetpassword.html" class="hover-a">Forgot Password?</a></h4>
                                </div>
                            </div> -->
                            <div class="form-login">
                                <button type="submit" class="btn btn-login" name="login">Sign In</button>
                            </div>
                            <!-- <div class="signinform text-center">
                                <h4>Don't have an account? <a href="signup.html" class="hover-a">Sign Up</a></h4>
                            </div>
                            <div class="form-setlogin">
                                <h4>Or sign up with</h4>
                            </div>
                            <div class="form-sociallink">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <img src="assets/img/icons/google.png" class="me-2" alt="google">
                                            Sign Up using Google
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <img src="assets/img/icons/facebook.png" class="me-2" alt="google">
                                            Sign Up using Facebook
                                        </a>
                                    </li>
                                </ul>
                            </div> -->
                        </form>
                    </div>
                    <div class="login-img">
                        <img src="assets/img/login.jpg" alt="img">
                    </div>
                </div>
			</div>
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="assets/js/jquery-3.6.0.min.js"></script>
         <!-- Feather Icon JS -->
		<script src="assets/js/feather.min.js"></script>
		<!-- Bootstrap Core JS -->
        <script src="assets/js/bootstrap.bundle.min.js"></script>
		<!-- Custom JS -->
		<!-- <script src="assets/js/script.js"></script> -->
        <script>
            // toggle-password
        if($('.toggle-password').length > 0) {
            $(document).on('click', '.toggle-password', function() {
                    $(this).toggleClass("fa-eye fa-eye-slash");
                    var input = $(".pass-input");
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });
            }
            if($('.toggle-passwords').length > 0) {
                $(document).on('click', '.toggle-passwords', function() {
                    $(this).toggleClass("fa-eye fa-eye-slash");
                    var input = $(".pass-inputs");
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });
            }
            if($('.toggle-passworda').length > 0) {
                $(document).on('click', '.toggle-passworda', function() {
                    $(this).toggleClass("fa-eye fa-eye-slash");
                    var input = $(".pass-inputs");
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });
            }
        </script>
    </body>
</html>