<?php
// Конфигурация базы данных с использованием mysqli
class Database {
    private $host = 'localhost';
    private $db_name = 'gameup_db';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    public $conn;

    // Подключение к базе данных
    public function getConnection() {
        $this->conn = null;
        
        try {
            // Используем mysqli вместо PDO
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            
            // Проверяем соединение
            if ($this->conn->connect_error) {
                throw new Exception("Ошибка подключения: " . $this->conn->connect_error);
            }
            
            // Устанавливаем кодировку
            $this->conn->set_charset($this->charset);
            
        } catch(Exception $exception) {
            error_log("Ошибка подключения к БД: " . $exception->getMessage());
            echo "Ошибка подключения к базе данных. Проверьте настройки.";
            return null;
        }
        
        return $this->conn;
    }

    // Тест соединения
    public function testConnection() {
        try {
            $conn = $this->getConnection();
            if ($conn && !$conn->connect_error) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
