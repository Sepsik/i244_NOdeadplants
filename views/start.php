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
else: ?>
    <div id="userPlants">
    <table border="1">
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Next Watering</th>
    </tr>
<?php
    foreach (getUserPlants() as $plant) {
        echo "<tr>";
        echo "<td style='font-weight: bold; width:100px'>".htmlspecialchars($plant['name'])."</td>";
        echo "<td style='text-align: justify'>".htmlspecialchars($plant['description'])."</td>";
        echo "<td style='color: darkred'>".htmlspecialchars($plant['next_watering'])."</td>";
        echo "</tr>";
    }
endif;
?>
    </table>
    </div>
