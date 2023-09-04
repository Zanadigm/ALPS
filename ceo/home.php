<h1 class="text-dark">Hello, welcome <?php echo $_settings->userdata('firstname') ?>!</h1>
<hr class="border-dark">

<div class="row">

  <div class="col-12 col-sm-6 col-md-3">
    <a href="?page=projects" style="color:#343a40">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-funnel-dollar"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Cost Centers</span>
          <span class="info-box-number">
            <?php
            $project = $conn->query("SELECT * FROM project_list")->num_rows;
            echo number_format($project);
            ?>
          </span>
        </div>
      </div>
    </a>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <a href="?page=store_requisitions" style="color:#343a40">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-warehouse"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Store Requisitions</span>
          <span class="info-box-number">
            <?php
            $rq = $conn->query("SELECT * FROM rq_list")->num_rows;
            echo number_format($rq);
            ?>
          </span>
        </div>
      </div>
    </a>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <a href="?page=purchase_orders" style="color:#343a40">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file-invoice"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Local Purchase Orders</span>
          <span class="info-box-number">
            <?php
            $pending_po = $conn->query("SELECT * FROM po_list")->num_rows;
            echo number_format($pending_po);
            ?>
          </span>
        </div>
      </div>
    </a>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <a href="?page=deliveries" style="color:#343a40">
      <div class="info-box">
        <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-truck"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Deliveries</span>
          <span class="info-box-number">
            <?php
            $delivery = $conn->query("SELECT * FROM delivery_list")->num_rows;
            echo number_format($delivery);
            ?>
          </span>
        </div>
      </div>
    </a>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <a href="?page=suppliers" style="color:#343a40">
      <div class="info-box">
        <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-truck-loading"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Suppliers</span>
          <span class="info-box-number">
            <?php
            $supplier = $conn->query("SELECT * FROM supplier_list")->num_rows;
            echo number_format($supplier);
            ?>
          </span>
        </div>
      </div>
    </a>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <a href="?page=user/list" style="color:#343a40">
      <div class="info-box">
        <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-users"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Users</span>
          <span class="info-box-number">
            <?php
            $users = $conn->query("SELECT * FROM users")->num_rows;
            echo number_format($users-1);
            ?>
          </span>
        </div>
      </div>
    </a>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <a href="?page=invoices/pending" style="color:#343a40">
      <div class="info-box">
        <span class="info-box-icon bg-navy elevation-1"><i class=" fas fa-file-invoice-dollar"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Invoices</span>
          <span class="info-box-number">
            <?php
            $invoices = $conn->query("SELECT * FROM invoice_list")->num_rows;
            echo number_format($invoices);
            ?>
          </span>
        </div>
      </div>
    </a>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <a href="?page=invoices/pending" style="color:#343a40">
      <div class="info-box">
        <span class="info-box-icon bg-navy elevation-1"><i class=" fas fa-receipt"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Quotations</span>
          <span class="info-box-number">
            <?php
            $quotations = $conn->query("SELECT * FROM quotation_list")->num_rows;
            echo number_format($quotations);
            ?>
          </span>
        </div>
      </div>
    </a>
  </div>

  
</div>

<h2 class="text-dark" style="color: red;">Pending Tasks</h2>
<hr class="border-dark">

<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <a href="?page=store_requisitions/pending" style="color:#343a40">
      <div class="info-box mb-3" style="background-color: #ffc10726;">
        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-warehouse"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Store Requisitions</span>
          <span class="info-box-number" style="color: red;">
            <?php
            $rq = $conn->query("SELECT * FROM rq_list WHERE `status` = 0")->num_rows;
            echo number_format($rq);
            ?>
          </span>
        </div>
      </div>
    </a>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <a href="?page=purchase_orders/pending" style="color:#343a40">
      <div class="info-box mb-3" style="background-color: #ffc10726;">
        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file-invoice"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Local Purchase Orders</span>
          <span class="info-box-number" style="color: red;">
            <?php
            $pending_po = $conn->query("SELECT * FROM po_list WHERE `status` = 0")->num_rows;
            echo number_format($pending_po);
            ?>
          </span>
        </div>
      </div>
    </a>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <a href="?page=invoices/pending" style="color:#343a40">
      <div class="info-box mb-3" style="background-color: #ffc10726;">
        <span class="info-box-icon bg-navy elevation-1"><i class=" fas fa-file-invoice-dollar"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Invoices</span>
          <span class="info-box-number" style="color: red;">
            <?php
            $delivery = $conn->query("SELECT * FROM invoice_list WHERE `status` !=1")->num_rows;
            echo number_format($delivery);
            ?>
          </span>
        </div>
      </div>
    </a>
  </div>

</div>