
<h2>Logged in as</h2>

<?php 
  echo '<h3>' . $_SESSION['name'] . '</h3>';
  echo '<h3>' . $_SESSION['email'] . '</h3>';
?>

<form  method="post">
<button class="btn btn-primary" type="submit" name="logout_button">Sair do app</button>
</form>
