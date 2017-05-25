<img src="background.jpg"/>

<?php if(!isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = login($_POST['username'], $_POST['password']);
        printErrors($errors);
        if (empty($errors)) {
            toIndexPage();
            return;
        }
    }
    ?>
    <form method="post" action="?page=start">
        <table border="0">
            <tr>
                <td>Username</td>
                <td><input type="text" name="username"/> </td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password"/> </td>
            </tr>
            <tr>
                <td/>
                <td><input type="submit" value="Login"/> </td>
            </tr>
        </table>
    </form>
<?php
}
else {
    echo "Todo: show list of dying plants";
}
?>