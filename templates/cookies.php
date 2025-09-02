<?php
header("X-Robots-Tag: noindex, nofollow", true);
$_SESSION['alert_cookie'] = 1;
$from = $_SERVER['HTTP_REFERER'];
Redirection ($from);
?>