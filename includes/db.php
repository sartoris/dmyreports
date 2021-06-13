<?php
    require_once('includes/config.php');
    $connection = new mysqli($hostname_connDB, $username_connDB, $password_connDB, $database_connDB);

    function getUserID($loginId, $password) {
        global $connection;
        $userid = 0;
        $hash = "";
        $statement = $connection->prepare("SELECT ID, Password FROM `User` WHERE LoginId = ?");
        $statement->bind_param("s", $loginId);
        $statement->execute();
        $result = $statement->bind_result($userid, $hash);
        if ($result == false) {
            $_SESSION['errorMsg'] = $connection->error;
        } else {
            $statement->fetch();
			if (!password_verify($password, $hash)) {
				$userid = 0;
			}
        }
        $statement->close();
        return $userid;
    }

?>
