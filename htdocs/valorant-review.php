<?php
require_once 'config/file_auth.php';
$auth = new FileAuth();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameUP - Обзор Valorant</title>
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
                <h1>Обзор Valorant</h1>
                <div class="game-meta">
                    <span>Жанр: Тактический шутер</span>
                    <span>Разработчик: Riot Games</span>
                    <span>Дата выхода: 2 июня 2020</span>
                </div>
                <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/blt158572ec37653cf3/5eb26f54402b8b4d13a56656/Valorant_2020_KeyArt_Vertical.jpg" alt="Valorant" class="game-cover">
            </div>
            
            <div class="review-content">
                <p>Valorant — это тактический шутер от первого лица, сочетающий в себе элементы классических шутеров и уникальные способности персонажей. Игра разработана Riot Games и быстро завоевала популярность благодаря своей динамичности и стратегической глубине.</p>
                
                <h2>Геймплей</h2>
                <p>Valorant предлагает 5v5 матчи, где игроки делятся на атакующих и защитников. Ключевые особенности:</p>
                
                <div class="pros-cons">
                    <div class="pros">
                        <h3>Достоинства</h3>
                        <ul>
                            <li>Уникальные агенты с различными способностями</li>
                            <li>Высокая точность стрельбы и тактическая глубина</li>
                            <li>Регулярные обновления и балансировка</li>
                            <li>Хорошая оптимизация и поддержка</li>
                        </ul>
                    </div>
                    <div class="cons">
                        <h3>Недостатки</h3>
                        <ul>
                            <li>Высокий порог входа для новичков</li>
                            <li>Необходимость хорошего знания карт</li>
                            <li>Зависимость от командной игры</li>
                        </ul>
                    </div>
                </div>
                
                <h2>Основные аспекты игры</h2>
                <h3>1. Агенты</h3>
                <p>Каждый агент обладает уникальными способностями:</p>
                <ul>
                    <li><strong>Дуэлянты</strong> - специализируются на атаке (Jett, Phoenix)</li>
                    <li><strong>Контроллеры</strong> - управляют полем боя (Brimstone, Viper)</li>
                    <li><strong>Стражи</strong> - защищают союзников (Sage, Killjoy)</li>
                    <li><strong>Разведчики</strong> - собирают информацию (Sova, Cypher)</li>
                </ul>
                
                <h3>2. Оружие и экономика</h3>
                <p>Valorant предлагает разнообразное оружие и систему экономики:</p>
                <ul>
                    <li>Пистолеты, SMG, винтовки, снайперские винтовки и тяжелое оружие</li>
                    <li>Необходимость управлять кредитами для покупки оружия и способностей</li>
                    <li>Различные скины для оружия, доступные в магазине</li>
                </ul>
                
                <h3>3. Карты и режимы</h3>
                <p>Игра предлагает несколько карт и режимов:</p>
                <ul>
                    <li>Стандартный режим (Spike Defuse)</li>
                    <li>Соревновательный режим (Ranked)</li>
                    <li>Режим Deathmatch для тренировки</li>
                    <li>Специальные временные режимы</li>
                </ul>
                
                <h2>Особенности обновлений</h2>
                <p>Riot Games регулярно добавляет новый контент:</p>
                <ul>
                    <li>Новые агенты с уникальными способностями</li>
                    <li>Дополнительные карты и режимы</li>
                    <li>Балансировка оружия и способностей</li>
                    <li>Сезонные события и боевые пропуски</li>
                </ul>
                
                <h2>Оценка</h2>
                <div class="rating">
                    <div class="rating-score">9.0</div>
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
                            <span class="criteria-name">Сообщество</span>
                            <span class="criteria-value">7/10</span>
                        </div>
                        <div class="criteria-item">
                            <span class="criteria-name">Поддержка</span>
                            <span class="criteria-value">10/10</span>
                        </div>
                    </div>
                </div>
                
                <h2>Заключение</h2>
                <p>Valorant — это свежий взгляд на жанр тактических шутеров, предлагающий идеальный баланс между навыками стрельбы и стратегическим мышлением. Игра подойдет как любителям классических шутеров, так и тем, кто ищет новые тактические возможности.</p>
                
                <p>Рекомендуется игрокам, готовым к командной игре и постоянному совершенствованию своих навыков.</p>
                
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