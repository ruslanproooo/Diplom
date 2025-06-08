<?php
// Скрипт для создания базы данных и таблиц
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Настройки подключения
$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'gameup_db';
$charset = 'utf8mb4';

echo "<h1>Установка базы данных GameUP</h1>";

try {
    // Шаг 1: Подключение к серверу MySQL без указания базы данных
    echo "<h2>Шаг 1: Подключение к серверу MySQL</h2>";
    $conn = new mysqli($host, $username, $password);
    
    if ($conn->connect_error) {
        throw new Exception("Ошибка подключения: " . $conn->connect_error);
    }
    
    echo "<p style='color: green;'>✅ Подключение к серверу MySQL успешно!</p>";
    
    // Шаг 2: Создание базы данных
    echo "<h2>Шаг 2: Создание базы данных</h2>";
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name CHARACTER SET $charset COLLATE {$charset}_unicode_ci";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✅ База данных '$db_name' успешно создана или уже существует!</p>";
    } else {
        throw new Exception("Ошибка при создании базы данных: " . $conn->error);
    }
    
    // Шаг 3: Выбор базы данных
    echo "<h2>Шаг 3: Выбор базы данных</h2>";
    $conn->select_db($db_name);
    echo "<p style='color: green;'>✅ База данных '$db_name' выбрана!</p>";
    
    // Шаг 4: Создание таблиц
    echo "<h2>Шаг 4: Создание таблиц</h2>";
    
    // Таблица пользователей
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✅ Таблица 'users' успешно создана!</p>";
    } else {
        throw new Exception("Ошибка при создании таблицы users: " . $conn->error);
    }
    
    // Таблица игр
    $sql = "CREATE TABLE IF NOT EXISTS games (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        slug VARCHAR(100) NOT NULL UNIQUE,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✅ Таблица 'games' успешно создана!</p>";
    } else {
        throw new Exception("Ошибка при создании таблицы games: " . $conn->error);
    }
    
    // Таблица обновлений игр
    $sql = "CREATE TABLE IF NOT EXISTS game_updates (
        id INT AUTO_INCREMENT PRIMARY KEY,
        game_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        update_date DATE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✅ Таблица 'game_updates' успешно создана!</p>";
    } else {
        throw new Exception("Ошибка при создании таблицы game_updates: " . $conn->error);
    }
    
    // Таблица комментариев
    $sql = "CREATE TABLE IF NOT EXISTS comments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        update_id INT NOT NULL,
        user_id INT NULL,
        author_name VARCHAR(100) NOT NULL,
        author_email VARCHAR(100),
        content TEXT NOT NULL,
        parent_id INT NULL,
        likes_count INT DEFAULT 0,
        is_approved BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (update_id) REFERENCES game_updates(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✅ Таблица 'comments' успешно создана!</p>";
    } else {
        throw new Exception("Ошибка при создании таблицы comments: " . $conn->error);
    }
    
    // Добавляем внешний ключ для parent_id отдельно
    $sql = "ALTER TABLE comments ADD FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE CASCADE";
    $conn->query($sql);
    
    // Таблица лайков комментариев
    $sql = "CREATE TABLE IF NOT EXISTS comment_likes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        comment_id INT NOT NULL,
        user_ip VARCHAR(45) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (comment_id) REFERENCES comments(id) ON DELETE CASCADE,
        UNIQUE KEY unique_like (comment_id, user_ip)
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✅ Таблица 'comment_likes' успешно создана!</p>";
    } else {
        throw new Exception("Ошибка при создании таблицы comment_likes: " . $conn->error);
    }
    
    // Шаг 5: Добавление тестовых данных
    echo "<h2>Шаг 5: Добавление тестовых данных</h2>";
    
    // Добавление игр
    $games = [
        ['Counter-Strike 2', 'cs2', 'Легендарный тактический шутер'],
        ['Rust', 'rust', 'Игра на выживание в открытом мире'],
        ['Dota 2', 'dota2', 'Многопользовательская онлайновая боевая арена'],
        ['PUBG', 'pubg', 'Королевская битва'],
        ['Valorant', 'valorant', 'Тактический шутер от Riot Games'],
        ['World of Tanks', 'wot', 'Танковые сражения'],
        ['Fortnite', 'fortnite', 'Королевская битва с строительством']
    ];
    
    $gamesAdded = 0;
    foreach ($games as $game) {
        $name = $conn->real_escape_string($game[0]);
        $slug = $conn->real_escape_string($game[1]);
        $description = $conn->real_escape_string($game[2]);
        
        $sql = "INSERT IGNORE INTO games (name, slug, description) VALUES ('$name', '$slug', '$description')";
        if ($conn->query($sql) === TRUE && $conn->affected_rows > 0) {
            $gamesAdded++;
        }
    }
    
    echo "<p style='color: green;'>✅ Добавлено $gamesAdded игр!</p>";
    
    // Добавление обновлений для CS2
    $updates = [
        ['1', 'Обновление "Операция Гидроудар"', 'Новая операция с уникальными заданиями, картами и скинами. Добавлена водная механика на картах.', '2024-05-20'],
        ['1', 'Обновление "Точный удар"', 'Крупное обновление, посвященное балансу оружия и улучшению механик стрельбы.', '2024-04-15'],
        ['1', 'Карты нового сезона', 'Добавлены 3 новые карты в соревновательный режим и переработаны 2 классические карты.', '2024-04-03'],
        ['1', 'Античит и стабильность', 'Улучшения системы античита и исправление ошибок, влияющих на стабильность игры.', '2024-03-22'],
        ['1', 'Киберспортивный пакет', 'Обновление для профессиональных игроков и турниров с новыми инструментами для зрителей.', '2024-03-10']
    ];
    
    $updatesAdded = 0;
    foreach ($updates as $update) {
        $game_id = $conn->real_escape_string($update[0]);
        $title = $conn->real_escape_string($update[1]);
        $content = $conn->real_escape_string($update[2]);
        $date = $conn->real_escape_string($update[3]);
        
        $sql = "INSERT IGNORE INTO game_updates (game_id, title, content, update_date) 
                VALUES ('$game_id', '$title', '$content', '$date')";
        if ($conn->query($sql) === TRUE && $conn->affected_rows > 0) {
            $updatesAdded++;
        }
    }
    
    echo "<p style='color: green;'>✅ Добавлено $updatesAdded обновлений для CS2!</p>";
    
    // Шаг 6: Создание тестового пользователя
    echo "<h2>Шаг 6: Создание тестового пользователя</h2>";
    
    $username = 'admin';
    $email = 'admin@example.com';
    $password = 'admin123';
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT IGNORE INTO users (username, email, password_hash) VALUES ('$username', '$email', '$passwordHash')";
    if ($conn->query($sql) === TRUE && $conn->affected_rows > 0) {
        echo "<p style='color: green;'>✅ Тестовый пользователь создан!</p>";
        echo "<p>Логин: <strong>admin</strong><br>Пароль: <strong>admin123</strong></p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Тестовый пользователь уже существует или произошла ошибка.</p>";
    }
    
    // Завершение
    echo "<h2>Установка завершена!</h2>";
    echo "<p style='color: green;'>✅ База данных успешно настроена!</p>";
    echo "<p><a href='index.php' style='color: #ff6f61; font-weight: bold;'>Перейти на главную страницу</a></p>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Ошибка: " . $e->getMessage() . "</p>";
}
?>
