<?php
require_once 'config/file_auth.php';
$auth = new FileAuth();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameUP - Обзор PUBG</title>
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
        .game-review {
            margin-bottom: 40px;
        }
        .review-header {
            margin-bottom: 30px;
            text-align: center;
        }
        .review-header h1 {
            color: #ff6f61;
            font-size: clamp(24px, 6vw, 32px);
            margin-bottom: 10px;
        }
        .game-meta {
            color: #888;
            font-size: clamp(14px, 3vw, 16px);
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .game-cover {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .review-content {
            line-height: 1.6;
            font-size: clamp(14px, 3vw, 16px);
        }
        .review-content p {
            margin-bottom: 20px;
        }
        .review-content h2 {
            color: #ff6f61;
            margin: 30px 0 15px;
            border-bottom: 1px solid #444;
            padding-bottom: 5px;
            font-size: clamp(20px, 4vw, 24px);
        }
        .review-content h3 {
            color: #ff6f61;
            margin: 25px 0 10px;
            font-size: clamp(18px, 3.5vw, 20px);
        }
        .review-content ul, .review-content ol {
            margin-bottom: 20px;
            padding-left: 30px;
        }
        .review-content li {
            margin-bottom: 8px;
        }
        .rating {
            background-color: #333;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .rating-score {
            font-size: clamp(36px, 8vw, 48px);
            font-weight: bold;
            color: #ff6f61;
            min-width: 100px;
            text-align: center;
        }
        .rating-criteria {
            flex-grow: 1;
            min-width: 200px;
        }
        .criteria-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .criteria-name {
            color: #ddd;
        }
        .criteria-value {
            color: #ff6f61;
            font-weight: bold;
        }
        .pros-cons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .pros, .cons {
            padding: 15px;
            border-radius: 8px;
        }
        .pros {
            background-color: #1a3a1a;
        }
        .cons {
            background-color: #3a1a1a;
        }
        .pros h3, .cons h3 {
            margin-top: 0;
            text-align: center;
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
            flex-wrap: wrap;
            gap: 20px;
        }
        footer .column {
            flex: 1;
            margin: 0 10px;
            min-width: 200px;
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

        /* Адаптивность для мобильных устройств */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 10px;
            }
            
            header .nav-center {
                order: 3;
                width: 100%;
                justify-content: center;
                gap: 10px;
            }
            
            .dropdown-content {
                position: fixed;
                left: 50%;
                transform: translateX(-50%);
                width: 90vw;
                max-width: 300px;
            }
            
            .container {
                margin: 10px auto;
                padding: 15px;
                width: calc(100% - 20px);
            }
            
            .rating {
                flex-direction: column;
                text-align: center;
            }
            
            .pros-cons {
                grid-template-columns: 1fr;
            }
            
            footer .footer-content {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            header {
                padding: 10px;
            }
            
            header .nav-center {
                gap: 5px;
            }
            
            .dropdown-content a {
                padding: 10px 12px;
                font-size: 14px;
            }
            
            .container {
                padding: 10px;
            }
            
            .game-meta {
                flex-direction: column;
                gap: 5px;
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
        <article class="game-review">
            <div class="review-header">
                <h1>Обзор PUBG</h1>
                <div class="game-meta">
                    <span>Жанр: Battle Royale, Shooter</span>
                    <span>Разработчик: PUBG Corporation</span>
                    <span>Дата выхода: 20 декабря 2017</span>
                </div>
                <img src="https://cdn.akamai.steamstatic.com/steam/apps/578080/capsule_616x353.jpg?t=1705990495" alt="PUBG" class="game-cover">
            </div>
            
            <div class="review-content">
                <p>PUBG (PlayerUnknown's Battlegrounds) — это игра в жанре королевской битвы, которая задала стандарты для всего жанра. Игроки сражаются на огромной карте, чтобы стать последним выжившим.</p>
                
                <h2>Геймплей</h2>
                <p>PUBG предлагает реалистичный подход к жанру battle royale с акцентом на тактику и стратегию. Ключевые особенности:</p>
                
                <div class="pros-cons">
                    <div class="pros">
                        <h3>Достоинства</h3>
                        <ul>
                            <li>Реалистичная баллистика и физика</li>
                            <li>Большие и разнообразные карты</li>
                            <li>Глубокая тактическая составляющая</li>
                            <li>Регулярные обновления и новые режимы</li>
                        </ul>
                    </div>
                    <div class="cons">
                        <h3>Недостатки</h3>
                        <ul>
                            <li>Высокий порог входа для новичков</li>
                            <li>Проблемы с балансом некоторых видов оружия</li>
                            <li>Наличие читеров в некоторых матчах</li>
                        </ul>
                    </div>
                </div>
                
                <h2>Основные аспекты игры</h2>
                <h3>1. Боевая система</h3>
                <p>PUBG отличается реалистичной механикой стрельбы:</p>
                <ul>
                    <li><strong>Баллистика</strong> - учитывается падение пули и её скорость</li>
                    <li><strong>Разнообразие оружия</strong> - более 40 видов оружия с разными характеристиками</li>
                    <li><strong>Система укрытий</strong> - важно использовать окружающую среду для защиты</li>
                    <li><strong>Здоровье и броня</strong> - система лечения и бронежилетов</li>
                </ul>
                
                <h3>2. Карты и локации</h3>
                <p>Игра предлагает несколько уникальных карт:</p>
                <ul>
                    <li>Erangel - классическая карта с разнообразным ландшафтом</li>
                    <li>Miramar - пустынная карта с открытыми пространствами</li>
                    <li>Sanhok - компактная карта с густой растительностью</li>
                    <li>Vikendi - снежная карта с уникальной механикой следов</li>
                    <li>Karakin - небольшая карта с разрушаемыми стенами</li>
                </ul>
                
                <h3>3. Режимы игры</h3>
                <p>PUBG предлагает различные варианты игры:</p>
                <ul>
                    <li>Стандартная королевская битва (соло, дуо, сквад)</li>
                    <li>Аркадные режимы (TDM, Zombie и др.)</li>
                    <li>Сезонные события с уникальными правилами</li>
                    <li>Ранговые матчи для соревновательной игры</li>
                </ul>
                
                <h2>Особенности обновлений</h2>
                <p>Разработчики постоянно развивают игру:</p>
                <ul>
                    <li>Новые карты и локации</li>
                    <li>Новые виды оружия и транспортных средств</li>
                    <li>Оптимизация производительности</li>
                    <li>Система анти-чита</li>
                    <li>Косметические предметы и скины</li>
                </ul>
                
                <h2>Оценка</h2>
                <div class="rating">
                    <div class="rating-score">8.5</div>
                    <div class="rating-criteria">
                        <div class="criteria-item">
                            <span class="criteria-name">Геймплей</span>
                            <span class="criteria-value">9/10</span>
                        </div>
                        <div class="criteria-item">
                            <span class="criteria-name">Графика</span>
                            <span class="criteria-value">8/10</span>
                        </div>
                        <div class="criteria-item">
                            <span class="criteria-name">Оптимизация</span>
                            <span class="criteria-value">7/10</span>
                        </div>
                        <div class="criteria-item">
                            <span class="criteria-name">Поддержка</span>
                            <span class="criteria-value">8/10</span>
                        </div>
                    </div>
                </div>
                
                <h2>Заключение</h2>
                <p>PUBG остается одной из самых популярных игр в жанре battle royale благодаря своей реалистичной механике и глубине геймплея. Игра требует от игроков не только хорошей стрельбы, но и тактического мышления, умения работать в команде и адаптироваться к изменяющимся условиям на карте.</p>
                
                <p>Рекомендуется любителям тактических шутеров и реалистичных боевых систем.</p>
                
                <a href="index.php" class="back-link">← На главную</a>
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
            <p>GameUP, 2021</p>
        </div>
    </footer>
</body>
</html>