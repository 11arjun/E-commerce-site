<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin" class="nav-link">Home</a>
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
      <a class="nav-link" href="/admin/logout.php">
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
        <img src="<?= $_SESSION['admin']['IMAGE'] ?? "/assets/images/adminlte/avatar2.png" ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="/admin/profile.php" class="d-block"><?= $_SESSION['admin']['FULL_NAME'] ?></a>
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
          <a href="/admin" class="nav-link <?= $page == 'Dashboard' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item <?= $page == 'Traders' || $page == 'Customers' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= $page == 'Traders' || $page == 'Customers' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
              Users
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/viewTraders.php" class="nav-link <?= $page == 'Traders' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Traders</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/viewCustomers.php" class="nav-link <?= $page == 'Customers' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Customers</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?= $page == 'AddCategory' || $page == 'ViewCategories' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= $page == 'AddCategory' || $page == 'ViewCategories' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
              Category
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/addCategory.php" class="nav-link <?= $page == 'AddCategory' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/viewCategories.php" class="nav-link <?= $page == 'ViewCategories' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>View Categories</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="/admin/viewShops.php" class="nav-link <?= $page == 'Shops' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-store-alt"></i>
            <p>
              Shops
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/admin/viewOrders.php" class="nav-link <?= $page == 'Orders' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>
              Orders
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/admin/viewProducts.php" class="nav-link <?= $page == 'Products' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-gifts"></i>
            <p>
              Products
            </p>
          </a>
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
              <a href="/admin/addDiscount.php" class="nav-link <?= $page == 'AddDiscount' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Discount</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/viewDiscounts.php" class="nav-link <?= $page == 'ViewDiscounts' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>View Discounts</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?= $page == 'AddVoucher' || $page == 'ViewVouchers' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= $page == 'AddVoucher' || $page == 'ViewVouchers' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
              Vouchers
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/addVoucher.php" class="nav-link <?= $page == 'AddVoucher' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Voucher</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/viewVouchers.php" class="nav-link <?= $page == 'ViewVouchers' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>View Vouchers</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?= $page == 'AddSlot' || $page == 'ViewSlots' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= $page == 'AddSlot' || $page == 'ViewSlots' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
              Slots
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/addSlot.php" class="nav-link <?= $page == 'AddSlot' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Slot</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/viewSlots.php" class="nav-link <?= $page == 'ViewSlots' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>View Slots</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="/admin/viewPayments.php" class="nav-link <?= $page == 'Payments' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-receipt"></i>
            <p>
              Payments
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>