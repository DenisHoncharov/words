<?php
session_start();

$usSession = \model\system\Session::getInstance();

$hash               = hash( 'sha256', microtime() );
$_SESSION['closer'] = $hash;

try {
	if ( $sessionError = $usSession->getSession( 'error' ) ) {
		$usSession->deleteSessionParam('error');
	}

	if($prevUserInput = $usSession->getSession('prevUserInput')){
		$usSession->deleteSessionParam('prevUserInput');
    }
}catch (\model\exceptions\SessionEcxeption $e){

}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log in</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
          integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <!--Own css style-->
    <link rel="stylesheet" href="../style/myOwn.css">

</head>
<body>
<div class="container">
    <div class="row">

        <video playsinline autoplay muted loop poster="" id="bg_video">
            <!--<source src="polina.webm" type="video/webm">-->
            <source src="../video/bg-form.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <form class="form-signin" action="http://words-game.com/index.php/saveUser" method="post">

            <h2 class="form-signin-header">Registration form</h2>
            <span class="Formerror"><?php if(isset($sessionError['error_msg'])) echo $sessionError['error_msg']."<br />" ?></span>

            <label for="name" class="sr-only">Name:</label>
            <span class="Formerror"><?php if(isset($sessionError['error_name'])) echo $sessionError['error_name']."<br />" ?></span>
            <input type="text" id="name" name="name" class="form-control" placeholder="Name" required
                   value="<?php if(isset($prevUserInput['name'])) echo $prevUserInput['name'] ?>"><br>

            <label for="surname" class="sr-only">Surname:</label>
            <span class="Formerror"><?php if(isset($sessionError['error_surname'])) echo $sessionError['error_surname']."<br />" ?></span>
            <input type="text" id="surname" name="surname" class="form-control" placeholder="Surname" required
                   value="<?php if(isset($prevUserInput['surname'])) echo $prevUserInput['surname'] ?>"><br>

            <label for="mail" class="sr-only">Mail:</label>
            <span class="Formerror"><?php if(isset($sessionError['error_mail'])) echo $sessionError['error_mail']."<br />" ?></span>
            <input type="email" id="mail" name="mail" class="form-control" placeholder="Email" required
                   value="<?php if(isset($prevUserInput['mail'])) echo $prevUserInput['mail'] ?>"><br>

            <label for="phone" class="sr-only">Phone:</label>
            <span class="Formerror"><?php if(isset($sessionError['error_phone'])) echo $sessionError['error_phone']."<br />" ?></span>
            <input type="text" id="phone" name="phone" maxlength="10" class="form-control" placeholder="Phone number" required
                   value="<?php if(isset($prevUserInput['phone'])) echo $prevUserInput['phone'] ?>"><br>

            <label for="login" class="sr-only">Login:</label>
            <span class="Formerror"><?php if(isset($sessionError['error_login'])) echo $sessionError['error_login']."<br />" ?></span>
            <input type="text" id="login" name="login" class="form-control" placeholder="login" required
                   value="<?php if(isset($prevUserInput['login'])) echo $prevUserInput['login'] ?>"><br>

            <label for="password" class="sr-only">Password:</label>
            <span class="Formerror"><?php if(isset($sessionError['error_password'])) echo $sessionError['error_password']."<br />" ?></span>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                   required value="<?php if(isset($prevUserInput['password'])) echo $prevUserInput['password'] ?>"><br>

            <input type="hidden" name="hidden" value="<?= $hash ?>">
            <input type="submit" name="submit" class="btn btn-primary btn-block" value="submit">
        </form>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"
        integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
        crossorigin="anonymous"></script>
</body>
</html>

