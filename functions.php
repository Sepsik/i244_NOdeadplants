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

function getUserPlants() {
    global $connection;

    $query = "select id, user_id, name, description, watering_interval, last_watered, DATE_ADD(last_watered, INTERVAL watering_interval DAY) as next_watering from anita_ndp_plants  
    where user_id='".$_SESSION['user']['ID']."' order by next_watering";
    $queryResult = mysqli_query($connection, $query) or die ("Getting all plants failed: " . mysqli_error($connection));
    return mysqli_fetch_all($queryResult, MYSQLI_ASSOC);
}

function waterThePlant($plantId) {
    global $connection;
    $plantId = mysqli_real_escape_string($connection, $plantId);

    $plantWateringQuery = "update anita_ndp_plants set last_watered = NOW() where id='$plantId' and user_id='".$_SESSION['user']['ID']."'";
    mysqli_query($connection, $plantWateringQuery) or die ("Plant watering failed: " . mysqli_error($connection));
}

function deletePlant($plantId) {
    global $connection;
    $plantId = mysqli_real_escape_string($connection, $plantId);

    $plantDeleteQuery = "delete from anita_ndp_plants where id='$plantId' and user_id='".$_SESSION['user']['ID']."'";
    mysqli_query($connection, $plantDeleteQuery) or die ("Deleting plant failed: " . mysqli_error($connection));
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