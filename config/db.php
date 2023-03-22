<?php
const DB_HOST = "localhost";

    const DB_USER = "root";

    const DB_PASS = "27701";

    const DB_NAME = "map_events";

    try {
        $db = new PDO("mysql:dbname=".DB_NAME.";host=".DB_HOST, DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>