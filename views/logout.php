<?php
session_start();
session_destroy();
header("Location: http://app.eltand.com/");
exit();
