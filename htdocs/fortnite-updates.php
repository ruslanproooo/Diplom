<?php
require_once 'config/file_auth.php';
$auth = new FileAuth();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameUP - Последние обновления Fortnite</title>
    <style>
        * {
    box-sizing: border-box;
}

body {
    overflow-x: hidden;
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
        .container {
            width: calc(100% - 40px);
    max-width: 1200px;
    box-sizing: border-box;
            margin: 20px auto;
            padding: 20px;
            background-color: #262626;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            border-radius: 8px;
        }
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .page-header h1 {
            color: #ff6f61;
            font-size: 36px;
        }
        .updates-list {
            display: grid;
            gap: 25px;
        }
        .update-preview {
            background-color: #333;
            border-radius: 8px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .update-preview:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        .update-preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .update-preview-title {
            color: #ff6f61;
            font-size: 22px;
            margin: 0;
        }
        .update-preview-date {
            color: #888;
            font-size: 16px;
        }
        .update-preview-content {
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .update-preview-images {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 15px 0;
        }
        .update-preview-images img {
            width: 100%;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .read-more-btn {
            color: #ff6f61;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
        }
        .update-detail {
            display: none;
            background-color: #333;
            border-radius: 8px;
            padding: 30px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .update-detail.active {
            display: block;
        }
        .update-detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #444;
        }
        .update-detail-title {
            color: #ff6f61;
            font-size: 28px;
            margin: 0;
        }
        .update-detail-date {
            color: #888;
            font-size: 18px;
        }
        .update-detail-content {
            line-height: 1.7;
            margin-bottom: 25px;
        }
        .update-detail-images {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin: 25px 0;
        }
        .update-detail-images img {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }
        .update-detail-images img:hover {
            transform: scale(1.03);
        }
        .update-detail-features {
            margin-top: 30px;
        }
        .update-detail-features h3 {
            color: #ff6f61;
            font-size: 22px;
            margin-bottom: 15px;
            border-bottom: 1px solid #444;
            padding-bottom: 8px;
        }
        .update-detail-features ul {
            padding-left: 25px;
        }
        .update-detail-features li {
            margin-bottom: 12px;
            line-height: 1.6;
        }
        .back-to-list {
            display: inline-block;
            margin-top: 20px;
            color: #ff6f61;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 4px;
            background-color: #444;
            transition: all 0.3s ease;
        }
        .back-to-list:hover {
            background-color: #555;
            text-decoration: none;
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
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #ff6f61;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
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
    
    .container {
        margin: 10px auto;
        padding: 15px;
        width: calc(100% - 20px);
    }
    
    .page-header h1 {
        font-size: clamp(24px, 5vw, 36px);
    }
    
    .update-preview-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .update-preview-images {
        grid-template-columns: 1fr;
    }
    
    .update-detail-images {
        grid-template-columns: 1fr;
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
        <a href="index.php" class="back-link">← Назад к главной</a>
        
        <div class="page-header">
            <h1>Последние обновления Fortnite</h1>
            <p>Последние 5 обновлений игры с подробным описанием изменений</p>
        </div>

        <div class="updates-list">
            <!-- Обновление 1 (самое новое) -->
            <div class="update-preview" onclick="showUpdateDetail('update1')">
                <div class="update-preview-header">
                    <h2 class="update-preview-title">Глава 5 Сезон 3: Безумный мир</h2>
                    <span class="update-preview-date">24 мая 2024</span>
                </div>
                <div class="update-preview-content">
                    <p>Новый сезон с тематикой безумного Макса: пустынные ландшафты, автомобильные бои и новые виды оружия.</p>
                </div>
                <div class="update-preview-images">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-chapter5season3-1920x1080-1920x1080-6d7e9a1b6e7d.jpg" alt="Новый сезон Fortnite">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-chapter5season3-car-1920x1080-1920x1080-2b3a3a3b3c3d.jpg" alt="Автомобильные бои">
                </div>
                <a class="read-more-btn">Подробнее →</a>
            </div>

            <div id="update1" class="update-detail">
                <div class="update-detail-header">
                    <h2 class="update-detail-title">Глава 5 Сезон 3: Безумный мир</h2>
                    <span class="update-detail-date">24 мая 2024</span>
                </div>
                <div class="update-detail-content">
                    <p>Новый сезон полностью меняет игровой процесс, добавляя автомобильные бои и пустынные ландшафты.</p>
                    <p>Основные изменения включают новую систему модификации транспортных средств, 5 новых локаций в стиле постапокалипсиса и совершенно новую механику песчаных бурь.</p>
                </div>
                <div class="update-detail-images">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-chapter5season3-1920x1080-1920x1080-6d7e9a1b6e7d.jpg" alt="Новый сезон Fortnite">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-chapter5season3-car-1920x1080-1920x1080-2b3a3a3b3c3d.jpg" alt="Автомобильные бои">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-chapter5season3-map-1920x1080-1920x1080-4e5f6a7b8c9d.jpg" alt="Новая карта">
                </div>
                <div class="update-detail-features">
                    <h3>Основные изменения:</h3>
                    <ul>
                        <li>Новая карта с пустынными биомами</li>
                        <li>Система модификации и улучшения транспортных средств</li>
                        <li>10 новых видов оружия в стиле постапокалипсиса</li>
                        <li>Механика песчаных бурь, ограничивающих видимость</li>
                        <li>Новые скины персонажей в стиле "Безумного Макса"</li>
                    </ul>
                </div>
                <a href="#" class="back-to-list" onclick="hideUpdateDetail('update1'); return false;">← Назад к списку</a>
            </div>

            <!-- Обновление 2 -->
            <div class="update-preview" onclick="showUpdateDetail('update2')">
                <div class="update-preview-header">
                    <h2 class="update-preview-title">Обновление "Мифическое оружие"</h2>
                    <span class="update-preview-date">15 апреля 2024</span>
                </div>
                <div class="update-preview-content">
                    <p>Добавлено мифическое оружие с уникальными способностями и улучшенная система крафта.</p>
                </div>
                <div class="update-preview-images">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-mythic-weapons-1920x1080-1920x1080-1a2b3c4d5e6f.jpg" alt="Мифическое оружие">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-crafting-1920x1080-1920x1080-7g8h9i0j1k2.jpg" alt="Система крафта">
                </div>
                <a class="read-more-btn">Подробнее →</a>
            </div>

            <div id="update2" class="update-detail">
                <div class="update-detail-header">
                    <h2 class="update-detail-title">Обновление "Мифическое оружие"</h2>
                    <span class="update-detail-date">15 апреля 2024</span>
                </div>
                <div class="update-detail-content">
                    <p>Это обновление добавляет в игру совершенно новый класс оружия с уникальными способностями.</p>
                    <p>Мифическое оружие можно получить только выполнив специальные квесты или победив мощных боссов на карте.</p>
                </div>
                <div class="update-detail-images">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-mythic-weapons-1920x1080-1920x1080-1a2b3c4d5e6f.jpg" alt="Мифическое оружие">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-crafting-1920x1080-1920x1080-7g8h9i0j1k2.jpg" alt="Система крафта">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-bosses-1920x1080-1920x1080-3l4m5n6o7p8.jpg" alt="Новые боссы">
                </div>
                <div class="update-detail-features">
                    <h3>Полный список изменений:</h3>
                    <ul>
                        <li>5 видов мифического оружия с уникальными способностями</li>
                        <li>Улучшенная система крафта с новыми рецептами</li>
                        <li>3 новых босса, охраняющих мифическое оружие</li>
                        <li>Новые квесты для получения редких материалов</li>
                        <li>Балансные изменения для обычного оружия</li>
                    </ul>
                </div>
                <a href="#" class="back-to-list" onclick="hideUpdateDetail('update2'); return false;">← Назад к списку</a>
            </div>

            <!-- Обновление 3 -->
            <div class="update-preview" onclick="showUpdateDetail('update3')">
                <div class="update-preview-header">
                    <h2 class="update-preview-title">Событие "Королевская битва богов"</h2>
                    <span class="update-preview-date">3 апреля 2024</span>
                </div>
                <div class="update-preview-content">
                    <p>Ограниченное событие с мифологическими богами и новыми способностями.</p>
                </div>
                <div class="update-preview-images">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-gods-event-1920x1080-1920x1080-9q0w1e2r3t4.jpg" alt="Событие богов">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-gods-abilities-1920x1080-1920x1080-5y6u7i8o9p0.jpg" alt="Новые способности">
                </div>
                <a class="read-more-btn">Подробнее →</a>
            </div>

            <div id="update3" class="update-detail">
                <div class="update-detail-header">
                    <h2 class="update-detail-title">Событие "Королевская битва богов"</h2>
                    <span class="update-detail-date">3 апреля 2024</span>
                </div>
                <div class="update-detail-content">
                    <p>Ограниченное событие, посвященное мифологическим богам из разных культур.</p>
                    <p>Игроки могут выбрать сторону одного из богов и получить уникальные способности, соответствующие их стихии.</p>
                </div>
                <div class="update-detail-images">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-gods-event-1920x1080-1920x1080-9q0w1e2r3t4.jpg" alt="Событие богов">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-gods-abilities-1920x1080-1920x1080-5y6u7i8o9p0.jpg" alt="Новые способности">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-gods-map-1920x1080-1920x1080-1a2s3d4f5g6.jpg" alt="Изменения карты">
                </div>
                <div class="update-detail-features">
                    <h3>Новые возможности:</h3>
                    <ul>
                        <li>8 богов на выбор с уникальными способностями</li>
                        <li>Новые локации, связанные с мифологией</li>
                        <li>Система божественных благословений</li>
                        <li>Особые квесты для каждого бога</li>
                        <li>Новые скины в мифологическом стиле</li>
                    </ul>
                </div>
                <a href="#" class="back-to-list" onclick="hideUpdateDetail('update3'); return false;">← Назад к списку</a>
            </div>

            <!-- Обновление 4 -->
            <div class="update-preview" onclick="showUpdateDetail('update4')">
                <div class="update-preview-header">
                    <h2 class="update-preview-title">Творческий режим 2.0</h2>
                    <span class="update-preview-date">22 марта 2024</span>
                </div>
                <div class="update-preview-content">
                    <p>Масштабное обновление творческого режима с новыми инструментами и возможностями.</p>
                </div>
                <div class="update-preview-images">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-creative-2-0-1920x1080-1920x1080-7h8j9k0l1z2.jpg" alt="Творческий режим">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-creative-tools-1920x1080-1920x1080-3x4c5v6b7n8.jpg" alt="Новые инструменты">
                </div>
                <a class="read-more-btn">Подробнее →</a>
            </div>

            <div id="update4" class="update-detail">
                <div class="update-detail-header">
                    <h2 class="update-detail-title">Творческий режим 2.0</h2>
                    <span class="update-detail-date">22 марта 2024</span>
                </div>
                <div class="update-detail-content">
                    <p>Самое масштабное обновление творческого режима за всю историю Fortnite.</p>
                    <p>Добавлены новые инструменты для создания собственных игр и режимов, а также улучшена производительность.</p>
                </div>
                <div class="update-detail-images">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-creative-2-0-1920x1080-1920x1080-7h8j9k0l1z2.jpg" alt="Творческий режим">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-creative-tools-1920x1080-1920x1080-3x4c5v6b7n8.jpg" alt="Новые инструменты">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-creative-assets-1920x1080-1920x1080-9m0n1b2v3c4.jpg" alt="Новые ассеты">
                </div>
                <div class="update-detail-features">
                    <h3>Основные изменения:</h3>
                    <ul>
                        <li>Новый визуальный скриптовый язык для создания механик</li>
                        <li>Более 1000 новых ассетов для строительства</li>
                        <li>Улучшенный интерфейс редактора</li>
                        <li>Новые шаблоны популярных игровых режимов</li>
                        <li>Система совместного редактирования в реальном времени</li>
                    </ul>
                </div>
                <a href="#" class="back-to-list" onclick="hideUpdateDetail('update4'); return false;">← Назад к списку</a>
            </div>

            <!-- Обновление 5 -->
            <div class="update-preview" onclick="showUpdateDetail('update5')">
                <div class="update-preview-header">
                    <h2 class="update-preview-title">Киберспортивный сезон</h2>
                    <span class="update-preview-date">10 марта 2024</span>
                </div>
                <div class="update-preview-content">
                    <p>Обновление для профессиональных игроков с новыми турнирными режимами и настройками.</p>
                </div>
                <div class="update-preview-images">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-esports-1920x1080-1920x1080-5d6f7g8h9j0.jpg" alt="Киберспорт">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-tournament-1920x1080-1920x1080-1k2l3m4n5b6.jpg" alt="Турниры">
                </div>
                <a class="read-more-btn">Подробнее →</a>
            </div>

            <div id="update5" class="update-detail">
                <div class="update-detail-header">
                    <h2 class="update-detail-title">Киберспортивный сезон</h2>
                    <span class="update-detail-date">10 марта 2024</span>
                </div>
                <div class="update-detail-content">
                    <p>Специальное обновление, направленное на улучшение киберспортивной составляющей Fortnite.</p>
                    <p>Добавлены новые турнирные режимы, улучшенная система наблюдения и аналитические инструменты.</p>
                </div>
                <div class="update-detail-images">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-esports-1920x1080-1920x1080-5d6f7g8h9j0.jpg" alt="Киберспорт">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-tournament-1920x1080-1920x1080-1k2l3m4n5b6.jpg" alt="Турниры">
                    <img src="https://cdn2.unrealengine.com/egs-fortnite-spectator-1920x1080-1920x1080-7v8c9x0z1a2.jpg" alt="Режим наблюдателя">
                </div>
                <div class="update-detail-features">
                    <h3>Новые возможности:</h3>
                    <ul>
                        <li>3 новых турнирных режима с разными настройками</li>
                        <li>Улучшенный режим наблюдателя с новыми камерами</li>
                        <li>Инструменты для анализа матчей в реальном времени</li>
                        <li>Новые HUD-элементы для зрителей</li>
                        <li>Турнирные пресеты для быстрой настройки</li>
                    </ul>
                </div>
                <a href="#" class="back-to-list" onclick="hideUpdateDetail('update5'); return false;">← Назад к списку</a>
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

    <script>
        function showUpdateDetail(id) {
            // Скрываем все детали обновлений
            document.querySelectorAll('.update-detail').forEach(el => {
                el.classList.remove('active');
            });
            
            // Показываем выбранное обновление
            document.getElementById(id).classList.add('active');
            
            // Прокручиваем к выбранному обновлению
            document.getElementById(id).scrollIntoView({ behavior: 'smooth' });
        }
        
        function hideUpdateDetail(id) {
            document.getElementById(id).classList.remove('active');
            document.querySelector('.updates-list').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
    </script>
</body>
</html>
