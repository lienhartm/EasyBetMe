<?php
header("X-Robots-Tag: noindex, nofollow", true);
$_SESSION['alert_cookie'] = 1;
if ($data=='accept') $_SESSION['accept_cookies'] = 1; 
else if ($data=='deny') $_SESSION['accept_cookies'] = 0; 
$from = $_SERVER['HTTP_REFERER'];
Redirection ($from);
?>