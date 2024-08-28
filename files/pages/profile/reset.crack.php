
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
                    if(isset($_SESSION['P_INFO'])) {
                        echo Config::showInfo($_SESSION['P_INFO'], $_SESSION['P_COLOR']);
                        unset($_SESSION['P_INFO']);
                        unset($_SESSION['P_COLOR']);
                    }
                    if(!isset(Config::$_url[2])) {
						include 'files/pages/404.crack.php';
						return;
					}

					$query = Config::$g_con->prepare('SELECT * FROM `panel_recovery` WHERE `Code` = ? ORDER BY `ID` DESC LIMIT 1');
					$query->execute(array(Config::$_url[2]));

					if(!$query->rowCount()) {
						Config::redirect('');
						return;
					}
					$data=$query->fetch(PDO::FETCH_OBJ);

					if(time() > $data->Time) {
						Config::redirect('');
						return;
					}

					if(Token::Check()) {
						if(isset($_POST['reset'])) {
							if($_POST['reset_name'] != $data->Name || $_POST['reset_email'] != $data->Email) {
								echo '<div class="alert alert-danger">
                                    We can\'t find a user with that e-mail address.<br>
                                </div>';
							}
							else if($_POST['password'] != $_POST['confirm_password']) {
								echo '<div class="alert alert-danger">
                                        The password confirmation does not match.<br>
                                    </div>';
							}
							else {
								$query = Config::$g_con->prepare('UPDATE `users` SET `password` = ? WHERE `name` = ? AND `Email` = ?');
								$query->execute(array(strtoupper(hash('sha256', $_POST['password'].'mafia2k20')), Config::antiXSS($_POST['reset_name']), Config::antiXSS($_POST['reset_email'])));

								Config::redirect('login');
							}
						}
					}

                    ?>
                    <form method="POST">
                        <div class="mb-4">
                            <i class="feather icon-unlock auth-icon"></i>
                        </div>
                        <h3 class="mb-4">Reset Password</h3>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="reset_name" required="" placeholder="name">
                        </div>
                        <div class="input-group mb-4">
                            <input type="Email" class="form-control" name="reset_email" required="" placeholder="Email">
                        </div>
                        <div class="input-group mb-4">
                            <input type="password" class="form-control" name="password" required="" placeholder="Password">
                        </div>
                        <div class="input-group mb-4">
                            <input type="password" class="form-control" name="confirm_password" required="" placeholder="Confirm Password">
                        </div>
                        <button class="btn btn-info shadow-2 mb-4" name="reset">Login</button>
                        <?=Token::Create()?>
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
