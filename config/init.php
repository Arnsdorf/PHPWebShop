<?php

// Kontroller om CONFIG_LIVE allerede er defineret
if (!defined('CONFIG_LIVE')) {
    define("CONFIG_LIVE", "0"); // eller "1" afhængigt af din konfiguration
}

require_once "classDB.php";

if (CONFIG_LIVE == 0) {
    $DB_SERVER = "localhost";
    $DB_NAME = "bookstore";
    $DB_USER = "root";
    $DB_PASS = "";
} else {
    $DB_SERVER = "";
    $DB_NAME = "";
    $DB_USER = "";
    $DB_PASS = "";
}

$secret_key = "sk_test_51P69bDP6aAY7wR1plgVBptRmqjCfmmp2IPpayCiFRKnY3EEO66d7GxMBCUmzDr7WDm4ysUSboObKaThJwUy8tXtY00khtJHZVO";

$db = new db($DB_SERVER, $DB_NAME, $DB_USER, $DB_PASS);


