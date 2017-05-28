<img src="background.jpg" id="background"/>

<?php if(!isUserLoggedIn()) :
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = login($_POST['username'], $_POST['password']);
        printErrors($errors);
        if (empty($errors)) {
            toIndexPage();
            return;
        }
    }
    ?>
    <div id="form">
        <form method="post" action="?page=start">
            <table>
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
    </div>
<?php
else:
    echo "Todo: show list of dying plants";
endif;
?>