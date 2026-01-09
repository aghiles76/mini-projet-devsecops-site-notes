<?php
ini_set('display_errors','1');
error_reporting(E_ALL);

echo "OK PHP works<br>";
echo "Document root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'n/a') . "<br>";
echo "Script: " . __FILE__ . "<br>";
phpinfo();
