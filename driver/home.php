<h1 class="text-dark">Hello, welcome <?php echo $_settings->userdata('firstname') ?>!</h1>
<hr class="border-dark">

<div class="row">

  <div class="col-12 col-sm-6 col-md-3">
    <a href="?page=deliveries" style="color:#343a40">
      <div class="info-box">
        <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-truck"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Assigned Deliveries</span>
          <span class="info-box-number">
            <?php
            $driver_id = $_settings->userdata('id');
            $delivery = $conn->query("SELECT * FROM delivery_list where driver_id = $driver_id")->num_rows;
            echo number_format($delivery);
            ?>
          </span>
        </div>
      </div>
    </a>
  </div>

</div>

<h2 class="text-dark" style="color: red;">Deliveries to make</h2>
<hr class="border-dark">

<div class="row">

  <div class="col-12 col-sm-6 col-md-3">
    <a href="?page=deliveries/pending" style="color:#343a40">
      <div class="info-box mb-3" style="background-color: #ffc10726;">
        <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-truck"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Deliveries</span>
          <span class="info-box-number">
            <?php
            $delivery = $conn->query("SELECT * FROM delivery_list where driver_id = $driver_id and status = 0")->num_rows;
            echo number_format($delivery);
            ?>
          </span>
        </div>
      </div>
    </a>
  </div>

</div>