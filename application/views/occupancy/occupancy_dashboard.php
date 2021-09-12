
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Occupancy
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Occupancy Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('errors')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('errors'); ?>
          </div>
        <?php endif; ?>

<style>
    .occ_col {
        width:90px;
        height:55px;
        border:2px solid #e2e2e2;
        border-radius:7px;
        float:left;
        margin:5px; 
        padding:5px; 
        
        color:#fff;
        font-size:13px;
    }
    .greenn {
        background-color:green;
    }
    .greyy {
        background-color:silver;
    }
</style>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Occupancy Slots</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
              <div class="container">
                  <div class="row">
                        <?php $slno = 1; ?>
                        <?php $max_occ = $max_occ['maxocc']; ?>
                        <?php $total_in = count($occupancy_data); ?>
                        <?php $i = 0; ?>
                        
                        <div class="col-md-4">
                            <h3><b>Maximum Occupancy: </b><?php echo $max_occ; ?></h3>
                        </div>
                        
                        <div class="col-md-4">
                            <h3><b>Total Occupied: </b><?php echo $total_in; ?></h3>
                        </div>
                        
                        <div class="col-md-4">
                            <h3><b>Free Slots: </b><?php echo $max_occ - $total_in; ?> </h3>
                        </div>
                        
                        
                        <?php for($i=0; $i<=$max_occ; $i++) { ?>
                            <div class="occ_col <?php if($i <= $total_in) { ?>greyy<?php } else { ?>greenn<?php } ?>" > <?php if($i <= $total_in) { echo '<b>IN: </b>'.date('h:i a', strtotime($occupancy_data[$i]['token_created_at'])); } ?> </div>
                        <?php } ?>
                        <?php /*foreach($occupancy_data as $key => $occ) { ?>
                            <div class="col-md-1 occ_col <?php if($key == 2) { ?>greeny<?php } ?>" ></div>
                        <?php }*/ ?>
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




<script type="text/javascript">

$(document).ready( function () {
    $('#myTable').DataTable();
} );


function calculate_cost(rowid)
{
   
    $.ajax({
      url: "<?php echo base_url(); ?>token/calculate_cost/"+rowid,
      type: 'POST',
      success: function(res){
          console.log(res);
          var obj = JSON.parse(res);
          var total_cost_format = obj.total_price;
          var total_cost_res = total_cost_format.toFixed(2);
        //   var qrsrc = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=Token Number: "+obj.token_id+"%0D%0A%0D%0ATotal Hours: "+obj.total_hours_val+" Hour(s) "+obj.total_mins_val+" Minutes%0D%0A%0D%0ATotal Cost: "+total_cost_res+"%0D%0A%0D%0A&choe=UTF-8";
        var qrsrc = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl="+obj.token_id+"&choe=UTF-8";
          
          document.getElementById('qrres_'+rowid).src = qrsrc;
          
          document.getElementById('totaltimeres_'+rowid).innerHTML = obj.total_hours_val+" Hour(s) "+obj.total_mins_val+" Minutes";
          document.getElementById('totalcostres_'+rowid).innerHTML = '<i>INR </i><b>'+obj.total_price+'</b>';
          document.getElementById('totalcostval_'+rowid).value = obj.total_price;
          
      }
    });
    
}



function printspecdiv(id, rowid)
{
    window.print();
    
    if(id == 'printtoken') {
       $.ajax({
          url: "<?php echo base_url(); ?>token/print_token_save/"+rowid,
          type: 'POST',
          success: function(res){
              
            if(res == 1) {
                
                location.reload();
                
            }
          }
        });
   } else if(id == 'printinvoice') {
       var cost = document.getElementById('totalcostval_'+rowid).value;
       $.ajax({
          url: "<?php echo base_url(); ?>token/print_invoice_save/"+rowid,
          type: 'POST',
          data: {'cost':cost},
          success: function(res){
              
            if(res == 1) {
                
                location.reload();
                
            }
          }
        });
   } else  {
       
   }
}







function printPage(id, rowid)
{
    
   var html="<html> <head><link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'></head>";
   html+= document.getElementById(id).innerHTML;

   html+="</html>";

   var printWin = window.open('','','left=0,top=0,width=100%,height=auto,toolbar=0,scrollbars=0,status  =0');
   printWin.document.write(html);
   printWin.document.close();
   printWin.focus();
   printWin.print();
   printWin.close();
   
   if(id == 'printtoken') {
       $.ajax({
          url: "<?php echo base_url(); ?>token/print_token_save/"+rowid,
          type: 'POST',
          success: function(res){
              console.log(res);
            if(res == 1) {
                
                location.reload();
                
                /*
                $("#token_btn_"+rowid).css("color","green");
                
                $("#token_btn_"+rowid).removeClass('fa-print');
                $("#token_btn_"+rowid).addClass('fa-eye');
                
                var undo_url = "<?php echo base_url(); ?>token/undo_token_gen/"+rowid;
                var confirm_func = "return confirm('Are you sure to undo the token generated?')";
                
                var undobtn = '&nbsp; &nbsp; <a href="'+undo_url+'" onclick="'+confirm_func+'"><i class="fa fa-undo" style="color:maroon;" ></i></a>';
                
                $("#tokenundobtn_"+rowid).html(undobtn);
                */
            }
          }
        });
   } else if(id == 'printinvoice') {
       $.ajax({
          url: "<?php echo base_url(); ?>token/print_invoice_save/"+rowid,
          type: 'POST',
          success: function(res){
              console.log("#invoice_btn_"+rowid);
            if(res == 1) {
                
                location.reload();
                
                /*
                $("#invoice_btn_"+rowid).css("color","green");
                
                $("#invoice_btn_"+rowid).removeClass('fa-money');
                $("#invoice_btn_"+rowid).addClass('fa-eye');
                
                var undo_url = "<?php echo base_url(); ?>token/undo_invoice_gen/"+rowid;
                var confirm_func = "return confirm('Are you sure to undo the invoice generated?')";
                
                var undobtn = '&nbsp; &nbsp; <a href="'+undo_url+'" onclick="'+confirm_func+'"><i class="fa fa-undo" style="color:maroon;" ></i></a>';
                
                $("#invoiceundobtn_"+rowid).html(undobtn);
                */
            }
          }
        });
   } else  {
       
   }
}
   

</script>

