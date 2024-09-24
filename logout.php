<?php

session_start();

// セッションに保存してあるIDを削除(unset:復元)
unset($_SESSION['id']);

// cookieを削除
setcookie('id', '', time() - 1, '/');
            // 名前、値、時間、パス

header('Location: ./login.php');

?>
 