<?php
// Файловая система вместо базы данных
class FileDatabase {
    private $dataDir;
    private $usersFile;
    private $commentsFile;
    
    public function __construct() {
        $this->dataDir = __DIR__ . '/../data/';
        $this->usersFile = $this->dataDir . 'users.json';
        $this->commentsFile = $this->dataDir . 'comments.json';
        
        // Создаем папку data, если её нет
        if (!file_exists($this->dataDir)) {
            mkdir($this->dataDir, 0777, true);
        }
        
        // Создаем файлы, если их нет
        if (!file_exists($this->usersFile)) {
            file_put_contents($this->usersFile, json_encode([]));
        }
        
        if (!file_exists($this->commentsFile)) {
            file_put_contents($this->commentsFile, json_encode([]));
        }
    }
    
    // Получить всех пользователей
    public function getUsers() {
        $data = file_get_contents($this->usersFile);
        return json_decode($data, true) ?: [];
    }
    
    // Сохранить пользователей
    public function saveUsers($users) {
        return file_put_contents($this->usersFile, json_encode($users, JSON_PRETTY_PRINT));
    }
    
    // Найти пользователя
    public function findUser($username, $email = null) {
        $users = $this->getUsers();
        foreach ($users as $user) {
            if ($user['username'] === $username || ($email && $user['email'] === $email)) {
                return $user;
            }
        }
        return null;
    }
    
    // Добавить пользователя
    public function addUser($username, $email, $passwordHash) {
        $users = $this->getUsers();
        $newUser = [
            'id' => count($users) + 1,
            'username' => $username,
            'email' => $email,
            'password_hash' => $passwordHash,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $users[] = $newUser;
        $this->saveUsers($users);
        return $newUser;
    }
    
    // Получить комментарии
    public function getComments() {
        $data = file_get_contents($this->commentsFile);
        return json_decode($data, true) ?: [];
    }
    
    // Сохранить комментарии
    public function saveComments($comments) {
        return file_put_contents($this->commentsFile, json_encode($comments, JSON_PRETTY_PRINT));
    }
    
    // Добавить комментарий
    public function addComment($updateId, $authorName, $authorEmail, $content) {
        $comments = $this->getComments();
        $newComment = [
            'id' => count($comments) + 1,
            'update_id' => $updateId,
            'author_name' => $authorName,
            'author_email' => $authorEmail,
            'content' => $content,
            'likes_count' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $comments[] = $newComment;
        $this->saveComments($comments);
        return $newComment;
    }
    
    // Получить комментарии для обновления
    public function getCommentsForUpdate($updateId) {
        $comments = $this->getComments();
        $filtered = array_filter($comments, function($comment) use ($updateId) {
            return $comment['update_id'] == $updateId;
        });
        return array_values($filtered);
    }
}
?>
