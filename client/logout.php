<?php
    session_start();

    if (!empty($_SESSION['cUser'])) {
        session_destroy();
    }

    header("location: /");
?>