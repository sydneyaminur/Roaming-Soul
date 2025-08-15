<?php
session_start();

// initializing variables
$username = "";
$email    = "";
// Global error list (kept for compatibility)
$errors = array();
// Field-specific errors to show under each input
$fieldErrors = [
  'username'   => [],
  'email'      => [],
  'password_1' => [],
  'password_2' => [],
  'password'   => [],
  'form'       => []
]; 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'project');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = trim(mysqli_real_escape_string($db, $_POST['username']));
  $email = strtolower(trim(mysqli_real_escape_string($db, $_POST['email'])));
  $password_1 = $_POST['password_1'] ?? '';
  $password_2 = $_POST['password_2'] ?? '';

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); $fieldErrors['username'][] = "Username is required"; }
  // At least 3 alphabetic characters (A-Z) anywhere in the name
  if (!empty($username)) {
    preg_match_all('/[A-Za-z]/', $username, $letterMatches);
    if (count($letterMatches[0]) < 3) {
      array_push($errors, "Name must contain at least 3 letters");
      $fieldErrors['username'][] = "Name must contain at least 3 letters";
    }
  }
  if (empty($email)) { array_push($errors, "Email is required"); $fieldErrors['email'][] = "Email is required"; }
  if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Enter a valid email address (e.g., user@domain.com)");
    $fieldErrors['email'][] = "Enter a valid email address (e.g., user@domain.com)";
  }
  if (empty($password_1)) { array_push($errors, "Password is required"); $fieldErrors['password_1'][] = "Password is required"; }
  if ($password_1 !== $password_2) { array_push($errors, "The two passwords do not match"); $fieldErrors['password_2'][] = "The two passwords do not match"; }
  // Password rules: length > 6 (>=7), at least 1 uppercase, 1 digit, and 1 special from .,+-
  if (!empty($password_1)) {
    if (strlen($password_1) < 7
        || !preg_match('/[A-Z]/', $password_1)
        || !preg_match('/\d/', $password_1)
        || !preg_match('/[\.,+\-]/', $password_1)) {
      array_push($errors, "Password must be ≥ 7 chars and include an uppercase letter, a number, and one of . , + -");
      $fieldErrors['password_1'][] = "Password must be ≥ 7 chars and include an uppercase letter, a number, and one of . , + -";
    }
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
  array_push($errors, "Username already exists");
  $fieldErrors['username'][] = "Username already exists";
    }

    if ($user['email'] === $email) {
  array_push($errors, "email already exists");
  $fieldErrors['email'][] = "Email already exists";
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
    // Securely hash the password
    $passwordHash = password_hash($password_1, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, email, password) 
              VALUES('$username', '$email', '$passwordHash')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = trim(mysqli_real_escape_string($db, $_POST['username']));
  $password = $_POST['password'] ?? '';

  if (empty($username)) {
  	array_push($errors, "Username is required");
    $fieldErrors['username'][] = "Username is required";
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
    $fieldErrors['password'][] = "Password is required";
  }

  if (count($errors) == 0) {
    // Fetch by username and verify password (supports new hash and legacy md5)
    $query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $results = mysqli_query($db, $query);
    if ($results && mysqli_num_rows($results) == 1) {
      $row = mysqli_fetch_assoc($results);
      $stored = $row['password'];
      $ok = false;
      if (password_get_info($stored)['algo'] !== 0) {
        // New hashed password
        $ok = password_verify($password, $stored);
      } else {
        // Legacy md5 stored, compare and optionally rehash
        if ($stored === md5($password)) { $ok = true; }
      }
      if ($ok) {
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
        exit();
      } else {
        array_push($errors, "Wrong username/password combination");
        // show this under the password field on the login form
        $fieldErrors['password'][] = "Wrong username/password combination";
      }
    } else {
      array_push($errors, "Wrong username/password combination");
      $fieldErrors['password'][] = "Wrong username/password combination";
    }
  }
}

?>