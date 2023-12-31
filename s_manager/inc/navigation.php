</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary bg-navy elevation-4 sidebar-no-expand">
  <!-- Brand Logo -->
  <a href="<?php echo base_url ?>s_manager" class="brand-link bg-primary text-sm">
    <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Store Logo" class="brand-image img-circle elevation-3" style="width: 1.7rem;height: 1.7rem;max-height: unset">
    <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
    <div class="os-resize-observer-host observed">
      <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
    </div>
    <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
      <div class="os-resize-observer"></div>
    </div>
    <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
    <div class="os-padding">
      <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
        <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
          <!-- Sidebar user panel (optional) -->
          <div class="clearfix"></div>
          <!-- Sidebar Menu -->
          <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item dropdown">
                <a href="./" class="nav-link nav-home">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>

              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>s_manager/?page=store_requisitions" class="nav-link nav-store_requisitions">
                  <i class="nav-icon fas fa-warehouse"></i>
                  <p>
                    Store Requisitions
                  </p>
                </a>
              </li>

              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>s_manager/?page=purchase_orders" class="nav-link nav-purchase_orders">
                  <i class="nav-icon fas fa-file-invoice"></i>
                  <p>
                    Purchase Orders
                  </p>
                </a>
              </li>

              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>s_manager/?page=quotations" class="nav-link nav-quotations">
                  <i class="nav-icon fas fa-receipt"></i>
                  <p>
                    Quotations
                  </p>
                </a>
              </li>

              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>s_manager/?page=deliveries" class="nav-link nav-deliveries">
                  <i class="nav-icon fas fa-truck"></i>
                  <p>
                    Deliveries
                  </p>
                </a>
              </li>

              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>s_manager/?page=invoices" class="nav-link nav-invoices">
                  <i class="nav-icon fas fa-file-invoice-dollar"></i>
                  <p>
                    Invoices
                  </p>
                </a>
              </li>

              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>s_manager/?page=back_requisitions" class="nav-link nav-back_requisitions">
                  <i class="nav-icon fas fa-exchange-alt"></i>
                  <p>
                    Back Requisitions
                  </p>
                </a>
              </li>

              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>s_manager/?page=projects" class="nav-link nav-projects">
                  <i class="nav-icon fas fa-funnel-dollar"></i>
                  <p>
                    Cost Centers
                  </p>
                </a>
              </li>

              <li class="nav-header">Store Maintenance</li>

              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>s_manager/?page=items" class="nav-link nav-items">
                  <i class="nav-icon fas fa-boxes"></i>
                  <p>
                    Item List
                  </p>
                </a>
              </li>

              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>s_manager/?page=suppliers" class="nav-link nav-suppliers">
                  <i class="nav-icon fas fa-truck-loading"></i>
                  <p>
                    Supplier List
                  </p>
                </a>
              </li>

              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>s_manager/?page=clients" class="nav-link nav-clients">
                  <i class="nav-icon fas fa-user-circle"></i>
                  <p>
                    Client List
                  </p>
                </a>
              </li>

            </ul>

          </nav>
          <!-- /.sidebar-menu -->
        </div>
      </div>
    </div>
    <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
      <div class="os-scrollbar-track">
        <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
      </div>
    </div>
    <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
      <div class="os-scrollbar-track">
        <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
      </div>
    </div>
    <div class="os-scrollbar-corner"></div>
  </div>
  <!-- /.sidebar -->
</aside>
<script>
  $(document).ready(function() {
    var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
    var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
    page = page.split('/');
    page = page[0];
    if (s != '')
      page = page + '_' + s;

    if ($('.nav-link.nav-' + page).length > 0) {
      $('.nav-link.nav-' + page).addClass('active')
      if ($('.nav-link.nav-' + page).hasClass('tree-item') == true) {
        $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active')
        $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open')
      }
      if ($('.nav-link.nav-' + page).hasClass('nav-is-tree') == true) {
        $('.nav-link.nav-' + page).parent().addClass('menu-open')
      }

    }

  })
</script>