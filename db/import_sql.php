<?php
// Database credentials
$host = 'localhost';
$user = 'root';
$pass = '';

try {
    // Connect to MySQL server
    $mysqli = new mysqli($host, $user, $pass);

    if ($mysqli->connect_error) {
        die("Veritabanı bağlantı hatası: " . $mysqli->connect_error);
    }
    
    // Create database if not exists
    $createDb = "CREATE DATABASE IF NOT EXISTS mms_database DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if (!$mysqli->query($createDb)) {
        die("Veritabanı oluşturulamadı: " . $mysqli->error);
    }
    
    // Select the database
    $mysqli->select_db("mms_database");
    
    // Read SQL file
    $sql = file_get_contents(__DIR__ . '/mms-database.sql');
    
    // Execute multi-query SQL
    if ($mysqli->multi_query($sql)) {
        echo "Veritabanı başarıyla kuruldu!";
    } else {
        echo "Veritabanı kurulumu sırasında hata: " . $mysqli->error;
    }

    $mysqli->close();
} catch (Exception $e) {
    die("Hata: " . $e->getMessage());
}
?> 