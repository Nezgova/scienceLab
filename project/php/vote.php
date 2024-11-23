<?php
session_start();
header('Content-Type: application/json');
require 'db.php';

// Validate user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to vote.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

// Validate input
$article_id = $input['article_id'] ?? null;
$vote = $input['vote'] ?? null;

if (!$article_id || !$vote) {
    echo json_encode(['success' => false, 'message' => 'Missing required data.']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if the user already voted
$stmt = $pdo->prepare("SELECT vote FROM user_votes WHERE user_id = ? AND article_id = ?");
$stmt->execute([$user_id, $article_id]);
$existing_vote = $stmt->fetchColumn();

if ($existing_vote === $vote) {
    echo json_encode(['success' => false, 'message' => 'You have already cast this vote.']);
    exit;
}

// Update votes
if ($existing_vote) {
    // User is changing their vote
    $stmt = $pdo->prepare("UPDATE articles SET votes = votes + :adjustment WHERE id = :article_id");
    $adjustment = ($vote === 'up' ? 2 : -2); // +2 for changing downvote to upvote, -2 for vice versa
    $stmt->execute([':adjustment' => $adjustment, ':article_id' => $article_id]);

    $stmt = $pdo->prepare("UPDATE user_votes SET vote = ? WHERE user_id = ? AND article_id = ?");
    $stmt->execute([$vote, $user_id, $article_id]);
} else {
    // New vote
    $stmt = $pdo->prepare("UPDATE articles SET votes = votes + :adjustment WHERE id = :article_id");
    $adjustment = ($vote === 'up' ? 1 : -1);
    $stmt->execute([':adjustment' => $adjustment, ':article_id' => $article_id]);

    $stmt = $pdo->prepare("INSERT INTO user_votes (user_id, article_id, vote) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $article_id, $vote]);
}

// Fetch updated vote count
$stmt = $pdo->prepare("SELECT votes FROM articles WHERE id = ?");
$stmt->execute([$article_id]);
$new_vote_count = $stmt->fetchColumn();

echo json_encode(['success' => true, 'message' => 'Vote recorded successfully.', 'newVoteCount' => $new_vote_count]);
exit;
