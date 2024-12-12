
<?php 
  include './pages/components/nav_dropdown.php'; 
  echo '<main class="d-flex flex-nowrap">';
  include './pages/components/sidebar_big.php';
  if(isset($_GET['content'])) {
    $action = $_GET['content'];
    switch($action) {
        case 'new':
            include './pages/components/new.php';
            break;
        case 'list':
            include './pages/components/list.php';
            break;
        default:
          include './pages/components/dash_overview.php';
          break;
    }
  }
  echo ' </main>';
 
?>

