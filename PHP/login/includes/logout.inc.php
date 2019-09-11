<?php

session_start();
session_unset();
session_destroy();

header("Location: http://167.71.227.193:420");
