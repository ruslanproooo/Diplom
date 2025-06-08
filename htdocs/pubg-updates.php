<?php
require_once 'config/file_auth.php';
$auth = new FileAuth();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameUP - Последние обновления PUBG</title>
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
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #262626;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            width: calc(100% - 40px);
            border-radius: 8px;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .page-header h1 {
            color: #ff6f61;
            font-size: clamp(28px, 6vw, 36px);
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
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .update-preview-title {
            color: #ff6f61;
            font-size: clamp(18px, 4vw, 22px);
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
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .update-detail-title {
            color: #ff6f61;
            font-size: clamp(22px, 5vw, 28px);
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
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
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
            <h1>Последние обновления PUBG</h1>
            <p>Последние 5 обновлений игры с подробным описанием изменений</p>
        </div>

        <div class="updates-list">
            <!-- Обновление 1 (самое новое) -->
            <div class="update-preview" onclick="showUpdateDetail('update1')">
                <div class="update-preview-header">
                    <h2 class="update-preview-title">Обновление 27.2 - "Новые горизонты"</h2>
                    <span class="update-preview-date">24 мая 2024</span>
                </div>
                <div class="update-preview-content">
                    <p>Новая карта Rondo получает масштабное обновление с изменением ландшафта и новыми точками интереса.</p>
                </div>
                <div class="update-preview-images">
                    <img src="/placeholder.svg?height=200&width=300" alt="Обновленная карта Rondo">
                    <img src="/placeholder.svg?height=200&width=300" alt="Новые точки интереса">
                </div>
                <a class="read-more-btn">Подробнее →</a>
            </div>

            <div id="update1" class="update-detail">
                <div class="update-detail-header">
                    <h2 class="update-detail-title">Обновление 27.2 - "Новые горизонты"</h2>
                    <span class="update-detail-date">24 мая 2024</span>
                </div>
                <div class="update-detail-content">
                    <p>Это обновление полностью преображает карту Rondo, добавляя новые локации и изменяя существующие.</p>
                    <p>Основные изменения включают новый городской район, переработанные сельские зоны и уникальные интерактивные элементы.</p>
                </div>
                <div class="update-detail-images">
                    <img src="/placeholder.svg?height=250&width=400" alt="Обновленная карта Rondo">
                    <img src="/placeholder.svg?height=250&width=400" alt="Новые точки интереса">
                    <img src="/placeholder.svg?height=250&width=400" alt="Интерактивные элементы">
                </div>
                <div class="update-detail-features">
                    <h3>Основные изменения:</h3>
                    <ul>
                        <li>Новый городской район "Небесные сады"</li>
                        <li>5 новых точек интереса на карте Rondo</li>
                        <li>Интерактивные лифты и мосты</li>
                        <li>Новая система погоды с динамическими изменениями</li>
                        <li>Оптимизация производительности для всех платформ</li>
                    </ul>
                </div>
                <a href="#" class="back-to-list" onclick="hideUpdateDetail('update1'); return false;">← Назад к списку</a>
            </div>

            <!-- Остальные обновления... -->
            <div class="update-preview" onclick="showUpdateDetail('update2')">
                <div class="update-preview-header">
                    <h2 class="update-preview-title">Тактическое снаряжение</h2>
                    <span class="update-preview-date">10 мая 2024</span>
                </div>
                <div class="update-preview-content">
                    <p>Добавлены новые виды тактического снаряжения, изменяющие подход к бою.</p>
                </div>
                <div class="update-preview-images">
                    <img src="/placeholder.svg?height=200&width=300" alt="Новое тактическое снаряжение">
                    <img src="/placeholder.svg?height=200&width=300" alt="Изменения геймплея">
                </div>
                <a class="read-more-btn">Подробнее →</a>
            </div>

            <div id="update2" class="update-detail">
                <div class="update-detail-header">
                    <h2 class="update-detail-title">Тактическое снаряжение</h2>
                    <span class="update-detail-date">10 мая 2024</span>
                </div>
                <div class="update-detail-content">
                    <p>Это обновление добавляет в игру новые виды тактического снаряжения, которые можно найти по всей карте.</p>
                    <p>Каждый предмет предлагает уникальные возможности для стратегического планирования и командной игры.</p>
                </div>
                <div class="update-detail-images">
                    <img src="/placeholder.svg?height=250&width=400" alt="Новое тактическое снаряжение">
                    <img src="/placeholder.svg?height=250&width=400" alt="Изменения геймплея">
                    <img src="/placeholder.svg?height=250&width=400" alt="Снаряжение в действии">
                </div>
                <div class="update-detail-features">
                    <h3>Новое снаряжение:</h3>
                    <ul>
                        <li>Дрон-разведчик - для обнаружения врагов</li>
                        <li>Тактический щит - переносное укрытие</li>
                        <li>ЭМП граната - временно отключает электронику</li>
                        <li>Аптечка быстрого реагирования - мгновенное лечение</li>
                        <li>Камуфляжная сеть - временная маскировка</li>
                    </ul>
                </div>
                <a href="#" class="back-to-list" onclick="hideUpdateDetail('update2'); return false;">← Назад к списку</a>
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
