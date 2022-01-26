<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/trader" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/trader/logout.php">
        <i class="fas fa-power-off"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-th-large"></i>
      </a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/" class="brand-link">
    <img src="/assets/images/logo.svg" alt="OnlineAppetite Logo" width="75px" height="75px" class="brand-image p-1 img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Online Appetite</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= $_SESSION['trader']['IMAGE'] ?? "/assets/images/adminlte/avatar2.png" ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="/trader/profile.php" class="d-block"><?= $_SESSION['trader']['FULL_NAME'] ?></a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="/trader" class="nav-link <?= $page == 'Dashboard' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item <?= $page == 'AddShop' || $page == 'ViewShops' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= $page == 'AddShop' || $page == 'ViewShops' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-store-alt"></i>
            <p>
              Shops
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/trader/addShop.php" class="nav-link <?= $page == 'AddShop' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Shop</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/trader/viewShops.php" class="nav-link <?= $page == 'ViewShops' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>View Shops</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="/trader/viewOrders.php" class="nav-link <?= $page == 'Orders' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>
              Orders
            </p>
          </a>
        </li>
        <li class="nav-item <?= $page == 'AddProduct' || $page == 'ViewProducts' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= $page == 'AddProduct' || $page == 'ViewProducts' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-gifts"></i>
            <p>
              Products
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/trader/addProduct.php" class="nav-link <?= $page == 'AddProduct' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Product</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/trader/viewProducts.php" class="nav-link <?= $page == 'ViewProducts' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>View Products</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?= $page == 'AddDiscount' || $page == 'ViewDiscounts' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= $page == 'AddDiscount' || $page == 'ViewDiscounts' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
              Discounts
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/trader/addDiscount.php" class="nav-link <?= $page == 'AddDiscount' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Discount</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/trader/viewDiscounts.php" class="nav-link <?= $page == 'ViewDiscounts' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>View Discounts</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>