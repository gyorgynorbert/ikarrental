<?php
    session_start();

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

    $name = $email = $password = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (empty($_POST['name'])) {
            $response['errors']['name'] ='Felhasználónév megadása kötelező!';
        } else {
            $name = test_input($_POST['name']);

            if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
                $response ['errors']['name'] = 'A felhasználónév nem tartalmazhat ékezetes karaktereket!';
            }
        }

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

            if (strlen($password) < 8) {
                $response['errors']['password'] = 'A jelszó legalább 8 karakter hosszú legyen!';
            }

            if (!preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
                $response['errors']['password'] = 'A jelszó legalább egy kisbetűt, egy nagybetűt és egy számot tartalmazzon!';
            } 
        }

        if (empty($response['errors'])) {

            if (file_exists(USER_DB)) {
                $users = json_decode(file_get_contents(USER_DB), true); 
            } else {
                $users = [];
            }

            foreach ($users as $user) {
                if ($user['name'] === $name) {
                    $response['errors']['name'] = 'A felhasználónév már foglalt!';
                }

                if ($user['email'] === $email) {
                    $response['errors']['email'] = 'Az email cím már foglalt!';
                }

                if (!empty($response['errors']['name']) || !empty($response['errors']['email'])) {
                    break;
                }
            }

            if (empty($response['errors'])) {
                $users[] = [
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT)
                ];

                if (file_put_contents(USER_DB, json_encode($users, JSON_PRETTY_PRINT))) {
                    $response['success'] = true;
                } else {
                    $response['errors']['form'] = 'A regisztráció sikertelen!';
                }
            } 
        }
    } else {
        $response['errors']['form'] = 'Érvénytelen kérés!';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>