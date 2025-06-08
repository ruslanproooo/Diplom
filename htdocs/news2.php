<?php
require_once 'config/file_auth.php';
$auth = new FileAuth();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameUP - Новости CS2</title>
    <style>
        * {
            box-sizing: border-box;
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
        }
        
        /* Стили для имени пользователя */
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
            flex-wrap: wrap;
        }
        
        header .logo {
            font-size: clamp(20px, 4vw, 24px);
            font-weight: bold;
            color: #ff6f61;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            flex-shrink: 0;
        }
        
        header .logo a {
            text-decoration: none;
            color: #ff6f61;
        }
        
        header .nav-center {
            display: flex;
            gap: 20px;
            position: relative;
            flex: 1;
            justify-content: center;
        }
        
        header .nav-center a {
            text-decoration: none;
            color: #ffffff;
            position: relative;
        }
        
        header .nav-right {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
        }
        
        header .nav-right a {
            text-decoration: none;
            color: #000000;
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
        
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #262626;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            width: calc(100% - 40px);
            border-radius: 8px;
        }
        
        .news-article {
            margin-bottom: 40px;
        }
        
        .news-header {
            margin-bottom: 30px;
            text-align: center;
        }
        
        .news-header h1 {
            color: #ff6f61;
            font-size: clamp(24px, 5vw, 32px);
            margin-bottom: 10px;
        }
        
        .news-meta {
            color: #888;
            font-size: 16px;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .news-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        
        .news-content {
            line-height: 1.6;
            font-size: 16px;
        }
        
        .news-content p {
            margin-bottom: 20px;
        }
        
        .news-content h2, .news-content h3 {
            color: #ff6f61;
            margin: 30px 0 15px;
        }
        
        .news-content ul, .news-content ol {
            margin-bottom: 20px;
            padding-left: 30px;
        }
        
        .news-content li {
            margin-bottom: 8px;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 30px;
            color: #ff6f61;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: #ff3b2f;
            text-decoration: underline;
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
                gap: 10px;
                padding: 15px;
            }
            
            header .nav-center {
                order: 2;
                width: 100%;
                justify-content: center;
            }
            
            header .nav-right {
                order: 3;
                width: 100%;
                justify-content: center;
            }
            
            .container {
                margin: 10px auto;
                padding: 15px;
                width: calc(100% - 20px);
            }
            
            .news-meta {
                flex-direction: column;
                gap: 5px;
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
    <div class="container">
        <article class="news-article">
            <div class="news-header">
                <h1>Обновление CS2: Новые карты и исправления</h1>
                <div class="news-meta">
                    <span>15 марта 2024</span>
                    <span>Автор: Иван Петров</span>
                    <span>Категория: Counter-Strike 2</span>
                </div>
                <img src="https://image-proxy.bo3.gg/uploads/news/55370/title_image/webp-3327cfe4accd5e00bfe53f13b9872e00.webp.webp?w=1248&h=624" alt="CS2 обновление" class="news-image">
            </div>
            
            <div class="news-content">
                <p>Valve выпустила крупное обновление для Counter-Strike 2, которое принесло игрокам множество изменений и улучшений. Это первое значительное обновление с момента релиза игры.</p>
                
                <h2>Новые карты</h2>
                <p>В обновлении появились две новые карты:</p>
                <ul>
                    <li><strong>Mirage 2.0</strong> - полностью переработанная версия классической карты с улучшенной графикой и оптимизацией</li>
                    <li><strong>Arctic</strong> - абсолютно новая карта, действие которой происходит на заснеженной военной базе</li>
                </ul>
                <p>Обе карты уже доступны в соревновательных и обычных режимах игры.</p>
                
                <h2>Исправления и улучшения</h2>
                <p>Разработчики устранили множество проблем, о которых сообщали игроки:</p>
                <ul>
                    <li>Исправлены ошибки с отображением дыма и его взаимодействием с гранатами</li>
                    <li>Улучшена система регистрации попаданий</li>
                    <li>Оптимизирована работа серверов, что уменьшило задержки</li>
                    <li>Исправлены баги с некоторыми скинами оружия</li>
                </ul>
                
                <h2>Баланс оружия</h2>
                <p>В обновлении также были внесены изменения в баланс оружия:</p>
                <ul>
                    <li>Незначительно уменьшена точность FAMAS и Galil AR</li>
                    <li>Увеличена скорость перезарядки Desert Eagle</li>
                    <li>Исправлены параметры разброса у MP5</li>
                </ul>
                
                <h2>Что дальше?</h2>
                <p>По словам разработчиков, в ближайшие месяцы стоит ожидать:</p>
                <ul>
                    <li>Добавление новых режимов игры</li>
                    <li>Интеграцию с Steam Workshop</li>
                    <li>Улучшение античита</li>
                    <li>Дополнительные косметические предметы</li>
                </ul>
                
                <p>Обновление уже доступно для загрузки через Steam. Размер патча составляет около 2.4 ГБ.</p>
                
                <a href="index.php" class="back-link">← Вернуться к списку новостей</a>
            </div>
        </article>
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
