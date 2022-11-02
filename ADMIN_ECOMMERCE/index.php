<?php
session_start();
if (isset($_SESSION['login'])) {
    if ((time() - $_SESSION['timer']) > 60000) {
      unset($_SESSION['login']);
      session_destroy();
      header('Location: login.php');
    }else {
        header('Location: pesanan.php');
    }
}else {
    header('Location: login.php');
}
?>