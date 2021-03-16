<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/src/business/CustomerService.php';

// csrf protection
if (isset($_SESSION['token'])) {
    $oldToken = $_SESSION['token'];
}

$customerService = new CustomerService;
$token = md5(uniqid('', true));
$_SESSION['token'] = $token;

/*
 * Handles a login request when a user has an account.
 */
if ((isset($_POST['command'])) && ($_POST['command'] === 'login')) {
    if ((isset($_SESSION['token'])) && ($_POST['token'] == $oldToken)) {
        $email = $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
    
        $formErrors = [];
    
        if (!$customerService->checkIfEmailExists($email)) {
            $formErrors[] = "Email not in use";
        } else {
            if (!$customerService->checkPasswordCorrect($email, $password)) {
                $formErrors[] = 'Password incorrect';
            } else {
                $_SESSION['customer'] = serialize($customerService->getCustomerDetails($email));
                setcookie('email', $email);
                $_SESSION['authorized'] = true;
                header('Location: menu.php');
                exit(0);
            }
        }
    }
}


require_once __DIR__ . '/src/presentation/loginPage.php';
