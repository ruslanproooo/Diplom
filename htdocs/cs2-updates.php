<?php
require_once 'config/file_auth.php';
$auth = new FileAuth();

// Функция для подключения к базе данных
function getDBConnection() {
    $host = 'localhost';
    $dbname = 'gameup_db';
    $username = 'root';
    $password = '';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        return null;
    }
}

// Функция для получения комментариев
function getComments($updateId) {
    try {
        $pdo = getDBConnection();
        if (!$pdo) return [];
        
        $stmt = $pdo->prepare("SELECT * FROM comments WHERE update_id = ? ORDER BY created_at DESC");
        $stmt->execute([$updateId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        return [];
    }
}

// Получаем комментарии для каждого обновления
$commentsUpdate1 = getComments('update1');
$commentsUpdate2 = getComments('update2');
$commentsUpdate3 = getComments('update3');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameUP - Последние обновления CS2</title>
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
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: 20px;
        }
        .update-preview:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        .update-preview-header {
            margin-bottom: 15px;
        }
        .update-preview-title {
            color: #ff6f61;
            font-size: 22px;
            margin: 0;
            margin-bottom: 8px;
        }
        .update-preview-date {
            color: #888;
            font-size: 16px;
            display: block;
            margin-bottom: 12px;
        }
        .update-preview-content {
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .update-preview-images {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .update-preview-images img {
            width: 100%;
            max-height: 150px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .update-preview-info {
            display: flex;
            flex-direction: column;
        }
        .update-preview-features {
            margin-top: 10px;
            padding-left: 20px;
        }
        .update-preview-features li {
            margin-bottom: 5px;
            font-size: 14px;
            color: #ccc;
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
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 25px 0;
        }
        .update-detail-images img {
            width: 100%;
            height: 180px;
            object-fit: cover;
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

        /* СТИЛИ ДЛЯ КОММЕНТАРИЕВ */
        .comments-section {
            margin-top: 40px;
            border-top: 1px solid #444;
            padding-top: 30px;
        }
        
        .comments-section h3 {
            color: #ff6f61;
            font-size: 22px;
            margin-bottom: 20px;
        }
        
        .comment-form {
            background-color: #2a2a2a;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .comment-form textarea {
            width: 100%;
            min-height: 100px;
            background-color: #333;
            border: 1px solid #444;
            border-radius: 4px;
            padding: 12px;
            color: #fff;
            font-size: 16px;
            margin-bottom: 15px;
            resize: vertical;
        }
        
        .comment-form textarea:focus {
            outline: none;
            border-color: #ff6f61;
            box-shadow: 0 0 0 2px rgba(255, 111, 97, 0.2);
        }
        
        .comment-submit {
            background: linear-gradient(45deg, #ff6f61, #ff3b2f);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .comment-submit:hover {
            background: linear-gradient(45deg, #ff3b2f, #ff6f61);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .comment-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .comments-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .comment {
            background-color: #2a2a2a;
            border-radius: 8px;
            padding: 20px;
            position: relative;
        }
        
        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .comment-author {
            font-weight: bold;
            color: #ff6f61;
        }
        
        .comment-date {
            color: #888;
            font-size: 14px;
        }
        
        .comment-content {
            line-height: 1.6;
        }
        
        .comment-actions {
            margin-top: 10px;
            display: flex;
            gap: 15px;
        }
        
        .comment-action {
            color: #888;
            font-size: 14px;
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .comment-action:hover {
            color: #ff6f61;
        }
        
        .no-comments {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 20px;
            background-color: #2a2a2a;
            border-radius: 8px;
        }

        .login-to-comment {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 20px;
            background-color: #2a2a2a;
            border-radius: 8px;
        }

        .login-to-comment a {
            color: #ff6f61;
            text-decoration: none;
        }

        .login-to-comment a:hover {
            text-decoration: underline;
        }

        /* Стили для тегов */
        .update-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
            margin-bottom: 15px;
        }
        
        .update-tag {
            background-color: #444;
            color: #ddd;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 12px;
            display: inline-block;
        }

        /* Стили для индикатора важности */
        .importance-indicator {
            display: inline-flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .importance-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .importance-high {
            background-color: #ff3b2f;
        }
        
        .importance-medium {
            background-color: #ffc107;
        }
        
        .importance-low {
            background-color: #4caf50;
        }
        
        .importance-text {
            font-size: 14px;
            color: #aaa;
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
            
            .update-preview {
                grid-template-columns: 1fr;
            }
            
            .update-preview-images {
                order: -1;
                flex-direction: row;
                overflow-x: auto;
                padding-bottom: 10px;
            }
            
            .update-preview-images img {
                min-width: 120px;
                max-width: 120px;
                height: 80px;
            }
            
            .update-detail-images {
                grid-template-columns: 1fr 1fr;
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
            <h1>Последние обновления Counter-Strike 2</h1>
            <p>Последние 5 обновлений игры с подробным описанием изменений</p>
        </div>

        <div class="updates-list">
            <!-- Обновление 1 (самое новое) -->
            <div class="update-preview">
                <div class="update-preview-images">
                    <img src="https://images.cybersport.ru/images/as-is/plain/65/6592f66e-8ec3-456a-98f1-5b0c0615a366.webp" alt="Новая операция">
                    <img src="https://cloud.cybershoke.net/img/maps/2/duels_anubis_1x1.jpg" alt="Водная механика">
                </div>
                <div class="update-preview-info">
                    <div class="importance-indicator">
                        <span class="importance-dot importance-high"></span>
                        <span class="importance-text">Важное обновление</span>
                    </div>
                    <div class="update-preview-header">
                        <h2 class="update-preview-title">Обновление "Операция Гидроудар"</h2>
                        <span class="update-preview-date">20 мая 2024</span>
                    </div>
                    <div class="update-tags">
                        <span class="update-tag">Новая операция</span>
                        <span class="update-tag">Водная механика</span>
                        <span class="update-tag">Новые карты</span>
                    </div>
                    <div class="update-preview-content">
                        <p>Крупнейшее обновление 2024 года, представляющее новую операцию с уникальными механиками и контентом. Основные изменения включают новую водную механику, которая влияет на передвижение и баллистику, а также 5 новых карт.</p>
                    </div>
                    <ul class="update-preview-features">
                        <li>50+ новых заданий с уникальными наградами</li>
                        <li>Новая коллекция из 15 скинов оружия</li>
                        <li>Улучшенная физика воды и взаимодействие с ней</li>
                    </ul>
                    <a class="read-more-btn" onclick="showUpdateDetail('update1'); return false;">Подробнее →</a>
                </div>
            </div>

            <div id="update1" class="update-detail">
                <div class="update-detail-header">
                    <h2 class="update-detail-title">Обновление "Операция Гидроудар"</h2>
                    <span class="update-detail-date">20 мая 2024</span>
                </div>
                <div class="update-tags">
                    <span class="update-tag">Новая операция</span>
                    <span class="update-tag">Водная механика</span>
                    <span class="update-tag">Новые карты</span>
                    <span class="update-tag">Новые скины</span>
                    <span class="update-tag">Физика воды</span>
                </div>
                <div class="update-detail-content">
                    <p>Крупнейшее обновление 2024 года, представляющее новую операцию с уникальными механиками и контентом.</p>
                    <p>Основные изменения включают новую водную механику, которая влияет на передвижение и баллистику, а также 5 новых карт, специально разработанных для этой операции.</p>
                    <p>Операция "Гидроудар" будет доступна в течение 16 недель и предложит игрокам более 50 уникальных заданий с наградами, включая эксклюзивные скины, наклейки и значки.</p>
                    <p>Разработчики также внедрили новую систему физики воды, которая реалистично влияет на передвижение игроков и баллистику оружия. Теперь пули будут замедляться в воде, а игроки смогут нырять и плавать на некоторых участках карт.</p>
                </div>
                <div class="update-detail-images">
                    <img src="https://images.cybersport.ru/images/as-is/plain/65/6592f66e-8ec3-456a-98f1-5b0c0615a366.webp" alt="Новая операция">
                    <img src="https://cloud.cybershoke.net/img/maps/2/duels_anubis_1x1.jpg" alt="Водная механика">
                    <img src="https://clan.cloudflare.steamstatic.com/images/3381077/f1a91d7a87158c2287a7bb95162d1df586d816b0.png" alt="Новые скины">
                </div>
                <div class="update-detail-features">
                    <h3>Основные изменения:</h3>
                    <ul>
                        <li>Новая операция с 50+ заданиями и наградами</li>
                        <li>5 новых карт с водной механикой: Aquarium, Waterfall, Submerged, Oasis и Tsunami</li>
                        <li>15 новых скинов оружия в стиле операции, включая редкие "Водный элемент" и "Глубинный хищник"</li>
                        <li>Улучшенная физика воды и взаимодействие с ней: замедление движения, влияние на баллистику</li>
                        <li>Новые звуки окружающей среды для водных карт: течение воды, капли, подводные звуки</li>
                        <li>Специальные анимации для движения в воде и нырянии</li>
                        <li>Новые тактические возможности: скрытное передвижение под водой, маскировка звуков шагов</li>
                        <li>Еженедельные испытания с дополнительными наградами</li>
                        <li>Новый соревновательный режим "Водный бой" с уникальными правилами</li>
                    </ul>
                </div>
                <div class="update-detail-features">
                    <h3>Технические улучшения:</h3>
                    <ul>
                        <li>Оптимизация производительности на картах с водой</li>
                        <li>Улучшенные визуальные эффекты для воды и брызг</li>
                        <li>Новые настройки графики для регулировки качества водных эффектов</li>
                        <li>Исправлено более 30 мелких багов из предыдущих версий</li>
                    </ul>
                </div>
                
                <!-- БЛОК КОММЕНТАРИЕВ -->
                <div class="comments-section">
                    <h3>Комментарии (<?php echo count($commentsUpdate1); ?>)</h3>
                    
                    <?php if ($auth->isLoggedIn()): ?>
                        <div class="comment-form">
                            <textarea placeholder="Напишите ваш комментарий..." id="commentText1"></textarea>
                            <button class="comment-submit" onclick="addComment('update1')">Отправить комментарий</button>
                        </div>
                    <?php else: ?>
                        <div class="login-to-comment">
                            <p>Чтобы оставить комментарий, необходимо <a href="Avtor.php">войти в систему</a></p>
                        </div>
                    <?php endif; ?>
                    
                    <div class="comments-list" id="commentsList1">
                        <?php if (empty($commentsUpdate1)): ?>
                            <div class="no-comments">Пока нет комментариев. Будьте первым!</div>
                        <?php else: ?>
                            <?php foreach ($commentsUpdate1 as $comment): ?>
                                <div class="comment">
                                    <div class="comment-header">
                                        <span class="comment-author"><?php echo htmlspecialchars($comment['username']); ?></span>
                                        <span class="comment-date"><?php echo date('d.m.Y, H:i', strtotime($comment['created_at'])); ?></span>
                                    </div>
                                    <div class="comment-content">
                                        <p><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></p>
                                    </div>
                                    <div class="comment-actions">
                                        <span class="comment-action">Ответить</span>
                                        <span class="comment-action">Лайк (<?php echo $comment['likes']; ?>)</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <a href="#" class="back-to-list" onclick="hideUpdateDetail('update1'); return false;">← Назад к списку</a>
            </div>

            <!-- Обновление 2 -->
            <div class="update-preview">
                <div class="update-preview-images">
                    <img src="https://image-proxy.bo3.gg/uploads/news/55370/title_image/webp-3327cfe4accd5e00bfe53f13b9872e00.webp.webp" alt="Новое оружие в CS2">
                    <img src="https://tradeit.gg/blog/wp-content/uploads/2023/07/CS2-Maps_-CS2-Map-Pool-958x575.webp" alt="Изменения карт">
                </div>
                <div class="update-preview-info">
                    <div class="importance-indicator">
                        <span class="importance-dot importance-medium"></span>
                        <span class="importance-text">Среднее обновление</span>
                    </div>
                    <div class="update-preview-header">
                        <h2 class="update-preview-title">Обновление "Точный удар"</h2>
                        <span class="update-preview-date">15 апреля 2024</span>
                    </div>
                    <div class="update-tags">
                        <span class="update-tag">Баланс оружия</span>
                        <span class="update-tag">Механика стрельбы</span>
                        <span class="update-tag">Исправления</span>
                    </div>
                    <div class="update-preview-content">
                        <p>Крупное обновление, посвященное балансу оружия и улучшению механик стрельбы. Полностью переработана система отдачи и разброса для всех типов оружия, что делает геймплей более предсказуемым для опытных игроков.</p>
                    </div>
                    <ul class="update-preview-features">
                        <li>Полный ребаланс всех типов оружия</li>
                        <li>Новая система отдачи и разброса</li>
                        <li>Исправлены баги с попаданием через стены</li>
                    </ul>
                    <a class="read-more-btn" onclick="showUpdateDetail('update2'); return false;">Подробнее →</a>
                </div>
            </div>

            <div id="update2" class="update-detail">
                <div class="update-detail-header">
                    <h2 class="update-detail-title">Обновление "Точный удар"</h2>
                    <span class="update-detail-date">15 апреля 2024</span>
                </div>
                <div class="update-tags">
                    <span class="update-tag">Баланс оружия</span>
                    <span class="update-tag">Механика стрельбы</span>
                    <span class="update-tag">Исправления</span>
                    <span class="update-tag">Анимации</span>
                    <span class="update-tag">Звуки</span>
                </div>
                <div class="update-detail-content">
                    <p>Это крупнейшее обновление за последние полгода, полностью перерабатывающее систему боя в CS2.</p>
                    <p>Основные цели обновления - сделать геймплей более предсказуемым для опытных игроков, сохранив при этом доступность для новичков.</p>
                    <p>Каждое оружие теперь имеет уникальный паттерн отдачи, который можно изучить и контролировать. Это повышает значимость навыка контроля оружия и делает соревновательный геймплей более стратегическим.</p>
                    <p>Также были исправлены многочисленные баги, связанные с попаданием через стены и другими проблемами баллистики, что делает игру более честной и сбалансированной.</p>
                </div>
                <div class="update-detail-images">
                    <img src="https://image-proxy.bo3.gg/uploads/news/55370/title_image/webp-3327cfe4accd5e00bfe53f13b9872e00.webp.webp" alt="Новое оружие в CS2">
                    <img src="https://tradeit.gg/blog/wp-content/uploads/2023/07/CS2-Maps_-CS2-Map-Pool-958x575.webp" alt="Изменения карт">
                    <img src="https://cdn.akamai.steamstatic.com/apps/csgo/images/csgo_react/stats/maps/screenshots/de_dust2.jpg" alt="Карта Dust2">
                </div>
                <div class="update-detail-features">
                    <h3>Полный список изменений:</h3>
                    <ul>
                        <li>Полный ребаланс всех типов оружия: изменены урон, скорострельность и точность</li>
                        <li>Новая система отдачи и разброса: каждое оружие имеет уникальный паттерн</li>
                        <li>Улучшенная анимация перезарядки для всех видов оружия</li>
                        <li>Исправлены баги с попаданием через стены на всех картах</li>
                        <li>Новая физика пуль: учитывается материал поверхности и дистанция</li>
                        <li>Обновленные звуки выстрелов с учетом окружающей среды</li>
                        <li>Улучшенная система хитбоксов для более точной регистрации попаданий</li>
                        <li>Новые визуальные эффекты для попаданий и рикошетов</li>
                        <li>Переработана система прицеливания для снайперских винтовок</li>
                        <li>Добавлены новые настройки чувствительности для разных типов оружия</li>
                    </ul>
                </div>
                <div class="update-detail-features">
                    <h3>Изменения по конкретным видам оружия:</h3>
                    <ul>
                        <li>AK-47: Уменьшен разброс при стрельбе очередями, увеличена отдача при стрельбе стоя</li>
                        <li>M4A4: Увеличена точность первых 5 выстрелов, уменьшен урон на дальних дистанциях</li>
                        <li>AWP: Увеличено время между выстрелами, улучшена точность без зума</li>
                        <li>Desert Eagle: Увеличен урон в голову, увеличена отдача</li>
                        <li>SMG: Общее увеличение точности при движении, уменьшение урона</li>
                    </ul>
                </div>
                
                <!-- БЛОК КОММЕНТАРИЕВ -->
                <div class="comments-section">
                    <h3>Комментарии (<?php echo count($commentsUpdate2); ?>)</h3>
                    
                    <?php if ($auth->isLoggedIn()): ?>
                        <div class="comment-form">
                            <textarea placeholder="Напишите ваш комментарий..." id="commentText2"></textarea>
                            <button class="comment-submit" onclick="addComment('update2')">Отправить комментарий</button>
                        </div>
                    <?php else: ?>
                        <div class="login-to-comment">
                            <p>Чтобы оставить комментарий, необходимо <a href="Avtor.php">войти в систему</a></p>
                        </div>
                    <?php endif; ?>
                    
                    <div class="comments-list" id="commentsList2">
                        <?php if (empty($commentsUpdate2)): ?>
                            <div class="no-comments">Пока нет комментариев. Будьте первым!</div>
                        <?php else: ?>
                            <?php foreach ($commentsUpdate2 as $comment): ?>
                                <div class="comment">
                                    <div class="comment-header">
                                        <span class="comment-author"><?php echo htmlspecialchars($comment['username']); ?></span>
                                        <span class="comment-date"><?php echo date('d.m.Y, H:i', strtotime($comment['created_at'])); ?></span>
                                    </div>
                                    <div class="comment-content">
                                        <p><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></p>
                                    </div>
                                    <div class="comment-actions">
                                        <span class="comment-action">Ответить</span>
                                        <span class="comment-action">Лайк (<?php echo $comment['likes']; ?>)</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <a href="#" class="back-to-list" onclick="hideUpdateDetail('update2'); return false;">← Назад к списку</a>
            </div>

            <!-- Обновление 3 -->
            <div class="update-preview">
                <div class="update-preview-images">
                    <img src="https://avatars.mds.yandex.net/i?id=f3081c8d19286a446244ed5f259be767_l-5130368-images-thumbs&n=13" alt="Новая карта Anubis">
                    <img src="https://static.wikia.nocookie.net/counterstrike/images/b/bf/Cs2dust2.jpg/revision/latest/scale-to-width-down/1000?cb=20230323193331&path-prefix=ru" alt="Обновленная Dust2">
                </div>
                <div class="update-preview-info">
                    <div class="importance-indicator">
                        <span class="importance-dot importance-high"></span>
                        <span class="importance-text">Важное обновление</span>
                    </div>
                    <div class="update-preview-header">
                        <h2 class="update-preview-title">Карты нового сезона</h2>
                        <span class="update-preview-date">3 апреля 2024</span>
                    </div>
                    <div class="update-tags">
                        <span class="update-tag">Новые карты</span>
                        <span class="update-tag">Редизайн</span>
                        <span class="update-tag">Source 2</span>
                    </div>
                    <div class="update-preview-content">
                        <p>Значительное обновление картографического пула CS2. Добавлены 3 новые карты в соревновательный режим и переработаны 2 классические карты с использованием всех возможностей движка Source 2.</p>
                    </div>
                    <ul class="update-preview-features">
                        <li>Anubis: Полностью новая карта в египетском стиле</li>
                        <li>Vertigo: Полный редизайн с улучшенной навигацией</li>
                        <li>Dust2: Визуальное обновление классики</li>
                    </ul>
                    <a class="read-more-btn" onclick="showUpdateDetail('update3'); return false;">Подробнее →</a>
                </div>
            </div>

            <div id="update3" class="update-detail">
                <div class="update-detail-header">
                    <h2 class="update-detail-title">Карты нового сезона</h2>
                    <span class="update-detail-date">3 апреля 2024</span>
                </div>
                <div class="update-tags">
                    <span class="update-tag">Новые карты</span>
                    <span class="update-tag">Редизайн</span>
                    <span class="update-tag">Source 2</span>
                    <span class="update-tag">Освещение</span>
                    <span class="update-tag">Текстуры</span>
                </div>
                <div class="update-detail-content">
                    <p>Это обновление приносит значительные изменения в картографический пул CS2.</p>
                    <p>Особое внимание было уделено балансу и визуальному оформлению. Все карты теперь используют возможности движка Source 2 в полной мере, включая улучшенное освещение, физику и текстуры высокого разрешения.</p>
                    <p>Новая карта Anubis представляет собой древний египетский храмовый комплекс с множеством уровней и проходов. Карта отличается асимметричным дизайном и предлагает разнообразные тактические возможности как для атакующей, так и для обороняющейся стороны.</p>
                    <p>Vertigo получила полный редизайн с улучшенной навигацией и более интуитивной планировкой. Добавлены новые проходы и укрытия, а также улучшена визуальная читаемость карты.</p>
                </div>
                <div class="update-detail-images">
                    <img src="https://avatars.mds.yandex.net/i?id=f3081c8d19286a446244ed5f259be767_l-5130368-images-thumbs&n=13" alt="Новая карта Anubis">
                    <img src="https://static.wikia.nocookie.net/counterstrike/images/b/bf/Cs2dust2.jpg/revision/latest/scale-to-width-down/1000?cb=20230323193331&path-prefix=ru" alt="Обновленная Dust2">
                    <img src="https://avatars.mds.yandex.net/i?id=2be30a318c0b05fd2951eb5a149eac4c_l-5220483-images-thumbs&n=13" alt="Новая карта Breach">
                </div>
                <div class="update-detail-features">
                    <h3>Новые и обновленные карты:</h3>
                    <ul>
                        <li>Anubis: Полностью новая карта в египетском стиле с множеством уровней и проходов</li>
                        <li>Vertigo: Полный редизайн с улучшенной навигацией, новыми проходами и укрытиями</li>
                        <li>Breach: Индустриальная карта с разрушаемыми элементами и динамическим окружением</li>
                        <li>Dust2: Визуальное обновление классики с улучшенными текстурами и освещением</li>
                        <li>Inferno: Улучшенное освещение, текстуры и оптимизация производительности</li>
                    </ul>
                </div>
                <div class="update-detail-features">
                    <h3>Технические улучшения карт:</h3>
                    <ul>
                        <li>Улучшенная система освещения с поддержкой глобального освещения</li>
                        <li>Текстуры высокого разрешения для всех поверхностей</li>
                        <li>Оптимизация производительности для слабых компьютеров</li>
                        <li>Улучшенная навигация для ботов</li>
                        <li>Исправлены проблемы с коллизией и застреванием игроков</li>
                        <li>Добавлены новые звуки окружающей среды для каждой карты</li>
                        <li>Улучшенные эффекты частиц для дыма, огня и взрывов</li>
                    </ul>
                </div>
                
                <!-- БЛОК КОММЕНТАРИЕВ -->
                <div class="comments-section">
                    <h3>Комментарии (<?php echo count($commentsUpdate3); ?>)</h3>
                    
                    <?php if ($auth->isLoggedIn()): ?>
                        <div class="comment-form">
                            <textarea placeholder="Напишите ваш комментарий..." id="commentText3"></textarea>
                            <button class="comment-submit" onclick="addComment('update3')">Отправить комментарий</button>
                        </div>
                    <?php else: ?>
                        <div class="login-to-comment">
                            <p>Чтобы оставить комментарий, необходимо <a href="Avtor.php">войти в систему</a></p>
                        </div>
                    <?php endif; ?>
                    
                    <div class="comments-list" id="commentsList3">
                        <?php if (empty($commentsUpdate3)): ?>
                            <div class="no-comments">Пока нет комментариев. Будьте первым!</div>
                        <?php else: ?>
                            <?php foreach ($commentsUpdate3 as $comment): ?>
                                <div class="comment">
                                    <div class="comment-header">
                                        <span class="comment-author"><?php echo htmlspecialchars($comment['username']); ?></span>
                                        <span class="comment-date"><?php echo date('d.m.Y, H:i', strtotime($comment['created_at'])); ?></span>
                                    </div>
                                    <div class="comment-content">
                                        <p><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></p>
                                    </div>
                                    <div class="comment-actions">
                                        <span class="comment-action">Ответить</span>
                                        <span class="comment-action">Лайк (<?php echo $comment['likes']; ?>)</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <a href="#" class="back-to-list" onclick="hideUpdateDetail('update3'); return false;">← Назад к списку</a>
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
        // Передаем данные пользователя из PHP в JavaScript
        const currentUser = <?php echo $auth->isLoggedIn() ? json_encode($auth->getUser()) : 'null'; ?>;

        function showUpdateDetail(updateId) {
            // Скрыть все детали
            document.querySelectorAll('.update-detail').forEach(detail => {
                detail.classList.remove('active');
            });

            // Показать выбранную деталь
            document.getElementById(updateId).classList.add('active');
        }

        function hideUpdateDetail(updateId) {
            document.getElementById(updateId).classList.remove('active');
        }

        async function addComment(updateId) {
            // Проверяем, авторизован ли пользователь
            if (!currentUser) {
                alert('Для добавления комментария необходимо войти в систему');
                return;
            }

            const commentTextElement = document.getElementById(`commentText${updateId.replace('update', '')}`);
            const commentText = commentTextElement.value.trim();

            if (commentText === '') {
                alert('Пожалуйста, введите текст комментария.');
                return;
            }

            if (commentText.length > 1000) {
                alert('Комментарий слишком длинный (максимум 1000 символов).');
                return;
            }

            // Блокируем кнопку во время отправки
            const submitButton = commentTextElement.nextElementSibling;
            submitButton.disabled = true;
            submitButton.textContent = 'Отправка...';

            try {
                const response = await fetch('add_comment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'add_comment',
                        update_id: updateId,
                        comment_text: commentText
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Добавляем новый комментарий в DOM
                    const commentList = document.getElementById(`commentsList${updateId.replace('update', '')}`);
                    
                    // Удаляем сообщение "Пока нет комментариев", если оно есть
                    const noCommentsMessage = commentList.querySelector('.no-comments');
                    if (noCommentsMessage) {
                        commentList.removeChild(noCommentsMessage);
                    }

                    // Создаем элемент нового комментария
                    const newComment = document.createElement('div');
                    newComment.classList.add('comment');
                    
                    const commentDate = new Date(data.comment.created_at);
                    const dateStr = commentDate.toLocaleDateString('ru-RU') + ', ' + commentDate.toLocaleTimeString('ru-RU', {hour: '2-digit', minute:'2-digit'});
                    
                    newComment.innerHTML = `
                        <div class="comment-header">
                            <span class="comment-author">${data.comment.username}</span>
                            <span class="comment-date">${dateStr}</span>
                        </div>
                        <div class="comment-content">
                            <p>${data.comment.comment_text.replace(/\n/g, '<br>')}</p>
                        </div>
                        <div class="comment-actions">
                            <span class="comment-action">Ответить</span>
                            <span class="comment-action">Лайк (${data.comment.likes})</span>
                        </div>
                    `;

                    // Добавляем комментарий в начало списка
                    commentList.insertBefore(newComment, commentList.firstChild);

                    // Очищаем поле формы
                    commentTextElement.value = '';
                    
                    // Обновляем счетчик комментариев
                    const commentsHeader = commentList.closest('.comments-section').querySelector('h3');
                    const currentCount = commentList.querySelectorAll('.comment').length;
                    commentsHeader.textContent = `Комментарии (${currentCount})`;

                } else {
                    alert(data.error || 'Ошибка при добавлении комментария');
                }
            } catch (error) {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при отправке комментария');
            } finally {
                // Разблокируем кнопку
                submitButton.disabled = false;
                submitButton.textContent = 'Отправить комментарий';
            }
        }
    </script>
</body>
</html>
