<div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary sidebar_big">
    <a href="/dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
      <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
      <span class="fs-4">Php example</span>
    </a>
    <hr>
    <?php include './pages/components/sidebar_items.php' ?>
    <hr>
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="<?php echo $_SESSION['picture']?>" alt="" width="32" height="32" class="rounded-circle me-2">
        <strong><?php echo $_SESSION['name']?></strong>
      </a>
      <ul class="dropdown-menu text-small shadow">
        <li><a class="dropdown-item" href="/settings">Settings</a></li>
        <li><a class="dropdown-item" href="/logout">Sign out</a></li>
      </ul>
    </div>
  </div>

<style>

.dropdown-toggle { outline: 0; }

.btn-toggle {
  padding: .25rem .5rem;
  font-weight: 600;
  color: var(--bs-emphasis-color);
  background-color: transparent;
}
.btn-toggle:hover,
.btn-toggle:focus {
  color: rgba(var(--bs-emphasis-color-rgb), .85);
  background-color: var(--bs-tertiary-bg);
}
.sidebar, .sidebar_big {
    width: 280px;
    box-shadow: 5px 0 10px rgba(0, 0, 0, 0.5); 
    height: 100vh;
}

.btn-toggle::before {
  width: 1.25em;
  line-height: 0;
  content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
  transition: transform .35s ease;
  transform-origin: .5em 50%;
}

[data-bs-theme="dark"] .btn-toggle::before {
  content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%28255,255,255,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
}

.btn-toggle[aria-expanded="true"] {
  color: rgba(var(--bs-emphasis-color-rgb), .85);
}
.btn-toggle[aria-expanded="true"]::before {
  transform: rotate(90deg);
}
.btn-toggle-nav a {
transition: background-color 0.3s; /* Transição suave */
}
.btn-toggle-nav a {
  padding: .1875rem .5rem;
  margin-top: .125rem;
  margin-left: 1.25rem;
}
.btn-toggle-nav a:hover,
.btn-toggle-nav a:focus {
  background-color: #2b3035;
}

.scrollarea {
  overflow-y: auto;
}

/* On screens that are 600px or less, set the background color to olive */
@media screen and (max-width: 1200px) {
  .sidebar_big {
    visibility: hidden;
  }
}
@media screen and (min-width: 1200px) {
  .navbar {
    visibility: hidden;
  }
}
</style>