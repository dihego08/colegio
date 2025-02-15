<?php
    session_start();
    unset($_SESSION['id']);
    unset($_SESSION['nivel']);
    unset($_SESSION['nombres']);
    echo "<script>location.href='../login/login_a.php';</script>";
?>