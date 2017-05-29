<img src="background.jpg" id="background" alt="plant background"/>

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
                    <td></td>
                    <td><input type="submit" value="Login"/> </td>
                </tr>
            </table>
        </form>
    </div>
<?php
else:
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['water'])) {
            waterThePlant($_POST['plantId']);
        }
        else if (isset($_POST['delete'])) {
            deletePlant($_POST['plantId']);
        }
        toIndexPage();
        return;
}
?>
    <div id="userPlants">
        <table>
            <colgroup>
                <col style="width:18%">
                <col style="width:60%">
                <col style="width:22%">
            </colgroup>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Next Watering</th>
            </tr>
<?php
    if (getUserPlants() == null) {
        echo "<p> You don't have any plants yet.</p>";
    }
    else {
        foreach (getUserPlants() as $plant) {
            echo "<form method='post' action='?page=start'>";
            echo "<input type='hidden' name='plantId' value='".$plant['id']."'/>";
            echo "<tr>";
            echo "<td style='font-weight: bold; width:100px'>".htmlspecialchars($plant['name'])."<br><input type='submit' name='delete' value='Delete' onclick=\"return confirm('Are You sure You want to delete Your plant?');\"/></td>";
            echo "<td style='text-align: justify'>".htmlspecialchars($plant['description'])."</td>";
            echo "<td style='color: darkred'>".htmlspecialchars($plant['next_watering'])."<br><input type='submit' name='water' value='Water'/></td></form>";
            echo "</tr>";
        }
    }
endif;
?>
        </table>
    </div>
