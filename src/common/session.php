<?php

    // セッション開始
    function session_start_if_none() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    function is_logged_in() {
        
    }
?>
