<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/src/business/CustomerService.php';

// csrf protection
if (isset($_SESSION['token'])) {
    $oldToken = $_SESSION['token'];
}

$customerService = new CustomerService;
$token = md5(uniqid('',true));
$_SESSION['token'] = $token;

require_once __DIR__ . '/src/presentation/customerLoginPage.php';

/*
 * Handles a request to create a complete account with email and password
 */

if ((isset($_POST['createAccount'])) && ($_POST['createAccount'] === 'true')) { 
    if ((isset($_SESSION['token'])) && ($_POST['token'] == $oldToken)) {
        $fname = trim(filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING));
        $sname = trim(filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING));
        $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING));
        $address = trim(filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING));
        $postcode = trim(filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_STRING));
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
        $passwordConfirm = trim(filter_input(INPUT_POST, 'passwordConfirm', FILTER_SANITIZE_STRING));
        
        $formErrors = [];
    
        if ($customerService->checkIfEmailExists($email)) { 
            $formErrors[] = "email already in use";
        }
    
        if (!$customerService->checkPasswords($password, $passwordConfirm)) {
            $formErrors[] = "Passwords do not match";
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }
        // email not in use, passwords match so create customer and go to checkout
        if (count($formErrors) === 0) { 
            $customerService->registerCustomer($fname, $sname, $phone, $address, $postcode, $email, $password);
            setcookie('email', $email);
            $_SESSION['customer'] = serialize($customerService->getCustomerDetails($email));  
            $_SESSION['authorized'] = true;
            header('Location: checkout.php');
            exit(0);
        }
    }
}

/*
 * Handles a login request using an existing account.
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
                header('Location: checkout.php');
                exit(0);
            }
        }
    }
}


/*
 * Handles users response to the questions
 * I have an account
 * or
 * I do not have an account.
 *  
 */
if ((isset($_GET['account'])) && ($_GET['account'] === 'true')) { // customer has an account so show login form
    require_once __DIR__ . '/src/presentation/loginPage.php';
    // require_once __DIR__.'/src/presentation/foot.php';
} else if ((isset($_GET['account'])) && ($_GET['account'] === 'false')) { // customer does not have an account
    $makeAccount = false;
    if ((isset($_POST['command'])) && ($_POST['command'] === 'register')) { // register form has been filled out
        if ((isset($_SESSION['token'])) && ($_POST['token'] == $oldToken)) {
            $fname = trim(filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING));
            $sname = trim(filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING));
            $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING));
            $address = trim(filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING));
            $postcode = trim(filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_STRING));
            
            
            if ((isset($_POST['makeAccount'])) && ($_POST['makeAccount'] === 'true')) { // checkbox was checked display email and email and password inputs
                $makeAccount = true;
    
            } else if (!isset($_POST['createAccount'])) { // checkbox was unchecked go to checkout
                $id = $customerService->registerCustomer($fname, $sname, $phone, $address, $postcode, NULL, NULL);
                $_SESSION['customer'] = serialize($customerService->getCustomerById((int) $id));
                $_SESSION['authorized'] = true;
                $makeAccount = false;
                header('Location: checkout.php');
                exit(0);
            }
        }
    }
    
    require_once __DIR__ . '/src/presentation/registerPage.php'; // show register form
}




