<?php

function showError($errno, $errstr, $errfile, $errline)
{
    echo 'Error : '.$errno;
    echo '<br> File : '.$errfile;
    echo '<br> Line : '.$errline;
    echo '<br> Error content : '.$errstr;
}

function show404Error()
{
    Controller::show404Error();
}