<?php
    session_start();
    include 'includes/db.php';
?>

<html>

<head>
    <link rel="stylesheet" href="css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sign in</title>
    <link rel="icon" type="image/png" href="<?php echo $icon;?>"/>
<?php
    $msg = "";
    if (isset($_POST['login']))
    {
        if(!isset($_POST['loginId']) || empty($_POST['loginId'])) {
            $msg = "Login Id is required";
        } else if(!isset($_POST['password']) || empty($_POST['password'])) {
            $msg = "Password is required";
        } else {
            $userid = getUserID($_POST['loginId'], $_POST['password']);
            if(isset($_SESSION['errorMsg'])) {
                $msg = $_SESSION['errorMsg'];
                unset($_SESSION['errorMsg']);
            } else if ($userid == 0) {
                $msg = "Bad password or login id";
            } else {
                $_SESSION['userid'] = $userid;
                $_SESSION['timeout'] = time() + 1800; // 30 minutes
                header('Location: index.php');
                exit();
            }
        }
    } else {
        unset($_SESSION['errorMsg']);
        unset($_SESSION['userid']);
        unset($_SESSION['timeout']);
    }
?>
    <script language="javascript">

        function onLoad() {
            document.getElementById("loginId").focus();
        }

    </script>
</head>

<body onLoad="onLoad()">
    <div class="main">
        <div class="logo">
            <img src="<?php echo $loginLogo ?>" alt="Login Logo"/>
            <p class="info" align="center" >For login issues, email <br/><?php echo $contact ?></p>
        </div>
        <div class="login">
            <p class="sign">Sign in</p>
            <div class="error" align="center" ><?php echo $msg ?></div>
            <form class="form1" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                <input class="un" type="text" align="center" id="loginId" name="loginId" placeholder="Login Id">
                <input class="pass" type="password" align="center" name="password" placeholder="Password">
                <input type="submit" class="submit" align="center" name="login" value="Sign in">
            </form>
        </div>
    </div>
</body>

</html>