<nav class="navbar  fixed-bottom navbar-dark bg-dark" aria-label="First navbar example">
    <div class="container-fluid">
      <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse" id="navbarsExample01" style="">
        <?php include './pages/components/sidebar_items.php' ?>
        <li class="border-top my-3"></li>
        <li class="mb-1">
          <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
            Account
          </button>
          <div class="collapse" id="account-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Profile</a></li>
              <li><a href="/settings" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Settings</a></li>
              <li><a href="/logout" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Sign out</a></li>
            </ul>
          </div>
        </li>
      </div>
    </div>
</nav>
<style>
  .navbar-collapse {
  padding: 1em 0;
}
</style>