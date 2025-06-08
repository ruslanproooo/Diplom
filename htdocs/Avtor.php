<?php
require_once 'config/auth.php';

$auth = new Auth();
$message = '';
$messageType = '';

// Обработка формы входа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $result = $auth->login($username, $password);
    
    if ($result['success']) {
        $messageType = 'success';
        $message = $result['message'];
        // Перенаправление на главную страницу после успешного входа
        header('Location: index.php');
        exit();
    } else {
        $messageType = 'error';
        $message = $result['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameUP - Вход</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #1a1a1a;
            color: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            overflow-x: hidden;
        }

        header {
            background-color: #0d0d0d;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        header .logo {
            font-size: 24px;
            font-weight: bold;
            color: #ff6f61;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        header .logo a {
            text-decoration: none;
            color: #ff6f61;
        }
        header .nav-center {
            display: flex;
            gap: 20px;
            position: relative;
        }
        header .nav-center a {
            text-decoration: none;
            color: #ffffff;
            position: relative;
        }
        header .nav-right {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        header .nav-right a {
            text-decoration: none;
            color: #000000;
        }
        header nav a {
            text-decoration: none;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            transition: all 0.3s ease;
            background: linear-gradient(45deg, #333, #555);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        header nav a:hover {
            background: linear-gradient(45deg, #555, #777);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        header .nav-right a {
            padding: 8px 16px;
            border-radius: 4px;
            transition: all 0.3s ease;
            background: linear-gradient(45deg, #ff6f61, #ff3b2f);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        header .nav-right a:hover {
            background: linear-gradient(45deg, #ff3b2f, #ff6f61);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 4px;
            overflow: hidden;
            top: 100%;
            left: 0;
        }
        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
            border-bottom: 1px solid #444;
        }
        .dropdown-content a:last-child {
            border-bottom: none;
        }
        .dropdown-content a:hover {
            background-color: #444;
            color: #ff6f61;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* СТИЛИ ДЛЯ ПОЛЬЗОВАТЕЛЯ */
        .user-menu {
            position: relative;
            display: inline-block;
        }
        
        .user-name {
            color: #ff6f61;
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 4px;
            background: linear-gradient(45deg, #333, #555);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .user-name:hover {
            background: linear-gradient(45deg, #555, #777);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        
        .user-dropdown {
            display: none;
            position: absolute;
            right: 0;
            background-color: #333;
            min-width: 150px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 4px;
            overflow: hidden;
            top: 100%;
        }
        
        .user-dropdown a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }
        
        .user-dropdown a:hover {
            background-color: #444;
            color: #ff6f61;
        }
        
        .user-menu:hover .user-dropdown {
            display: block;
        }

        .auth-container {
            width: calc(100% - 40px);
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #262626;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            box-sizing: border-box;
        }
        .auth-container h2 {
            margin-bottom: 20px;
            color: #ff6f61;
        }
        .auth-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #444;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #333;
            color: #ffffff;
        }
        .auth-container input::placeholder {
            color: #888;
        }
        .auth-container button {
            width: 100%;
            padding: 10px;
            background: linear-gradient(45deg, #ff6f61, #ff3b2f);
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .auth-container button:hover {
            background: linear-gradient(45deg, #ff3b2f, #ff6f61);
        }
        .auth-container a {
            display: block;
            margin-top: 10px;
            color: #ff6f61;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .auth-container a:hover {
            color: #ff3b2f;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }
        .message.success {
            background-color: #4CAF50;
            color: white;
        }
        .message.error {
            background-color: #f44336;
            color: white;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 10px;
                padding: 15px;
            }
            
            header .nav-center {
                order: 3;
                width: 100%;
                justify-content: center;
            }
            
            .auth-container {
                margin: 20px auto;
                padding: 15px;
                width: calc(100% - 20px);
            }
            
            footer .footer-content {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo"><a href="index.php">GameUP</a></div>
        <div class="nav-center">
            <div class="dropdown">
                <a href="#" class="dropdown-btn">Обновления</a>
                <div class="dropdown-content">
                    <a href="cs2-updates.php">Counter-Strike 2</a>
                    <a href="rust-updates.php">Rust</a>
                    <a href="dota2-updates.php">Dota 2</a>
                    <a href="pubg-updates.php">PUBG</a>
                    <a href="valorant-updates.php">Valorant</a>
                    <a href="wot-updates.php">World of Tanks</a>
                    <a href="fortnite-updates.php">Fortnite</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#" class="dropdown-btn">Обзор</a>
                <div class="dropdown-content">
                    <a href="cs2-review.php">Counter-Strike 2</a>
                    <a href="rust-review.php">Rust</a>
                    <a href="dota2-review.php">Dota 2</a>
                    <a href="pubg-review.php">PUBG</a>
                    <a href="valorant-review.php">Valorant</a>
                    <a href="wot-review.php">World of Tanks</a>
                    <a href="fortnite-review.php">Fortnite</a>
                </div>
            </div>
        </div>
        <div class="nav-right">
            <?php if ($auth->isLoggedIn()): ?>
                <?php $user = $auth->getUser(); ?>
                <div class="user-menu">
                    <div class="user-name"><?php echo htmlspecialchars($user['username']); ?></div>
                    <div class="user-dropdown">
                        <a href="profile.php">Профиль</a>
                        <a href="logout.php">Выйти</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="Avtor.php">Вход</a>
                <a href="Reg2.php">Регистрация</a>
            <?php endif; ?>
        </div>
    </header>
    
    <div class="auth-container">
        <h2>Вход</h2>
        
        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Имя пользователя или Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Войти</button>
        </form>
        
        <a href="Reg2.php">Нет аккаунта? Зарегистрироваться</a>
    </div>
</body>
</html>
