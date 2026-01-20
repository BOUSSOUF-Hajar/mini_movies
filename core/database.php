<?php

class Database {
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS
            );
        }
        return self::$instance;
    }
}
