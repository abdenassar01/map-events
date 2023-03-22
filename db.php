<?php
    define("DB_HOST", "localhost");

    define("DB_USER", "root");

    define("DB_PASS","27701");

    define("DB_NAME","map_events");

    try {
        $db = new PDO("mysql:dbname=".DB_NAME.";host=".DB_HOST, DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>