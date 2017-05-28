<img src="background.jpg" id="background"/>
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
<script>
    function checkPasswords() {
        if (document.getElementById('password1').value ===
            document.getElementById('password2').value) {
            return true;
        }
        else {
            alert('Passwords do not match!');
            return false;
        }
    }
</script>
<div id="form">
    <form method="post" action="?page=register" onsubmit="return(checkPasswords())">
        <table>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username"/> </td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" id="password1"/> </td>
            </tr>
            <tr>
                <td>Retype password</td>
                <td><input type="password" id="password2"/> </td>
            </tr>
            <tr>
                <td/>
                <td><input type="submit" value="Register"/> </td>
            </tr>
        </table>
    </form>
</div>