<?php 
if(!isset($_SESSION['LOGGED'])) {
    Config::redirect('');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?=Config::$Name?> - control user</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Datta Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="admin templates, bootstrap admin templates, bootstrap 4, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, datta able, datta able bootstrap admin template, free admin theme, free dashboard template"/>
    <meta name="author" content="CodedThemes"/>

    <!-- Favicon icon -->
    <link rel="icon" href="<?=Config::$URL?>assets/images/favicon.ico" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="<?=Config::$URL?>assets/fonts/fontawesome/css/fontawesome-all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="<?=Config::$URL?>assets/plugins/animation/css/animate.min.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="<?=Config::$URL?>assets/css/style.css">

</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="auth-bg">
                <span class="r"></span>
                <span class="r s"></span>
                <span class="r s"></span>
                <span class="r"></span>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <?php 
                    if(isset($_POST['login_pin'])) {
                        $query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `Pin` = ? AND `id` = ? LIMIT 1');
                        $query->execute(array($_POST['your_pin'], $_SESSION['LOGGED']));
                        if($query->rowCount()) {
                            Config::redirect('');
                            $_SESSION['PIN_LOGGED'] = true;
                            exit;
                        } else echo Config::alertView('Pin-ul pe care l-ai introdus este invalid!');
                    }

                    ?>
                    <form method="POST">
                        <div class="mb-4">
                            <i class="feather icon-unlock auth-icon"></i>
                        </div>
                        <h3 class="mb-4">Your PIN</h3>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="your_pin" required="" placeholder="PIN" maxlength="4" pattern="[0-9]+">
                        </div>
                        <button class="btn btn-primary shadow-2 mb-4" name="login_pin">CHECK PIN</button>
                        <p class="mb-2 text-muted">Forgot password? <a href="<?=Config::$URL.'user/forgot/pin'?>">Reset</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Js -->
    <script src="<?=Config::$URL?>assets/js/vendor-all.min.js"></script>
	<script src="<?=Config::$URL?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
