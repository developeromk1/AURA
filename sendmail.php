<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"] ?? ''));
    $message = strip_tags(trim($_POST["message"]));
    
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['message' => 'Пожалуйста, заполните обязательные поля правильно.']);
        exit;
    }
    
    $recipient = "roma.zenit23@gmail.com"; // ЗАМЕНИТЕ НА СВОЙ EMAIL
    $subject = "Новое сообщение от $name";
    
    $email_content = "Имя: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Телефон: $phone\n\n";
    $email_content .= "Сообщение:\n$message\n";
    
    $email_headers = "From: $name <$email>";
    
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo json_encode(['message' => 'Спасибо! Ваше сообщение отправлено.']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Упс! Что-то пошло не так, и мы не смогли отправить ваше сообщение.']);
    }
} else {
    http_response_code(403);
    echo json_encode(['message' => 'Возникла проблема с отправкой, попробуйте еще раз.']);
}
?>