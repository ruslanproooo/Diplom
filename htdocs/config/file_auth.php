<?php
session_start();

// Подключение к файловой системе
require_once 'file_database.php';

class FileAuth {
    private $db;

    public function __construct() {
        $this->db = new FileDatabase();
    }

    // Регистрация пользователя
    public function register($username, $email, $password, $confirmPassword) {
        try {
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
            $username = trim($username);
            $email = trim($email);

            // Проверка на существование пользователя
            if ($this->db->findUser($username, $email)) {
                return ['success' => false, 'message' => 'Пользователь с таким именем или email уже существует'];
            }

            // Создание пользователя
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $user = $this->db->addUser($username, $email, $passwordHash);
            
            $this->loginUser($user['id'], $user['username'], $user['email']);
            return ['success' => true, 'message' => 'Регистрация прошла успешно'];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Произошла ошибка при регистрации: ' . $e->getMessage()];
        }
    }

    // Авторизация пользователя
    public function login($username, $password) {
        try {
            if (empty($username) || empty($password)) {
                return ['success' => false, 'message' => 'Введите имя пользователя и пароль'];
            }

            // Очистка данных
            $username = trim($username);

            $user = $this->db->findUser($username, $username); // ищем по username или email
            
            if ($user && password_verify($password, $user['password_hash'])) {
                $this->loginUser($user['id'], $user['username'], $user['email']);
                return ['success' => true, 'message' => 'Вход выполнен успешно'];
            }
            
            return ['success' => false, 'message' => 'Неверное имя пользователя или пароль'];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Произошла ошибка при входе: ' . $e->getMessage()];
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

    // Проверка соединения (всегда true для файловой системы)
    public function testConnection() {
        return true;
    }
}
?>
