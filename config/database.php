<?php
/**
 * MMS - Marine Management System
 * Database Configuration
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'mms_database');
define('DB_USER', 'root'); // Change for production
define('DB_PASS', '');     // Change for production

// Database connection
try {
    $db = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    // In development: show error
    if (in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1', '::1'])) {
        die('Database Connection Error: ' . $e->getMessage());
    } else {
        // In production: log error and show generic message
        error_log('Database Connection Error: ' . $e->getMessage());
        die('A database connection error occurred. Please try again later.');
    }
}

/**
 * Execute a database query with parameters
 * 
 * @param string $sql SQL query
 * @param array $params Parameters for prepared statement
 * @return PDOStatement The result statement
 */
function db_query($sql, $params = []) {
    global $db;
    
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log('Database Query Error: ' . $e->getMessage());
        throw $e;
    }
}

/**
 * Get a single row from the database
 * 
 * @param string $sql SQL query
 * @param array $params Parameters for prepared statement
 * @return array|false The result row or false if not found
 */
function db_get_row($sql, $params = []) {
    $stmt = db_query($sql, $params);
    return $stmt->fetch();
}

/**
 * Get multiple rows from the database
 * 
 * @param string $sql SQL query
 * @param array $params Parameters for prepared statement
 * @return array The result rows
 */
function db_get_rows($sql, $params = []) {
    $stmt = db_query($sql, $params);
    return $stmt->fetchAll();
}

/**
 * Insert data into a table
 * 
 * @param string $table Table name
 * @param array $data Associative array of column => value
 * @return int|false The last insert ID or false on failure
 */
function db_insert($table, $data) {
    global $db;
    
    try {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $db->prepare($sql);
        $stmt->execute(array_values($data));
        
        return $db->lastInsertId();
    } catch (PDOException $e) {
        error_log('Database Insert Error: ' . $e->getMessage());
        return false;
    }
}

/**
 * Update data in a table
 * 
 * @param string $table Table name
 * @param array $data Associative array of column => value
 * @param string $where Where clause
 * @param array $params Parameters for where clause
 * @return int|false Number of affected rows or false on failure
 */
function db_update($table, $data, $where, $params = []) {
    global $db;
    
    try {
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "{$column} = ?";
        }
        
        $sql = "UPDATE {$table} SET " . implode(', ', $set) . " WHERE {$where}";
        $stmt = $db->prepare($sql);
        $stmt->execute(array_merge(array_values($data), $params));
        
        return $stmt->rowCount();
    } catch (PDOException $e) {
        error_log('Database Update Error: ' . $e->getMessage());
        return false;
    }
}

/**
 * Delete data from a table
 * 
 * @param string $table Table name
 * @param string $where Where clause
 * @param array $params Parameters for where clause
 * @return int|false Number of affected rows or false on failure
 */
function db_delete($table, $where, $params = []) {
    global $db;
    
    try {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->rowCount();
    } catch (PDOException $e) {
        error_log('Database Delete Error: ' . $e->getMessage());
        return false;
    }
}
