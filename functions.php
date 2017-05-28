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

function login($username, $password) {
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

    $userQuery = "SELECT * FROM anita_ndp_users WHERE username='$username' AND password=SHA1('$password')";
    $userResult = mysqli_query($connection, $userQuery) or die ("$userQuery - ". mysqli_error($connection));
    if (mysqli_num_rows($userResult) != 0) {
        $_SESSION['user'] = mysqli_fetch_assoc($userResult);
    }
    else {
        $errors[] = 'Login failed, wrong username or password';
    }
    return $errors;
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

    login($username, $password);
    return $errors;
}

function addPlants($name, $desc, $interval) {
    global $connection;
    $errors = array();
    $name = mysqli_real_escape_string($connection, $name);
    $desc = mysqli_real_escape_string($connection, $desc);
    $interval = mysqli_real_escape_string($connection, $interval);


    if (empty($name)) {
        $errors[] = 'Plant name not set';
    }
    if (empty($desc)) {
        $errors[] = 'Description not set';
    }

    if (!is_numeric($interval) || $interval <= 0) {
        $errors[] = 'Invalid interval';
    }
    if (!empty($errors)) {
        return $errors;
    }

    $plantExistenceQuery = "SELECT * FROM anita_ndp_plants WHERE name='$name' AND user_id='".$_SESSION['user']['ID']."'";
    $plantExistenceResult = mysqli_query($connection, $plantExistenceQuery) or die ("Name check failed: " . mysqli_error($connection));
    if (mysqli_num_rows($plantExistenceResult) != 0) {
        $errors[] = 'Plant named '. $name . ' already exists';
        return $errors;
    }

    $plantInsertQuery = "insert into anita_ndp_plants(user_ID, name, description, watering_interval, last_watered) values ('".$_SESSION['user']['ID']."', '$name', '$desc', '$interval', NOW())";
    $plantInsertResult = mysqli_query($connection, $plantInsertQuery) or die ("Plant adding failed: " . mysqli_error($connection));

    return $errors;
}

function logout(){
    $_SESSION=array();
    session_destroy();
}

function printErrors($errors) {
    echo '<div id="errors">';
    foreach($errors as $error) {
        echo '<p>' . htmlspecialchars($error) . '</p>';
    }
    echo '</div>';
}

function isUserLoggedIn() {
    return isset($_SESSION['user']);
}

function toIndexPage() {
    header("Location: ?");
}
?>