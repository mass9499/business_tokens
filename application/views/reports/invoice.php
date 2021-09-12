<!--<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.css" rel="stylesheet" />-->
<!--<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.css" rel="stylesheet" />-->

<style>
@media print {
  body * {
    visibility: hidden;
  }
  #printtoken, #printtoken * {
    visibility: visible;
  }
  #printtoken {
    position: absolute;
    left: 0;
    top: 0;
  }
  #printinvoice, #printinvoice * {
    visibility: visible;
  }
  #printinvoice {
    position: absolute;
    left: 0;
    top: 0;
  }
  
    .col-md-1 {width:8%;  float:left;}
    .col-md-2 {width:16%; float:left;}
    .col-md-3 {width:25%; float:left;}
    .col-md-4 {width:33%; float:left;}
    .col-md-5 {width:42%; float:left;}
    .col-md-6 {width:50%; float:left;}
    .col-md-7 {width:58%; float:left;}
    .col-md-8 {width:66%; float:left;}
    .col-md-9 {width:75%; float:left;}
    .col-md-10{width:83%; float:left;}
    .col-md-11{width:92%; float:left;}
    .col-md-12{width:100%; float:left;} 
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Invoice
      <small>List</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Invoice List</li>
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

        <div class="box">
          <div class="box-header">
            <h3 class="box-title"></h3>
           <form method="post" action="<?php echo base_url(); ?>token/invoice" style="border-bottom:1px solid #e2e2e2;">
               <input type="hidden" name="form_submit" value="1">
            <div class="row">  
                <div class="col-md-4">
                   <div class="form-group">
                   <label>From Date</label>
                   <input type="date" class="form-control" name="from_date" id="from_date" value="<?php echo $from_date; ?>">
                   </div>
              </div>
              <div class="col-md-4">
                   <div class="form-group">
                   <label>To Date</label>
                   <input type="date" class="form-control" name="to_date" id="to_date" value="<?php echo $to_date; ?>">
                   </div>
              </div>
              <div class="col-md-4"  style="margin-top: 25px;">
                   <div class="form-group" >
                  <input type="submit" class="btn btn-primary" class="form-control" id="filter" value="Search">
                   </div>
              </div>
           </div> 
           <br>
          </form>
          
          <!-- /.box-header -->
          <div class="box-body" style="overflow-x:scrolll;">
              <br>
            <table id="myTable" class="table table-bordered table-striped">
              <thead>
                <tr style="background-color:#e2e2e2;">
                  <th colspan="2" style="font-size:18px;">Total No. of Invoice: </th>
                  <th style="font-size:18px;"># <?php echo $total_tokens; ?></th>
                  <th colspan="2" style="font-size:18px;">Total Cost: </th>
                  <th colspan="6" style="font-size:18px;">₹ <?php echo $total_cost; ?></th>
                </tr>
              <tr>
                  <th>Sl.No</th>
                  <th>Token ID</th>
                  <th>Parent Name</th>
                  <th>Phone No.</th>
                  <th>Child Name</th>
                  <!--<th>Age</th>-->
                  <!--<th>Gender</th>-->
                  <th>Date</th>
                  <th>In</th>
                  <th>Out</th>
                  <th class="text-center">Pay Mode</th>
                  <th class="text-center">Cost</th>
               </tr>
              </thead>
              
              <tbody>
                  <?php $slno = 1; ?>
                <?php foreach($all_token_list as $key => $tokens) { ?>
                <?php $sl_no = $slno++; ?>
                <tr>
                    <td><?php echo $sl_no; ?></td>
                    <td><?php echo $tokens['token_id']; ?></td>
                    <td><?php echo $tokens['parent_name']; ?></td>
                    <td><?php echo $tokens['parent_phone']; ?></td>
                    <td><?php echo $tokens['child_name']; ?></td>
                    <!--<td><?php echo $tokens['child_age']; ?> </td> -->
                    <!--<td><?php echo $tokens['child_gender']; ?></td>-->
                    <td><?php echo date('d-m-Y', strtotime($tokens['created_at'])); ?> </td>
                    <td><?php echo date('h:i a', strtotime($tokens['token_created_at'])); ?></td>
                    <td><?php echo date('h:i a', strtotime($tokens['invoice_created_at'])); ?></td>
                    <td class="text-center"><?php echo $tokens['payment_mode']; ?></td>
                    <td class="text-center"><?php if($tokens['total_cost'] != '') { echo '₹ '.$tokens['total_cost']; } else { echo '<i style="color:silver;"> N/A </i>'; } ?></td>
                  </tr>
                  <?php if($sl_no == $total_tokens) { ?>
                    <tr>
                       <td style="color:transparent;"><?php echo $sl_no + 1; ?></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <th class="text-center">Total </th>
                       <th class="text-center">₹ <?php echo $total_cost; ?></th>
                   </tr>
                  <?php } ?>
               <?php } ?>
              </tbody>

            </table>
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

<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<!--<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {
  
  var fromdate = $("#from_date").val();
  var todate = $("#to_date").val();
  
  $('#myTable').DataTable({
    dom: 'Bfrtip',
    buttons: [{
      extend: 'pdf',
      title: 'Invoice report ( '+fromdate+' - '+todate+' )',
      filename: 'Invoice_report_from_'+fromdate+'_to_'+todate
    }, {
      extend: 'excel',
      title: 'Invoice report ( '+fromdate+' - '+todate+' )',
      filename: 'Invoice_report_from_'+fromdate+'_to_'+todate
    }]
  });
 
  $(".dt-buttons > a").css({"border":"none"});
  $(".dt-buttons > a > span").css({"padding":"3px 15px", "border-radius":"13px", "background-color":"#0b3360 !important", "color":"#fff !important"});
  
});

// $(document).ready( function () {
//     $('#myTable').DataTable({
//         buttons: [
//             {
//                 extend: 'excel',
//                 text: 'Save current page',
//                 exportOptions: {
//                     modifier: {
//                         page: 'current'
//                     }
//                 }
//             }
//         ]
//     });
//  });

function calculate_cost(rowid)
{
   
    $.ajax({
      url: "<?php echo base_url(); ?>token/calculate_cost/"+rowid,
      type: 'POST',
      success: function(res){
          
          var obj = JSON.parse(res);
          var qrsrc = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=Token Number: "+obj.token_id+"%0D%0A%0D%0ATotal Hours: "+obj.total_hours_val+" Hour(s) "+obj.total_mins_val+" Minutes%0D%0A%0D%0ATotal Cost: "+obj.total_price+"%0D%0A%0D%0A&choe=UTF-8";
          
          document.getElementById('qrres_'+rowid).src = qrsrc;
          
          document.getElementById('totaltimeres_'+rowid).innerHTML = obj.total_hours_val+" Hour(s) "+obj.total_mins_val+" Minutes";
          document.getElementById('totalcostres_'+rowid).innerHTML = '<i>INR </i><b>'+obj.total_price+'</b>';
          
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
              console.log(res);
            if(res == 1) {
                
                location.reload();
                
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



