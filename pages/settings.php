
<div class="container-fluid bd-example-row" style="padding: 0 4em; ">
  <div class="row" style="height:100vh">
    <div class="col-md-4  bg-body-tertiary" style="padding:4em; box-shadow: 5px 0 10px rgba(0, 0, 0, 0.5);">
      <h2>Logged in as  <?php  echo '<p>' . $_SESSION['name'] . '</p>'; ?></h2>

      <div class="form-floating mb-3">
        <input disabled class="form-control" value="<?php echo $_SESSION['email'];?>">
        <label for="hostInput">e-mail</label>
      </div>

      <hr class="my-4">

      <h2>Connect to your db: </h2>
      <form class="p-4 p-md-5 border rounded-3 bg-body-tertiary" method="post">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" name="hostInput" placeholder="192.168.0.1">
          <label for="hostInput">Host</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" class="form-control" name="userInput" placeholder="postgres">
          <label for="userInput">User</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" name="pwdInput" placeholder="Password">
          <label for="floatingPassword">Password</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit" name="form_connection">Connect</button>
        <hr class="my-4">
      </form>

      <hr class="my-4">
      
      <form  method="post">
        <button class="btn btn-primary" type="submit" name="logout_button">Sair do app</button>
      </form>
    </div>
  </div>
  <?php include './pages/components/nav_dropdown.php' ?>

</div>

<!-- <h2>Logged in as</h2>


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
</div> -->

