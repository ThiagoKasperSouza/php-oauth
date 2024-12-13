
<?php include './pages/components/nav_dropdown.php' ?>

<main class="d-flex flex-nowrap">
  <?php include './pages/components/sidebar_big.php'; 
      if(isset($_GET['content'])) {
        $action = $_GET['content'];
        switch($action) {
            case 'orders_new':
                include './pages/components/orders/new.php';
                break;
            case 'orders_shipped':
                include './pages/components/orders/shipped.php';
                break;
            default:
              include './pages/components/dashboard/overview.php';
              break;
        }
      }
  ?>
</main>