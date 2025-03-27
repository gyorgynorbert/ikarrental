<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    define('USER_DB', $_SERVER['DOCUMENT_ROOT'] . '/assets/data/users.json');

    $response = [
        'success' => false,
        'errors' => []
    ];

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = $password = ''; 
    $successful_login = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (empty($_POST['email'])) {
            $response['errors']['email'] = 'Email cím megadása kötelező!';
        } else {
            $email = test_input($_POST['email']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['errors']['email'] = 'Helytelen email formátum!';
            }
        }

        if (empty($_POST['password'])) {
            $response['errors']['password'] = 'Jelszó megadása kötelező!';
        } else {
            $password = test_input($_POST['password']);
        }

        if (empty($response['errors'])) {
            if (file_exists(USER_DB)) {
                $users = json_decode(file_get_contents(USER_DB), true);
            } else {
                $response['errors']['form'] = "Hiba történt!";
            }
            
            $user_found = false;

            foreach ($users as $user) {
                if ($user['email'] === $email ) {
                    $user_found = true;

                    if (password_verify($password, $user['password'])) {
                        $response['success'] = true;
                        $successful_login = true;
                    } else {
                        $response['errors']['password'] = 'Hibás jelszó!';
                    }
                    break;
                }
            }

            if (!$user_found) {
                $response['errors']['form'] = "Kérem először regisztáljon!";
            }
        }
    } else {
        $response['errors']['form'] = 'Érvénytelen kérés!';
    }

    if ($successful_login) {
        session_regenerate_id(true);

        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = [
            'email' => $user['email'],
            'name' => $user['name']
        ];
    }

    header(header: 'Content-Type: application/json');
    echo json_encode($response);
?>