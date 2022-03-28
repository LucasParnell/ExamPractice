<?php
include_once "../BladeOne/lib/BladeOne.php";
use eftec\bladeone\BladeOne;

$template_folder = "../resources/views/";
$cache_folder = "../resources/cache/";

$SITE_DEBUG_ENABLED = true;

$blade = new BladeOne($template_folder, $cache_folder);
?>