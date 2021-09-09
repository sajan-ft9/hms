<?php

function clean($value) {
        $value = trim($value);            
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        return $value;
    }
