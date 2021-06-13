<?php 
    require_once('includes/config.php');
    if (!isset($_SESSION['timeout']) || $_SESSION['timeout'] < time()) {
        $login = 'http://' . $_SERVER['HTTP_HOST'] . $loginPage;
        header('Location: ' . $login);
        exit;
    } else {
        $_SESSION['timeout'] = time() + 1800; // 30 minutes
    }
 ?>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title><?php echo $pageTitle;?></title>
    <link href="css/stylesheet.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="<?php echo $icon;?>"/>
    <noscript>You must enable JavaScript to run this application.</noscript>
