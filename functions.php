<?php
function connect_db(){
    global $connection;
    $host="localhost";
    $username="test";
    $password="t3st3r123";
    $db="test";
    $connection = mysqli_connect($host, $username, $password, $db) or die("Cannot connect to DB: " . mysqli_error());
    mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Cannot set charset to UTF8 - " . mysqli_error($connection));
}

function login() {
    global $connection;
    $errors = array();
    $_SESSION['user']=1;
}

function doRegister($username, $password) {
    global $connection;
    $errors = array();
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    if (empty($username)) {
        $errors[] = 'Username not set';
    }
    if (empty($password)) {
        $errors[] = 'Password not set';
    }
    if (!empty($errors)) {
        return $errors;
    }

    $userExistenceQuery = "SELECT * FROM anita_ndp_users WHERE username='$username'";
    $userExistenceResult = mysqli_query($connection, $userExistenceQuery) or die ("Username check failed: " . mysqli_error($connection));
    if (mysqli_num_rows($userExistenceResult) != 0) {
        $errors[] = 'Username already taken';
        return $errors;
    }

    $userInsertQuery = "insert into anita_ndp_users(username, password) values('$username', SHA1('$password'))";
    $insertResult = mysqli_query($connection, $userInsertQuery) or die ("User adding failed: " . mysqli_error($connection));

    login();
    return $errors;
}

function logout(){
    $_SESSION=array();
    session_destroy();
}

function printErrors($errors) {
    foreach($errors as $error) {
        echo '<div style="color:red;">' . htmlspecialchars($error) . '</div>';
    }
}

function toIndexPage() {
    header("Location: ?");
}
?>