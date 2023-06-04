<?php
const DB_HOST = "localhost";

const DB_USER = "c2119789c_root";

const DB_PASS = "Abde@2001";

const DB_NAME = "c2119789c_map_events";

try {
    $db = new PDO("mysql:dbname=".DB_NAME.";host=".DB_HOST, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
