

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
                    if(Token::Check()) {
                        if(isset($_POST['reset'])) {

                            $query = Config::$g_con->prepare('SELECT * FROM `users` WHERE `name` = ? AND `Email` = ? LIMIT 1');
                            $query->execute(array($_POST['reset_name'], $_POST['reset_email']));

                            if($query->rowCount()) {
                                $getcode = Config::generateRandomString(40);
                                $to = $_POST['reset_email'];
                                $from = "no-reply@royal-squad.ro";
                                $subject = "".Config::$Name." - Recovery your password";
                                $message = "
<html>
<head>
You have received this email because a password recovery<br>
was instigated by you on ".Config::$Name." - Panel.<br><br>
<hr>
IMPORTANT!
<hr>
If you did not request this password change,please IGNORE and DELETE this<br>
email immediately. Only continue if you wish your password to be reset !<br>
<hr>
Password Reset Instructions Below
<hr>
We require that you \"validate\" your password recovery to ensure that<br>
you instigated this action. This protects against<br>
unwanted spam and malicious abuse.<br><br>
Simply click on the link below and complete the rest of the form.<br>
".Config::$URL."user/reset/".$getcode."<br><br>
Note that this link expires in 1 hour.
</body>
</html>
                                ";
                                $headers = "From: $from"; 
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                $ok = mail($to, $subject, $message, $headers, "-f " . $from);  

                                $query = Config::$g_con->prepare('INSERT INTO `panel_recovery` (`Name`, `Email`, `Code`, `Time`) VALUES (?, ?, ?, ?)');
                                $query->execute(array(Config::antiXSS($_POST['reset_name']), Config::antiXSS($_POST['reset_email']), $getcode, time()+3600));
                            } 
                            else echo '<div class="alert alert-danger">Numele sau parola sunt invalide!<br></div>';
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
                            <input type="email" class="form-control" name="reset_email" required="" placeholder="Email">
                        </div>
                        <button class="btn btn-primary shadow-2 mb-4" name="reset">Reset</button>
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
