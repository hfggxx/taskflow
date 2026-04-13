<?php

function sanitize($data) {
    return htmlspecialchars(trim($data));
}

function redirect($location) {
    header("Location: " . $location);
    exit();
}

function setMessage($type, $message) {
    $_SESSION['message_type'] = $type;
    $_SESSION['message'] = $message;
}

function displayMessage() {
    if (isset($_SESSION['message'])) {
        $type = $_SESSION['message_type'];
        $message = $_SESSION['message'];

        echo "<div class='message {$type}'>{$message}</div>";

        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
}

function old($field) {
    return isset($_POST[$field]) ? htmlspecialchars($_POST[$field]) : '';
}
?>