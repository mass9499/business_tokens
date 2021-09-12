
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
          <h1>Add<small>Price Master</small></h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Price Master</li>
          </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          
          <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php elseif($this->session->flashdata('error')): ?>
            <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Choose Price Master</h3>
            </div>
           
              <div class="box-body">

                <?php echo validation_errors(); ?> 
               
         <form class="form-inline" method="post" action="<?php echo base_url(); ?>token/pricemaster_category_save">
         
         
          <!--modal pop up button -->
         
          <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal">Edit Price Master</button> 
          <input type="hidden" id="current_active_val" value="<?php echo $price_category[0]['active_status']; ?>" />
         
         <div class="col-md-7">
         
           <!--1st row -->
         
            <div class="row" id="firstrow">
                <div class="col-md-12">
                 <div class="radio">
                    &nbsp; &nbsp;
                    <label><input type="radio" name="price_radio1" value="1" <?php if($price_category[0]['active_status']==1) { echo "checked"; } ?> style="width:15px; height:15px;" ></label>
                    &nbsp;
                  </div>
                  
                  <div class="form-group">
                    <label for="cost1">&nbsp;1 Hour</label> &nbsp; &nbsp; &nbsp;
                    <input type="text" class="form-control" name="cost1" id="cost1" value="<?php echo $price_category[0]['primary_cost']; ?>" style="border-radius:25px;" readonly>
                  </div>
                  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                  <div class="form-group">
                    <label for="extracost1">Extra Min Cost</label> &nbsp; &nbsp; &nbsp;
                    <input type="text" class="form-control" name="extracost1" id="extracost1" value="<?php echo $price_category[0]['secondary_cost']; ?>" style="border-radius:25px;" readonly>
                  </div>
                  
                </div>
             </div>
             <br>
            <!--2nd row -->
            
             <div class="row" id="secondrow">
                <div class="col-md-12">
                 <div class="radio">
                    &nbsp; &nbsp;
                    <label><input type="radio" name="price_radio1" value="2" <?php if($price_category[1]['active_status']==1) { echo "checked"; } ?> style="width:15px; height:15px;" ></label>
                    &nbsp;
                  </div>
                  <div class="form-group">
                    <label for="cost2">45 Mins</label> &nbsp; &nbsp; &nbsp;
                    <input type="text" class="form-control" name="cost2" id="cost2" value="<?php echo $price_category[1]['primary_cost']; ?>" style="border-radius:25px;" readonly>
                  </div>
                  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                  <div class="form-group">
                    <label for="extracost2">Extra Min Cost</label> &nbsp; &nbsp; &nbsp;
                    <input type="text" class="form-control" name="extracost1" id="extracost2" value="<?php echo $price_category[1]['secondary_cost']; ?>" style="border-radius:25px;" readonly>
                  </div>
                  
                </div>
             </div>
             <br>
             
             <!--3rd row -->
             <div class="row" id="thirdrow">
                <div class="col-md-12">
                 <div class="radio">
                    &nbsp; &nbsp;
                    <label><input type="radio" name="price_radio1" value="3" <?php if($price_category[2]['active_status']==1) { echo "checked"; } ?> style="width:15px; height:15px;" ></label>
                    &nbsp;
                  </div>
                  <div class="form-group">
                    <label for="cost3">30 Mins</label> &nbsp; &nbsp; &nbsp;
                    <input type="text" class="form-control" name="cost3" id="cost3" value="<?php echo $price_category[2]['primary_cost']; ?>" style="border-radius:25px;" readonly>
                  </div>
                  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                  <div class="form-group">
                    <label for="extracost3">Extra Min Cost</label> &nbsp; &nbsp; &nbsp;
                    <input type="text" class="form-control" name="extracost3" id="extracost3" value="<?php echo $price_category[2]['secondary_cost']; ?>" style="border-radius:25px;" readonly>
                  </div>
                  
                 
                </div>
             </div>
             <br>
             
             <!--4th row -->
             <div class="row" id="fourthrow">
                <div class="col-md-12">
                 <div class="radio"> 
                    &nbsp; &nbsp;
                    <label><input type="radio" name="price_radio1" value="4" <?php if($price_category[3]['active_status']==1) { echo "checked"; } ?> style="width:15px; height:15px;" ></label>
                    &nbsp;
                  </div>
                  <div class="form-group">
                    <label for="cost4">15 Mins</label> &nbsp; &nbsp; &nbsp;
                    <input type="text" class="form-control" name="cost4" id="cost4" value="<?php echo $price_category[3]['primary_cost']; ?>" style="border-radius:25px;" readonly>
                  </div>
                  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                  <div class="form-group">
                    <label for="extracost4">Extra Min Cost</label> &nbsp; &nbsp; &nbsp;
                    <input type="text" class="form-control" name="extracost4" id="extracost4" value="<?php echo $price_category[3]['secondary_cost']; ?>" style="border-radius:25px;" readonly>
                  </div>
                  
                </div>
             </div>
        
        </div>
        
        <!--<div class="col-md-5">-->
            
        <!--    <center>-->
        <!--        <br><br>-->
        <!--        <label>Maximum Occupancy</label><br>-->
        <!--        <input type="number" value="<?php // if(isset($max_occ)) { echo $max_occ['max_occ']; } else { echo 0; } ?>" class="form-control">-->
        <!--    </center>-->
            
        <!--</div>-->
        
             <div class="box-footer">
                 <div class="row">
                     <div class="col-md-7">
                         <br>
                         <center>
                             <button type="submit" id="price_method_save_btn" class="btn btn-primary btn-sm" style="border-radius:25px;" disabled> &nbsp; &nbsp; Save &nbsp; &nbsp; </button>
                             &nbsp; &nbsp;
                             <a href="<?php echo base_url('dashboard') ?>" class="btn btn-warning btn-sm" style="border-radius:25px;"> &nbsp; &nbsp; Back &nbsp; &nbsp; </a>
                             &nbsp; &nbsp; &nbsp; &nbsp;
                        </center>
                     </div>
                     <div class="col-md-5"></div>
                </div>
              </div>
             
        </form>
        
         <!-- price edit modal--> 
          
         <div class="modal fade" id="myModal" role="dialog">
           <div class="modal-dialog">
            
              <!-- Modal content-->
              <form method="post" action="<?php echo base_url(); ?>token/pricemaster_modal_save">
              <div class="modal-content">
                <div class="modal-header" style="background-color:#3c8dbc;color:white;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Price Master</h4>
                </div>
                
                
                <div class="modal-body">
                    
         
        <!-- Modal -->            
        <!--1st row -->
         
            <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-5">
                  <div class="form-group">
                    <label for="cost1">1Hour</label>
                    <input type="text" class="form-control" name="cost1" id="cost1" value="<?php echo $price_category[0]['primary_cost']; ?>" >
                  </div>&nbsp;&nbsp;
                  </div>
                   <div class="col-md-5">
                  <div class="form-group">
                    <label for="extracost1">Extra Min Cost</label>
                    <input type="text" class="form-control" name="extracost1" id="extracost1" value="<?php echo $price_category[0]['secondary_cost']; ?>" >
                  </div>
                   </div>
                  
             </div>
             
            <!--2nd row -->
            
             <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-5">
                  <div class="form-group">
                    <label for="cost2">45Mins</label>
                    <input type="text" class="form-control" name="cost2" id="cost2" value="<?php echo $price_category[1]['primary_cost']; ?>" >
                  </div>
                  </div>
                  <div class="col-md-5">
                  <div class="form-group">
                    <label for="extracost2">Extra Min Cost</label>
                    <input type="text" class="form-control" name="extracost2" id="extracost2" value="<?php echo $price_category[1]['secondary_cost']; ?>" >
                  </div>
                  </div>
                </div>
             
             <br>
             
             <!--3rd row -->
             <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-5">
                  <div class="form-group">
                    <label for="cost3">45Mins</label>
                    <input type="text" class="form-control" name="cost3" id="cost3" value="<?php echo $price_category[2]['primary_cost']; ?>" >
                  </div>
                  </div>
                  <div class="col-md-5">
                  <div class="form-group">
                    <label for="extracost3">Extra Min Cost</label>
                    <input type="text" class="form-control" name="extracost3" id="extracost3" value="<?php echo $price_category[2]['secondary_cost']; ?>" >
                  </div>
                  </div>
                </div>
             <br>
             
             <!--4th row -->
            <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-5">
                  <div class="form-group">
                    <label for="cost4">45Mins</label>
                    <input type="text" class="form-control" name="cost4" id="cost4" value="<?php echo $price_category[3]['primary_cost']; ?>" >
                  </div>
                  </div>
                  <div class="col-md-5">
                  <div class="form-group">
                    <label for="extracost4">Extra Min Cost</label>
                    <input type="text" class="form-control" name="extracost4" id="extracost4" value="<?php echo $price_category[3]['secondary_cost']; ?>" >
                  </div>
                  </div>
                </div>
              
                </div>
                <div class="modal-footer">
                    <span class="pull-right">
                        <button type="submit" class="btn btn-primary">Save Price Master</button> &nbsp; 
                        <span class="btn btn-default" data-dismiss="modal">Close</span> &nbsp; 
                    </span>
                </div>
              </div>
              </form>
              
            </div>
          </div> 
         
         </div>
              <!-- /.box-body -->
             
            
         </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
   

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<script>
    $('input[type=radio][name=price_radio1]').change(function() {
        var methodval = $('input[type=radio][name=price_radio1]:checked').val();
        var current_active_val = $('#current_active_val').val();
        
        if(methodval == current_active_val) {
            $("#price_method_save_btn").prop('disabled', true);
        } else {
            $("#price_method_save_btn").prop('disabled', false);
        }
        
    });
</script>   


