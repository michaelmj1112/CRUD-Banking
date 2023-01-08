<?php
    session_start();

    if (!empty($_SESSION['admin'])) {
        session_destroy();
    }

    header("location: /admin");
?>