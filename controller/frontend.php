<?php

function error($err)
{
    $error_str = $err;
    require('view/error.php');
}

function welcome()
{
    require('view/welcome.php');
}
