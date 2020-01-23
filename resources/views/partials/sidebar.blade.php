<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-dark bg-dark" id="adminSidebar">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="../../pages/dashboards/dashboard.html">
          <img src="{{ asset('img/blue.png') }}" class="navbar-brand-img" alt="...">
        </a>
      </div>
      <div class="navbar-inner">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <sidebar-item title="Dashboard" icon="fas fa-home"></sidebar-item>
            <sidebar-item base-url="/admin/products" title="Products" has-dropdown icon="fas fa-shopping-cart">
              <template>
                <sidebar-item is-dropdown title="View" link="/admin/products" ></sidebar-item>
                <sidebar-item is-dropdown title="New" link="/admin/products/add"></sidebar-item>
              </template>
            </sidebar-item>
            <sidebar-item base-url="/admin/product-options" title="Product Options" has-dropdown icon="fas fa-cog">
              <template>
                <sidebar-item is-dropdown title="View" link="/admin/product-options"></sidebar-item>
                <sidebar-item is-dropdown title="Option Groups" link="/admin/product-options/groups"></sidebar-item>
                <sidebar-item is-dropdown title="Option Values" link="/admin/product-options/values"></sidebar-item>
              </template>
            </sidebar-item>

            <sidebar-item title="Attributes" link="/admin/attributes" icon="fas fa-tags"></sidebar-item>

            <sidebar-item title="Fitment" link="/admin/fitments" icon="fas fa-sliders-h"></sidebar-item>
      
          </ul>
          <!-- Divider -->
          <hr class="my-3">
          <!-- Heading -->
          <h6 class="navbar-heading p-0 text-muted">Data Management</h6>
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <a class="nav-link" href="/admin/syncdata">
                <i class="fas fa-sync"></i>
                <span class="nav-link-text">Sync Data</span>
              </a>
            </li>
          
  
          </ul>
       
      </div>

  </nav>