<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $errors = doRegister($_POST['username'], $_POST['password']);
      printErrors($errors);
      if (empty($errors)) {
          toIndexPage();
          return;
      }
  }
  ?>

<form method="post" action="?page=register">
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
            <td><input type="submit" value="Register"/> </td>
        </tr>
    </table>
</form>
