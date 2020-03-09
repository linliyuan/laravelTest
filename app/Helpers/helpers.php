<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 2019/7/16
 * Time: 16:15
 */

$helpers = [
    "Functions.php",
];

foreach ($helpers as $helperFile)
{
    require_once __DIR__ . "/" . $helperFile;
}
