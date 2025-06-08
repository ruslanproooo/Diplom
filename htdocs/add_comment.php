<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config/file_auth.php';

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
        throw new Exception("Connection failed: " . $e->getMessage());
    }
}

// Функция для получения комментариев
function getComments($updateId) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM comments WHERE update_id = ? ORDER BY created_at DESC");
        $stmt->execute([$updateId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        return [];
    }
}

// Функция для добавления комментария
function addComment($updateId, $userId, $username, $commentText) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("INSERT INTO comments (update_id, user_id, username, comment_text) VALUES (?, ?, ?, ?)");
        $stmt->execute([$updateId, $userId, $username, $commentText]);
        
        // Возвращаем добавленный комментарий
        $commentId = $pdo->lastInsertId();
        $stmt = $pdo->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->execute([$commentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        throw new Exception("Error adding comment: " . $e->getMessage());
    }
}

// Обработка запросов
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new FileAuth();
    
    if (!$auth->isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['error' => 'Необходимо войти в систему']);
        exit;
    }
    
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? '';
    
    if ($action === 'add_comment') {
        $updateId = $input['update_id'] ?? '';
        $commentText = trim($input['comment_text'] ?? '');
        
        if (empty($updateId) || empty($commentText)) {
            http_response_code(400);
            echo json_encode(['error' => 'Все поля обязательны']);
            exit;
        }
        
        if (strlen($commentText) > 1000) {
            http_response_code(400);
            echo json_encode(['error' => 'Комментарий слишком длинный']);
            exit;
        }
        
        try {
            $user = $auth->getUser();
            $comment = addComment($updateId, $user['id'] ?? 0, $user['username'], $commentText);
            echo json_encode(['success' => true, 'comment' => $comment]);
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Ошибка при добавлении комментария']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Неизвестное действие']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $updateId = $_GET['update_id'] ?? '';
    
    if (empty($updateId)) {
        http_response_code(400);
        echo json_encode(['error' => 'ID обновления обязателен']);
        exit;
    }
    
    try {
        $comments = getComments($updateId);
        echo json_encode(['success' => true, 'comments' => $comments]);
    } catch(Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Ошибка при загрузке комментариев']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Метод не поддерживается']);
}
?>
