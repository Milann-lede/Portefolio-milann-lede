<?php

    require 'header.php';

if(!isset($_SESSION['conecter']))
    {
        header('location:../../index.php');
        die;
    }
