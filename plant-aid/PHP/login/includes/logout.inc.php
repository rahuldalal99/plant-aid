<?php

session_start();
session_unset();
session_destroy();

header("Location: http://139.59.70.219:420/login/index.php");

