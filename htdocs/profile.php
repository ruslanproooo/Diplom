<?php
require_once 'config/auth.php';

$auth = new Auth();

// Проверяем авторизацию
if (!$auth->isLoggedIn()) {
    header('Location: Avtor.php');
    exit();
}

$user = $auth->getUser();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameUP - Профиль</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #1a1a1a;
            color: #ffffff;
            overflow-x: hidden;
            width: 100%;
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
            box-sizing: border-box;
            flex-wrap: wrap;
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

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #262626;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            width: calc(100% - 40px);
            border-radius: 8px;
            box-sizing: border-box;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #ff6f61;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 4px;
            background: linear-gradient(45deg, #333, #555);
            transition: all 0.3s ease;
        }

        .back-link:hover {
            background: linear-gradient(45deg, #555, #777);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .profile-grid {
            display: grid;
            gap: 20px;
            grid-template-columns: 1fr;
        }

        @media (min-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr 2fr;
            }
        }

        .profile-card {
            background-color: #333;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(45deg, #ff6f61, #ff3b2f);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0 auto 20px;
            border: 4px solid rgba(255, 111, 97, 0.2);
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: bold;
            color: #ff6f61;
            margin-bottom: 20px;
        }

        .edit-button {
            padding: 10px 20px;
            background: linear-gradient(45deg, #ff6f61, #ff3b2f);
            border: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            width: 100%;
            text-align: center;
        }

        .edit-button:hover {
            background: linear-gradient(45deg, #ff3b2f, #ff6f61);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .profile-info {
            background-color: #333;
            padding: 20px;
            border-radius: 8px;
        }

        .profile-info h2 {
            color: #ff6f61;
            margin-top: 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }

        .info-grid {
            display: grid;
            gap: 15px;
            grid-template-columns: 1fr;
        }

        @media (min-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .info-item {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: bold;
            color: #ff6f61;
            display: block;
            margin-bottom: 5px;
        }

        .info-value {
            color: #ffffff;
            background-color: #444;
            padding: 8px 12px;
            border-radius: 4px;
            border-left: 3px solid #ff6f61;
        }

        /* Стили для кнопки редактирования в info-grid */
        .edit-button-info {
            padding: 10px 20px;
            background: linear-gradient(45deg, #ff6f61, #ff3b2f);
            border: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 5px;
        }

        .edit-button-info:hover {
            background: linear-gradient(45deg, #ff3b2f, #ff6f61);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #0d0d0d;
            color: white;
            flex-shrink: 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        footer .footer-content {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 800px;
            margin-bottom: 20px;
        }

        footer .column {
            flex: 1;
            margin: 0 10px;
        }

        footer .column h3 {
            margin-top: 0;
            color: #ff6f61;
        }

        footer .social-links a {
            text-decoration: none;
            color: white;
            display: block;
            margin: 5px 0;
            transition: color 0.3s ease;
        }

        footer .social-links a:hover {
            color: #ff6f61;
        }

        footer .footer-line {
            width: 100%;
            border-top: 1px solid #444;
            margin: 20px 0;
        }

        footer .copyright {
            text-align: center;
            width: 100%;
            color: #888;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                padding: 10px;
            }
            
            header .logo {
                margin-bottom: 10px;
            }
            
            header .nav-center {
                margin: 10px 0;
                width: 100%;
                justify-content: center;
            }
            
            header .nav-right {
                width: 100%;
                justify-content: center;
                margin-top: 10px;
            }
            
            .container {
                padding: 10px;
                margin: 10px;
                width: calc(100% - 20px);
            }
            
            .profile-grid {
                grid-template-columns: 1fr;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            footer .footer-content {
                flex-direction: column;
            }
            
            footer .column {
                margin-bottom: 20px;
            }

            .profile-avatar {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }

            .profile-name {
                font-size: 1.5rem;
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
            <div class="user-menu">
                <div class="user-name"><?php echo htmlspecialchars($user['username']); ?></div>
                <div class="user-dropdown">
                    <a href="profile.php">Профиль</a>
                    <a href="logout.php">Выйти</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <a href="index.php" class="back-link">← Назад к главной</a>
        
        <div class="profile-grid">
            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-avatar">
                    <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                </div>
                <h2 class="profile-name"><?php echo htmlspecialchars($user['username']); ?></h2>
                <!-- Убираем кнопку отсюда, так как она теперь будет в info-grid -->
            </div>

            <!-- Profile Information -->
            <div class="profile-info">
                <h2>Основная информация</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Имя пользователя:</span>
                        <div class="info-value"><?php echo htmlspecialchars($user['username']); ?></div>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
                    </div>
                    <div class="info-item">
                        <span class="info-label">ID пользователя:</span>
                        <div class="info-value">#<?php echo htmlspecialchars($user['id']); ?></div>
                    </div>
                    <!-- Заменяем поле "Дата регистрации" на кнопку "Редактировать профиль" -->
                    <div class="info-item">
                        <span class="info-label">Действия:</span>
                        <a href="edit-profile.php" class="edit-button-info">Редактировать профиль</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="column">
                <h3>Основные разделы</h3>
                <div class="social-links">
                    <a href="#">Обновления</a>
                    <a href="#">Новости</a>
                    <a href="#">Обзор</a>
                </div>
            </div>
            <div class="column">
                <h3>Наши социальные сети:</h3>
                <div class="social-links">
                    <a href="#">Facebook</a>
                    <a href="#">Twitter</a>
                    <a href="#">Instagram</a>
                </div>
            </div>
        </div>
        <div class="footer-line"></div>
        <div class="copyright">
            <p>GameUP, 2024</p>
        </div>
    </footer>
</body>
</html>