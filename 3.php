<?php
// Вот исправленный участок кода с dvwa
if (isset($_GET['Submit'])) {
    // Get input
    $id = $_GET['id'];

    // Check database
    $conn = new mysqli("localhost", "username", "password", "database");

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Использование подготовленного запроса для предотвращения SQL-инъекций
    $stmt = $conn->prepare("SELECT first_name, last_name FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Получение результатов
    $num = $result->num_rows;
    if ($num > 0) {
        // Feedback for end user
        $html .= '<pre>User ID exists in the database.</pre>';
    } else {
        // User wasn't found, so the page wasn't!
        http_response_code(404);

        // Feedback for end user
        $html .= '<pre>User ID is MISSING from the database.</pre>';
    }

    $stmt->close();
    $conn->close();
}

?>