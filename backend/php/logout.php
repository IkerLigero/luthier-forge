<?php
session_start();

session_unset();
session_destroy();

header("Location: ../../frontend/auth/login.html");
exit();