
<style>
    .occ_col {
        width:92px;
        height:55px;
        border:2px solid #e2e2e2;
        border-radius:7px;
        float:left;
        margin:7px; 
        padding:5px; 
        
        color:#fff;
        font-size:13px;
    }
    .greenn {
        background-color:green;
    }
    .yelloww {
        background-color:#ebd300;
    }
    .orangee {
        background-color:#e87000;
    }
</style>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <?php if($is_admin == true): ?>

            <div class="container" style="background-color:#fff; border-radius:7px; width:99%;">
              <div class="row">
                    <?php $slno = 1; ?>
                    <?php $max_occ = $max_occ['maxocc']; ?>
                    <?php $total_in = count($occupancy_data); ?>
                    <?php $primary_minutes = $current_price_master['primary_minutes']; ?>
                    <?php $i = 0; ?>
                    
                    <div class="col-md-12" style="padding-bottom:20px;">
                        <div class="col-md-4">
                            <h3><b>Maximum Occupancy: </b><?php echo $max_occ; ?></h3>
                        </div>
                        
                        <div class="col-md-4">
                            <h3><b>Total Occupied: </b><?php echo $total_in; ?></h3>
                        </div>
                        
                        <div class="col-md-4">
                            <h3><b>Free Slots: </b><?php echo $max_occ - $total_in; ?> </h3>
                        </div>
                    </div>
                    
                    <?php for($i=0; $i<=$max_occ; $i++) { ?>
                        
                        <?php
                                if($i < $total_in) {
                                    $out_time = strtotime(date("Y-m-d H:i:s"));
                                    $in_time = strtotime($occupancy_data[$i]['token_created_at']);
                                    
                                    $diff = $out_time-$in_time;
                                    $total_mins = floor($diff/60); 
                                
                                    if($total_mins >= $primary_minutes) {
                                        $status_bg = 'orangee';
                                    } else {
                                        $status_bg = 'yelloww';
                                    }
                                } else {
                                    $status_bg = 'greenn';
                                }
                                
                        ?>

                        <div class="occ_col <?php echo $status_bg; ?>" > <?php if($i < $total_in) { echo '<b>IN: </b>'.date('h:i a', strtotime($occupancy_data[$i]['token_created_at'])); } ?> </div>
                    <?php } ?>
                    <?php /*foreach($occupancy_data as $key => $occ) { ?>
                        <div class="col-md-1 occ_col <?php if($key == 2) { ?>greeny<?php } ?>" ></div>
                    <?php }*/ ?>
              </div>
              <br>
            </div>


        <br><br>

        <div class="row">
          <div class="col-lg-4 col-md-4 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-primary" style="border-radius:7px;">
              <div class="inner">
                <h3><?php echo $total_products_today ?></h3>

                <p>Total Tokens Today</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('token/token_list') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-aqua" style="border-radius:7px;">
              <div class="inner">
                <h3><?php echo $total_products ?></h3>

                <p>Total Tokens list</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('token/token_list') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-md-4 col-xs-4">
            <!-- small box -->
            <div class="small-box bg-green" style="border-radius:7px;">
              <div class="inner">
                <h3><?php echo $total_paid_orders ?></h3>

                <p>Total Paid Tokens</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('token/token_list/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->          
        </div>
        <!-- /.row -->
      <?php endif; ?>
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function() {
      $("#dashboardMainMenu").addClass('active');
    });
  </script>
