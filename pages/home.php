
<h2>Logged in as</h2>

<?php 
  echo '<h3>' . $_SESSION['name'] . '</h3>';
  echo '<h3>' . $_SESSION['email'] . '</h3>';
?>

<div class="col-md-10 mx-auto col-lg-5 py-md-5 conContainer">
  <form class="p-4 p-md-5 border rounded-3 bg-body-tertiary" method="post">
    <div class="form-floating mb-3">
      <input class="form-control" name="hostInput" placeholder="localhost">
      <label for="hostInput">host</label>
    </div>
    <div class="form-floating mb-3">
      <input  class="form-control" name="userInput" placeholder="postgres">
      <label for="userInput">User</label>
    </div>
    <div class="form-floating mb-3">
      <input type="password" class="form-control" name="pwdInput" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit" name="form_connection">Connect</button>
    <hr class="my-4">

  </form>
</div>
<style>
  .conContainer {
    margin: 2em;
  }
</style>

<form  method="post">
<button class="btn btn-primary" type="submit" name="logout_button">Sair do app</button>
</form>
