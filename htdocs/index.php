<?php
require_once 'config/file_auth.php';
$auth = new FileAuth();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameUP - Главная страница</title>
    <link rel="icon" href="favicon.png" type="image/png" sizes="16x16">
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

        /* НОВЫЕ СТИЛИ ДЛЯ ПОИСКА */
        .search-container {
            background-color: #0d0d0d;
            padding: 15px 20px;
            border-bottom: 1px solid #333;
        }
        
        .search-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
        }
        
        .search-input-wrapper {
            display: flex;
            align-items: center;
            background-color: #333;
            border-radius: 8px;
            padding: 0 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            border: 1px solid #444;
        }
        
        .search-icon {
            color: #ff6f61;
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        
        .search-input {
            width: 100%;
            padding: 12px 0;
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 16px;
            outline: none;
        }
        
        .search-input::placeholder {
            color: #999;
        }
        
        .search-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: #333;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            max-height: 300px;
            overflow-y: auto;
            z-index: 100;
            border: 1px solid #444;
            border-top: none;
            display: none;
        }
        
        .search-dropdown.show {
            display: block;
        }
        
        .search-result-item {
            display: block;
            padding: 12px 15px;
            color: #ffffff;
            text-decoration: none;
            transition: background-color 0.2s;
            border-bottom: 1px solid #444;
            cursor: pointer;
        }
        
        .search-result-item:last-child {
            border-bottom: none;
        }
        
        .search-result-item:hover {
            background-color: #444;
            color: #ff6f61;
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
        .hero {
            text-align: center;
            padding: 50px 20px;
            margin-bottom: 40px;
            background: linear-gradient(135deg, #333, #555);
            border-radius: 8px;
        }
        .hero h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #ff6f61;
        }
        .hero p {
            font-size: 18px;
            max-width: 800px;
            margin: 0 auto;
        }
        .featured-section {
            margin-bottom: 40px;
        }
        .featured-section h2 {
            color: #ff6f61;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .featured-games {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .game-card {
            background-color: #333;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .game-card:hover {
            transform: translateY(-5px);
        }
        img {
            max-width: 100%;
            height: auto;
        }
        .game-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .game-card-content {
            padding: 15px;
        }
        .game-card h3 {
            margin-top: 0;
            color: #ff6f61;
        }
        .game-card-content ul {
            padding-left: 20px;
            margin: 10px 0;
        }
        .game-card-content li {
            margin-bottom: 5px;
            font-size: 14px;
        }
        .news-section {
            margin: 40px 0;
        }
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }
        .news-card {
            background: #333;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .news-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .news-card-content {
            padding: 20px;
        }
        .news-card h3 {
            margin: 0 0 10px;
            color: #ff6f61;
            font-size: 18px;
        }
        .date {
            color: #888;
            font-size: 14px;
            margin-bottom: 15px;
            display: block;
        }
        .news-card p {
            margin: 0 0 15px;
            line-height: 1.5;
        }
        .read-more {
            color: #ff6f61;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        .read-more:hover {
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
            }
            
            .featured-games {
                grid-template-columns: 1fr;
            }
            
            .news-grid {
                grid-template-columns: 1fr;
            }
            
            footer .footer-content {
                flex-direction: column;
            }
            
            footer .column {
                margin-bottom: 20px;
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

    <!-- НОВЫЙ БЛОК ПОИСКА - ДОБАВЛЕН СРАЗУ ПОСЛЕ HEADER -->
    <div class="search-container">
        <div class="search-wrapper">
            <div class="search-input-wrapper">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 1 1-14 0 7 7 0 0 1 14 0z"></path>
                </svg>
                <input 
                    type="text" 
                    id="searchInput" 
                    class="search-input" 
                    placeholder="Поиск игр..."
                    autocomplete="off"
                >
            </div>
            <div id="searchDropdown" class="search-dropdown"></div>
        </div>
    </div>

    <div class="container">
        <section class="hero">
            <h1>Добро пожаловать в GameUP</h1>
            <p>Лучший ресурс для геймеров - новости, обзоры, каталог игр и многое другое. Присоединяйтесь к нашему сообществу!</p>
        </section>

        <section class="featured-section">
            <h2>Популярные игры</h2>
            <div class="featured-games">
                <div class="game-card">
                    <a href="cs2-review.php" style="text-decoration: none; color: inherit;">
                        <img src="https://img.nvidiagrid.net/apps/100884811/ZZ/TV_BANNER_01_8b2e4223-92d0-4b95-93a7-ec44ed6c1a88.jpg" alt="Counter-Strike 2">
                        <div class="game-card-content">
                            <h3>Counter-Strike 2</h3>
                            <p>Легендарный тактический шутер, представляющий новую эру серии CS с улучшенной графикой на движке Source 2.</p>
                            <p><strong>Основные особенности:</strong></p>
                            <ul>
                                <li>Командные 5v5 сражения (Террористы vs Контр-Террористы)</li>
                                <li>Обновленные карты и визуальные эффекты</li>
                                <li>Реалистичная баллистика и физика дыма</li>
                                <li>Рейтинговые соревновательные матчи</li>
                                <li>Глубокая экономическая система</li>
                            </ul>
                        </div>
                    </a>
                </div>
                <div class="game-card">
                    <a href="dota2-review.php" style="text-decoration: none; color: inherit;">
                        <img src="https://i.playground.ru/p/iy6b3LaNW7fIpnyccZ84iQ.jpeg" alt="Dota 2">
                        <div class="game-card-content">
                            <h3>Dota 2</h3>
                            <p><strong>Жанр:</strong> MOBA (Многопользовательская онлайновая боевая арена)</p>
                            <p><strong>Особенности:</strong></p>
                            <ul>
                                <li>Сражения 5v5 с уникальными героями</li>
                                <li>Более 120 персонажей с разными способностями</li>
                                <li>Глубокая стратегическая составляющая</li>
                                <li>Регулярные масштабные турниры (The International)</li>
                                <li>Динамичная система прокачки и предметов</li>
                            </ul>
                        </div>
                    </a>
                </div>
                <div class="game-card">
                    <a href="rust-review.php" style="text-decoration: none; color: inherit;">
                        <img src="https://repository-images.githubusercontent.com/948867890/622a6f56-b403-4e36-8e92-96eba3fc4802" alt="Rust">
                        <div class="game-card-content">
                            <h3>Rust</h3>
                            <p><strong>Жанр:</strong> Survival (Выживание в открытом мире)</p>
                            <p><strong>Особенности:</strong></p>
                            <ul>
                                <li>Жесткие условия выживания (голод, холод, дикие животные)</li>
                                <li>Крафтинг и строительство баз</li>
                                <li>PvP-взаимодействия с другими игроками</li>
                                <li>Реалистичная система ранений</li>
                                <li>Регулярные обновления и события</li>
                            </ul>
                        </div>
                    </a>
                </div>
                <div class="game-card">
                    <a href="pubg-review.php" style="text-decoration: none; color: inherit;">
                        <img src="https://i.playground.ru/p/LbIeWgwfQd92F6cQK2b5fA.jpeg" alt="PUBG">
                        <div class="game-card-content">
                            <h3>PUBG: Battlegrounds</h3>
                            <p><strong>Жанр:</strong> Battle Royale (Королевская битва)</p>
                            <p><strong>Особенности:</strong></p>
                            <ul>
                                <li>Реалистичный шутер с элементами выживания</li>
                                <li>До 100 игроков на одной карте</li>
                                <li>Постепенно сужающаяся зона игры</li>
                                <li>Разнообразный арсенал оружия и снаряжения</li>
                                <li>Несколько уникальных карт и режимов</li>
                            </ul>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section class="news-section">
            <h2>Последние новости</h2>
            <div class="news-grid">
                <div class="news-card">
                    <img src="https://image-proxy.bo3.gg/uploads/news/55370/title_image/webp-3327cfe4accd5e00bfe53f13b9872e00.webp.webp?w=1248&h=624" alt="CS2 новость">
                    <div class="news-card-content">
                        <h3>Обновление CS2: Новые карты и исправления</h3>
                        <div class="date">15 марта 2024</div>
                        <p>Valve выпустила крупное обновление для Counter-Strike 2, добавив две новые карты и исправив множество багов.</p>
                        <a href="news1.php" class="read-more">Читать далее →</a>
                    </div>
                </div>
        
                <div class="news-card">
                    <img src="https://avatars.mds.yandex.net/i?id=dc3a5392145a6b1ca261c7dd273750b8_l-5427846-images-thumbs&n=13" alt="Dota 2 новость">
                    <div class="news-card-content">
                        <h3>The International 2024: Даты и место проведения</h3>
                        <div class="date">10 марта 2024</div>
                        <p>Организаторы анонсировали даты главного турнира по Dota 2 - The International пройдет в Сингапуре в октябре 2024.</p>
                        <a href="news2.php" class="read-more">Читать далее →</a>
                    </div>
                </div>
        
                <div class="news-card">
                    <img src="https://files.facepunch.com/billb/1b2611b1/_qCIjdTQ.jpeg" alt="Rust новость">
                    <div class="news-card-content">
                        <h3>Rust: Новый транспортный апдейт</h3>
                        <div class="date">5 марта 2024</div>
                        <p>Facepunch Studios представили крупное обновление с новыми транспортными средствами и механиками передвижения.</p>
                        <a href="news3.php" class="read-more">Читать далее →</a>
                    </div>
                </div>
            </div>
        </section>
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

    <!-- JAVASCRIPT КОД ДЛЯ ПОИСКА -->
    <script>
        // Данные игр
        const games = [
            { name: "Counter-Strike 2", url: "cs2-updates.php" },
            { name: "Rust", url: "rust-updates.php" },
            { name: "Dota 2", url: "dota2-updates.php" },
            { name: "PUBG", url: "pubg-updates.php" },
            { name: "Valorant", url: "valorant-updates.php" },
            { name: "World of Tanks", url: "wot-updates.php" },
            { name: "Fortnite", url: "fortnite-updates.php" }
        ];

        const searchInput = document.getElementById('searchInput');
        const searchDropdown = document.getElementById('searchDropdown');

        // Функция для фильтрации игр
        function filterGames(query) {
            return games.filter(game => 
                game.name.toLowerCase().includes(query.toLowerCase())
            );
        }

        // Функция для отображения результатов
        function showResults(filteredGames) {
            if (filteredGames.length === 0) {
                searchDropdown.classList.remove('show');
                return;
            }

            searchDropdown.innerHTML = '';
            filteredGames.forEach(game => {
                const item = document.createElement('a');
                item.href = game.url;
                item.className = 'search-result-item';
                item.textContent = game.name;
                item.addEventListener('click', () => {
                    searchInput.value = '';
                    searchDropdown.classList.remove('show');
                });
                searchDropdown.appendChild(item);
            });

            searchDropdown.classList.add('show');
        }

        // Обработчик ввода в поисковую строку
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            
            if (query === '') {
                searchDropdown.classList.remove('show');
                return;
            }

            const filteredGames = filterGames(query);
            showResults(filteredGames);
        });

        // Обработчик фокуса на поисковой строке
        searchInput.addEventListener('focus', (e) => {
            const query = e.target.value.trim();
            if (query !== '') {
                const filteredGames = filterGames(query);
                showResults(filteredGames);
            }
        });

        // Закрытие выпадающего списка при клике вне его
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-wrapper')) {
                searchDropdown.classList.remove('show');
            }
        });

        // Обработка нажатия Enter
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                const query = e.target.value.trim();
                const filteredGames = filterGames(query);
                
                if (filteredGames.length > 0) {
                    window.location.href = filteredGames[0].url;
                }
            }
        });
    </script>
</body>
</html>
