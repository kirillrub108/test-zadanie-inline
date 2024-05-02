<?php

// Подключение к базе данных
$db_host = 'db';
$db_port = '3306';
$db_name = 'test_zadanie_inline';
$db_user = 'root';
$db_pass = 'root';

try {
    $dbh = new PDO("mysql:host=$db_host;port=$db_port;dbname=$db_name", $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if(isset($_GET['search'])) {
    $search_text = $_GET['search'];

    // Поиск записей по тексту комментария
    $stmt = $dbh->prepare("SELECT posts.title, comments.body FROM posts INNER JOIN comments ON posts.id = comments.postId WHERE comments.body LIKE :search");
    $stmt->execute([':search' => "%$search_text%"]); // Здесь исправлено
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(count($results) > 0) {
        echo "<h2>Результаты поиска:</h2>";
        foreach ($results as $result) {
            echo "<p><strong>Заголовок записи:</strong> " . $result['title'] . "</p>";
            echo "<p><strong>Комментарий:</strong> " . $result['body'] . "</p>";
        }
    } else {
        echo "<p>Ничего не найдено.</p>";
    }
}

?>