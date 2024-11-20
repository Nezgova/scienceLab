<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['article_id'];
    $vote = $_POST['vote']; // 'up' or 'down'

    try {
        if ($vote === 'up') {
            $stmt = $pdo->prepare("UPDATE articles SET votes = votes + 1 WHERE id = ?");
        } elseif ($vote === 'down') {
            $stmt = $pdo->prepare("UPDATE articles SET votes = votes - 1 WHERE id = ?");
        } else {
            throw new Exception("Invalid vote type.");
        }

        $stmt->execute([$article_id]);
        header('Location: articles.php');
        exit;
    } catch (Exception $e) {
        die("Error processing vote: " . $e->getMessage());
    }
}
