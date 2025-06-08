<?php
session_start();

// Подключение к базе данных
require_once 'database.php';

class Auth {
    private $db;
    private $conn;

    public function __construct() {
        try {
            $this->db = new Database();
            $this->conn = $this->db->getConnection();
            
            // Проверяем, что соединение установлено
            if (!$this->conn) {
                throw new Exception("Не удалось подключиться к базе данных");
            }
        } catch (Exception $e) {
            error_log("Ошибка подключения к БД в Auth: " . $e->getMessage());
            throw new Exception("Ошибка подключения к базе данных");
        }
    }

    // Регистрация пользователя
    public function register($username, $email, $password, $confirmPassword) {
        try {
            // Проверяем соединение с БД
            if (!$this->conn) {
                return ['success' => false, 'message' => 'Ошибка подключения к базе данных'];
            }

            // Валидация
            if (empty($username) || empty($email) || empty($password)) {
                return ['success' => false, 'message' => 'Все поля обязательны для заполнения'];
            }

            if ($password !== $confirmPassword) {
                return ['success' => false, 'message' => 'Пароли не совпадают'];
            }

            if (strlen($password) < 6) {
                return ['success' => false, 'message' => 'Пароль должен содержать минимум 6 символов'];
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'message' => 'Некорректный email адрес'];
            }

            // Очистка данных
            $username = $this->conn->real_escape_string(trim($username));
            $email = $this->conn->real_escape_string(trim($email));

            // Проверка на существование пользователя
            $checkQuery = "SELECT id FROM users WHERE username = '$username' OR email = '$email'";
            $checkResult = $this->conn->query($checkQuery);
            
            if (!$checkResult) {
                return ['success' => false, 'message' => 'Ошибка выполнения запроса: ' . $this->conn->error];
            }

            if ($checkResult->num_rows > 0) {
                return ['success' => false, 'message' => 'Пользователь с таким именем или email уже существует'];
            }

            // Создание пользователя
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO users (username, email, password_hash) VALUES ('$username', '$email', '$passwordHash')";
            
            if ($this->conn->query($insertQuery)) {
                $userId = $this->conn->insert_id;
                $this->loginUser($userId, $username, $email);
                return ['success' => true, 'message' => 'Регистрация прошла успешно'];
            } else {
                return ['success' => false, 'message' => 'Ошибка при регистрации: ' . $this->conn->error];
            }

        } catch (Exception $e) {
            error_log("Ошибка в register: " . $e->getMessage());
            return ['success' => false, 'message' => 'Произошла ошибка при регистрации'];
        }
    }

    // Авторизация пользователя
    public function login($username, $password) {
        try {
            // Проверяем соединение с БД
            if (!$this->conn) {
                return ['success' => false, 'message' => 'Ошибка подключения к базе данных'];
            }

            if (empty($username) || empty($password)) {
                return ['success' => false, 'message' => 'Введите имя пользователя и пароль'];
            }

            // Очистка данных
            $username = $this->conn->real_escape_string(trim($username));

            $query = "SELECT id, username, email, password_hash FROM users WHERE username = '$username' OR email = '$username'";
            $result = $this->conn->query($query);
            
            if (!$result) {
                return ['success' => false, 'message' => 'Ошибка выполнения запроса: ' . $this->conn->error];
            }

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                if (password_verify($password, $user['password_hash'])) {
                    $this->loginUser($user['id'], $user['username'], $user['email']);
                    return ['success' => true, 'message' => 'Вход выполнен успешно'];
                }
            }
            
            return ['success' => false, 'message' => 'Неверное имя пользователя или пароль'];

        } catch (Exception $e) {
            error_log("Ошибка в login: " . $e->getMessage());
            return ['success' => false, 'message' => 'Произошла ошибка при входе'];
        }
    }

    // Установка сессии пользователя
    private function loginUser($userId, $username, $email) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['logged_in'] = true;
    }

    // Выход пользователя
    public function logout() {
        session_destroy();
        return ['success' => true, 'message' => 'Вы успешно вышли из системы'];
    }

    // Проверка авторизации
    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    // Получение данных пользователя
    public function getUser() {
        if ($this->isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'email' => $_SESSION['email']
            ];
        }
        return null;
    }

    // Проверка соединения с БД
    public function testConnection() {
        try {
            if ($this->conn && !$this->conn->connect_error) {
                $result = $this->conn->query("SELECT 1");
                return $result !== false;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
