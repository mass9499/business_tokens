<style>
@media print {
  body * {
    visibility: hidden;
  }
  .footerbtns {
      display: none !important;
  }
  .header_items {
      display: block !important;
  }
  .modal_paymode_select {
    -webkit-appearance: none;
    -moz-appearance: none;
    text-indent: 1px;
    text-overflow: '';
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
      Token
      <small>List</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Token List</li>
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
            <h3 class="box-title">Token List (Date: <b><?php echo date('d-M-Y'); ?></b>)</h3>
            <a href="<?php echo base_url(); ?>token/add_token_view" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Add New</a>
          </div>
          <!-- /.box-header -->
          <div class="box-body" style="overflow-x:scroll;">
            <table id="myTablee" class="table table-bordered table-striped">
              <thead>
              <tr>
                  <th>Drop</th>
                  <th>Sl.No</th>
                  <th>Token ID</th>
                  <th>Created Time</th>
                  <th>Parent Name</th>
                  <th>Parent Phone</th>
                  <th>No. of Children</th>
                  <th>Child Name</th>
                  <th>Age</th>
                  <th>Gender</th>
                  <th>In Time</th>
                  <th>Out Time</th>
                  <th class="text-center">Token</th>
                  <th class="text-center">Invoice</th>
              </tr>
              </thead>
              
              <tbody>
                <?php $slno = 1; ?>
                <?php if(!empty($all_token_list)) { ?>
                <?php foreach($all_token_list as $key => $tokens) { ?>
                <tr>
                    <td class="text-center"><a href="<?php echo base_url(); ?>token/delete_token/<?php echo $tokens['id']; ?>" onclick="return confirm('Are you sure you want to delete this token?')" style="color:red;"><i class="fa fa-trash"></i></a></td>
                    <td><?php echo $slno++?></td>
                    <td><?php echo $tokens['token_id']; ?></td>
                    <td><?php echo date('h:i a', strtotime($tokens['created_at'])); ?></td>
                    <td><?php echo $tokens['parent_name']; ?></td>
                    <td><?php echo $tokens['parent_phone']; ?></td>
                    <td class="text-center"><?php echo $tokens['child_count']; ?></td>
                    <td><?php echo str_replace(';', '<br> ', $tokens['child_name']); ?></td>
                    <td><?php echo str_replace(';', '<br> ', $tokens['child_age']); ?></td> 
                    <td><?php echo str_replace(';', '<br> ', $tokens['child_gender']); ?></td>
                    <td class="text-center" id="<?php echo 'intime_td_'.$tokens['id']; ?>">
                        <?php if($tokens['token_gen_status'] == 1) {
                            echo date('h:i a', strtotime($tokens['token_created_at'])); 
                        } else {
                             echo '<i style="color:grey;">N/A</i>'; 
                        } ?>
                    </td>
                    <td class="text-center" id="<?php echo 'outtime_td_'.$tokens['id']; ?>"><?php if($tokens['invoice_gen_status'] == 1) { echo date('h:i a', strtotime($tokens['invoice_created_at'])); } else { echo '<i style="color:grey;">N/A</i>'; } ?></td>
                    <td> 
                        <center>
                            <span id="<?php echo 'token_gen_td_'.$tokens['id']; ?>" class="text-center">
                                <?php if($tokens['token_gen_status'] == 1) { ?>
                                    <i class="fa fa-qrcode" style="font-size:20px;" data-toggle="modal" id="<?php echo 'token_btn_'.$tokens['id']; ?>" data-target="<?php echo '#token_'.$tokens['id']; ?>" aria-hidden="true"></i>
                                        <?php if($tokens['invoice_gen_status'] == 1) { ?>
                                            <i class="fa fa-check" style="color:green;"></i>
                                        <?php } ?>
                                    <!--span id="<?php echo 'tokenundobtn_'.$tokens['id']; ?>">
                                        &nbsp; &nbsp;
                                        <a href="<?php echo base_url(); ?>token/undo_token_gen/<?php echo $tokens['id']; ?>" onclick="return confirm('Are you sure to undo the token generated?')"><i class="fa fa-undo" style="color:maroon;" ></i></a>
                                    </span-->
                                <?php } else { ?>
                                    <i class="fa fa-print" style="font-size:20px;" data-toggle="modal" id="<?php echo 'token_btn_'.$tokens['id']; ?>" data-target="<?php echo '#token_'.$tokens['id']; ?>" aria-hidden="true"></i>
                                    <span id="<?php echo 'tokenundobtn_'.$tokens['id']; ?>">
                                        
                                    </span>
                                <?php } ?>
                            </span>
                        </center>
                                            
                        <div class="modal fade" id="<?php echo 'token_'.$tokens['id']; ?>" role="dialog">
                            <div class="modal-dialog">
                            
                              <!-- Modal content-->
                              <div class="modal-content" id="printtoken">
                                <div class="modal-header" style="background-color:#3c8dbc;color:white;">
                                  <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                                  <h4  class="modal-title">
                                      <img src="<?php echo base_url();?><?php echo $comp_details['logo_path']; ?>" width="40" height="40" style="border-radius:100px;" />
                                      &nbsp; 
                                      <span> <?php echo $comp_details['company_name']; ?> </span>
                                      <span class="pull-right" style="font-size:17px;"> Date: <?php echo date('d-M-Y'); ?> </span>
                                  </h4>
                                </div>
                                <div class="modal-body">
                                            <div class="row"> 
                                                <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-md-4"><b>TokenNo.</b></div>
                                                            <div class="col-md-8"><?php echo $tokens['token_id']; ?></div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-4"><b>Name</b></div>
                                                            <div class="col-md-8"><?php echo $tokens['parent_name']; ?></div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-4"><b>Phone</b></div>
                                                            <div class="col-md-8"><?php echo $tokens['parent_phone']; ?></div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-4"><b>No. of Child</b></div>
                                                            <div class="col-md-8"><?php echo $tokens['child_count']; ?></div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-4"><b>ChildName</b></div>
                                                            <div class="col-md-8"><?php echo str_replace(';', ', ', $tokens['child_name']); ?></div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-4"><b>In Time</b></div>
                                                            <div class="col-md-8"><?php if($tokens['token_gen_status'] == 1) { echo date('h:i a', strtotime($tokens['token_created_at'])); } else { echo date('h:i a'); } ?></div>
                                                        </div> 
                                                 </div>
                                            
                                                <div class="col-md-4">
                                                    <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?php echo $tokens['token_id']; ?>&choe=UTF-8">
                                                 </div>
                                            </div>
                                            
                                 </div>
                                <div class="modal-footer" style="background-color:#3c8dbc;color:white;">
                                    <span class="pull-left" style="color:silver;">www.business360.co.in</span>
                                    <?php if($tokens['token_gen_status'] == 1) { ?>
                                        <!--<a href="<?php echo base_url(); ?>token/undo_token_gen/<?php echo $tokens['id']; ?>" class="btn btn-warning" onclick="return confirm('Are you sure to undo the token generated?')"><i class="fa fa-undo"></i> Undo</a>-->
                                    <?php } else { ?>
                                        <!--<button type="button" class="btn btn-info" id="print" onclick="printPage('printtoken', '<?php echo $tokens['id']; ?>');" >Print</button>-->
                                        <button type="button" class="btn btn-info footerbtns" id="print" onclick="printspecdiv('printtoken', '<?php echo $tokens['id']; ?>');" >Print</button>  
                                    <?php } ?>
                                  <button type="button" class="btn btn-default footerbtns" id="close" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                              
                            </div>
                         </div>
                         
                    </td>
                    
                    <td> 
                        <center>
                            <span id="<?php echo 'invoice_gen_td_'.$tokens['id']; ?>" class="text-center">
                            <?php if($tokens['token_gen_status'] == 1) { ?>
                                    <?php if($tokens['invoice_gen_status'] == 1) { ?>
                                        <i class="fa fa-eye" style="font-size:20px;" data-toggle="modal" id="<?php echo 'invoice_btn_'.$tokens['id']; ?>" data-target="<?php echo '#invoice_'.$tokens['id']; ?>" aria-hidden="true" onclick="return calculate_cost('<?php echo $tokens['id']; ?>', 'view')"></i>
                                        <?php if($tokens['print_gen_status'] == 1) { ?>
                                            <i class="fa fa-check" style="color:green;"></i>
                                        <?php } else { ?>
                                             <abbr title="Slip not printed yet"><b style="color:maroon;"> !</b></abbr>
                                        <?php } ?>
                                        <span id="<?php echo 'invoiceundobtn_'.$tokens['id']; ?>">
                                            &nbsp; &nbsp;
                                            <a href="<?php echo base_url(); ?>token/undo_invoice_gen/<?php echo $tokens['id']; ?>"><i class="fa fa-undo" style="color:maroon;" onclick="return confirm('Are you sure to undo the invoice generated?')" ></i></a>
                                        </span>
                                    <?php } else { ?>
                                        <i class="fa fa-money" style="font-size:20px;" data-toggle="modal" id="<?php echo 'invoice_btn_'.$tokens['id']; ?>" data-target="<?php echo '#invoice_'.$tokens['id']; ?>" aria-hidden="true" onclick="return calculate_cost('<?php echo $tokens['id']; ?>', 'print')"></i>
                                        <span id="<?php echo 'invoiceundobtn_'.$tokens['id']; ?>">
                                            
                                        </span>
                                    <?php } ?>
                                    
                                <?php } else { ?>
                                    
                                    <i style="color:grey;"> N/A </i>
                                    
                                <?php } ?>
                            </span>
                        </center>
                         
                         <div class="modal fade" id="<?php echo 'invoice_'.$tokens['id']; ?>" role="dialog">
                            <div class="modal-dialog">
                            
                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header" style="background-color:#3c8dbc;color:white;">
                                <h4  class="modal-title">
                                  <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                                  <img src="<?php echo base_url();?><?php echo $comp_details['logo_path']; ?>" width="40" height="40" style="border-radius:100px;" />
                                  &nbsp; 
                                  <span> <?php echo $comp_details['company_name']; ?> </span>
                                  <span class="pull-right" style="font-size:17px;"> Date: <?php echo date('d-M-Y'); ?> </span>
                                </h4>
                                </div>
                                <div class="modal-body" id="printinvoice">
                                    
                                    <span class="header_items" style="display:none; padding-bottom:20px;">
                                        <img src="<?php echo base_url();?><?php echo $comp_details['logo_path']; ?>" width="40" height="40" style="border:2px solid #3C8DBC; border-radius:100px;" />
                                        &nbsp; 
                                        <span style="font-size:22px;"><b> <?php echo $comp_details['company_name']; ?> </b></span>
                                        <span class="pull-right" style="font-size:17px;"> Date: <?php echo date('d-M-Y'); ?> </span>
                                    </span>
                                    
                                            <div class="row"> 
                                                <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-md-6"><b>Token No.</b></div>
                                                            <div class="col-md-6"><?php echo $tokens['token_id']; ?></div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-6"><b>Name</b></div>
                                                            <div class="col-md-6"><?php echo $tokens['parent_name']; ?></div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-6"><b>Phone</b></div>
                                                            <div class="col-md-6"><?php echo $tokens['parent_phone']; ?></div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-6"><b>No. of Child</b></div>
                                                            <div class="col-md-6"><?php echo $tokens['child_count']; ?></div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-6"><b>ChildName</b></div>
                                                            <div class="col-md-6"><?php echo str_replace(';', ', ', $tokens['child_name']); ?></div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-6"><b>In Time</b></div>
                                                            <div class="col-md-6"><?php echo date('h:i a', strtotime($tokens['created_at'])); ?></div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-6"><b>Out Time</b></div>
                                                            <div class="col-md-6" id="<?php echo 'outtimeres_'.$tokens['id']; ?>"></div>
                                                        </div> 
                                                        
                                                 </div>
                                            
                                                <div class="col-md-4">
                                                    <img id="<?php echo 'qrres_'.$tokens['id']; ?>" src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?php echo $tokens['token_id']; ?>&choe=UTF-8">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-7" style="padding-bottom:5px;">
                                                    <span><b>Total Timing: </b></span>
                                                    <span id="<?php echo 'totaltimeres_'.$tokens['id']; ?>"><?php //echo $total_hours_val.' Hour(s) '.$total_mins_val.' Minutes'; ?>
                                                </div>
                                                <div class="col-md-5" style="float:right; padding-bottom:5px;">
                                                    <span><b>Total Cost: </b></span>
                                                    <span id="<?php echo 'totalcostres_'.$tokens['id']; ?>"><?php //echo '<i>INR</i> <b>'.$total_price.'</b>'; ?></span>
                                                </div>
                                                <div class="col-md-5" id="<?php echo 'paymode_input_div_'.$tokens['id']; ?>">
                                                    <span><b>Payment mode: </b></span><br>
                                                    <select class="modal_paymode_select" id="<?php echo 'paymode_input_id_'.$tokens['id']; ?>" name="<?php echo 'paymode_input_'.$tokens['id']; ?>" onchange="paymode_change(this,'<?php echo $tokens['id']; ?>')" style="border-radius:100px; outline:none; border-top:none; border-left:none; border-right:none; border-bottom:1px solid #f2f2f2; padding:5px 10px;">
                                                        <option value="cash">Cash</option>
                                                        <option value="card">Card</option>
                                                        <option value="upi">UPI</option>
                                                    </select>
                                                </div>    
                                                
                                                <div class="col-md-3">
                                                    <span class="<?php echo 'cashpayinputs_'.$tokens['id']; ?>" style="display:none;">
                                                        <span><b>Received: </b></span><br>
                                                        <input id="<?php echo 'receivedres_'.$tokens['id']; ?>" type="text" name="receivedcost" placeholder="Received" value="" onkeyup="calc_received_balance(this, '<?php echo $tokens['id']; ?>')" style="border-radius:100px; outline:none;  border-top:none; border-left:none; border-right:none; border-bottom:1px solid #f2f2f2; padding:5px 10px;">
                                                    </span>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <span class="<?php echo 'cashpayinputs_'.$tokens['id']; ?>" style="display:non;">
                                                        <span><b>Balance &nbsp; : </b></span><br>
                                                        <input id="<?php echo 'balanceres_'.$tokens['id']; ?>" type="text" name="balancecost" placeholder="Balance" value="" style="border-radius:100px; outline:none;  border-top:none; border-left:none; border-right:none; border-bottom:1px solid #f2f2f2; padding:5px 10px;">
                                                    </span>
                                                </div>
                                                
                                                <div class="row">
                                                <div class="col-md-12" id="<?php echo 'paymode_view_div_'.$tokens['id']; ?>" style="display:none;">
                                                    
                                                    <div class="col-md-4">
                                                        <span><b>Pay Mode: </b></span><span id="<?php echo 'paymodeview_'.$tokens['id']; ?>"></span>
                                                    </div>    
                                                    <span id="<?php echo 'cashpayviews_rej'.$tokens['id']; ?>" style="display:none;">
                                                        <div class="col-md-4">
                                                            <span><b>Received: </b></span><span id="<?php echo 'receivedview_'.$tokens['id']; ?>"></span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span><b>Balance: </b></span><span id="<?php echo 'balanceview_'.$tokens['id']; ?>"></span>
                                                        </div>
                                                    </span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                                    
                                                        
                                                    
                                                <input type="hidden" id="<?php echo 'totalcostval_'.$tokens['id']; ?>" value="na" />
                                            </div>
                                            
                                 </div>
                                <div class="modal-footer" style="background-color:#3c8dbc;color:white;">
                                    <span class="pull-left" style="color:silver;">www.business360.co.in</span>
                                     <?php if($tokens['invoice_gen_status'] == 1) { ?>
                                        <button type="button" class="btn btn-info footerbtns" id="<?php echo 'print_invoice_btn_'.$tokens['id']; ?>" onclick="printgenspecdiv('<?php echo $tokens['id']; ?>')" onclick="return confirm('Are you sure to save invoice?')" >Print</button>  
                                        <!--<a href="<?php echo base_url(); ?>token/undo_invoice_gen/<?php echo $tokens['id']; ?>" class="btn btn-warning" onclick="return confirm('Are yoy sure to undo the invoice generated?')"><i class="fa fa-undo"></i> Undo</a>-->
                                    <?php } else { ?>
                                        <!--<button type="button" class="btn btn-info" id="print" onclick="printPage('printinvoice', '<?php echo $tokens['id']; ?>');" onclick="return confirm('Are you sure to save invoice?')" >Print</button>  -->
                                        <button type="button" class="btn btn-info footerbtns" id="<?php echo 'print_invoice_btn_'.$tokens['id']; ?>" onclick="printspecdiv('printinvoice', '<?php echo $tokens['id']; ?>');" onclick="return confirm('Are you sure to save invoice?')" >Print</button>  
                                    <?php } ?>
                                  <button type="button" class="btn btn-default footerbtns" id="close" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                              
                            </div>
                         </div>
                    
                    </td>
                    
                </tr>
               <?php } ?>
               <?php } else { ?>
                <tr>
                    <td colspan="13">No data found for today!</td>
                </tr>
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




<script type="text/javascript">

$(document).ready( function () {
    $('#myTable').DataTable();
} );


function calculate_cost(rowid, printtype)
{
   
    $.ajax({
      url: "<?php echo base_url(); ?>token/calculate_cost/"+rowid,
      type: 'POST',
      success: function(res){
          
          var obj = JSON.parse(res);
          var total_cost_format = obj.total_price;
          var total_cost_res = total_cost_format.toFixed(2);
        var qrsrc = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl="+obj.token_id+"&choe=UTF-8";
          
          document.getElementById('qrres_'+rowid).src = qrsrc;
          
          document.getElementById('outtimeres_'+rowid).innerHTML = obj.out_time;
          document.getElementById('totaltimeres_'+rowid).innerHTML = obj.total_hours_val+" Hour(s) "+obj.total_mins_val+" Mins";
          var obj_total_price = parseInt(obj.total_price) * parseInt(obj.child_count);
          document.getElementById('totalcostres_'+rowid).innerHTML = '<i>₹ </i><b>'+obj.total_price+' x '+obj.child_count+' = '+obj_total_price+'</b>';
          document.getElementById('totalcostval_'+rowid).value = obj_total_price;
          
          if(printtype == 'view') {
              
              $("#paymodeview_"+rowid).text(obj.payment_mode);
              $("#receivedview_"+rowid).text(obj.received);
              $("#balanceview_"+rowid).text(obj.balance);
              
              if(obj.payment_mode == 'cash') {
                  $("#cashpayviews_"+rowid).show();
              } else {
                  $("#cashpayviews_"+rowid).hide();
              }
              
              $(".cashpayinputs_"+rowid).hide();
              
              $("#paymode_input_div_"+rowid).hide();
              $("#paymode_view_div_"+rowid).show();
          } else {
              $(".cashpayinputs_"+rowid).show();
              
              $("#paymode_view_div_"+rowid).hide();
              $("#paymode_input_div_"+rowid).show();
          }
      
      }
      
    });
    
}

function printgenspecdiv(rowid)
{
    window.print();
    
    $.ajax({
      url: "<?php echo base_url(); ?>token/print_gen_save/"+rowid,
      type: 'POST',
      success: function(res){
          
        if(res == 1) {
            
            location.reload();
            
        }
      }
    });
    
    location.reload();
}

function printspecdiv(id, rowid)
{
    
    if(id == 'printtoken') {
       
       window.print();
       
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
    //   var paymode = $('input[type=radio][name=paymode_input_'+rowid+']:checked').val();
       var paymode = $('#paymode_input_id_'+rowid+' option:selected').val();
       
       var received = document.getElementById('receivedres_'+rowid).value;
       var balance = document.getElementById('balanceres_'+rowid).value;
       
       if(paymode == 'cash') {
           if(received != '') {
           
                window.print();
           
                $.ajax({
                  url: "<?php echo base_url(); ?>token/print_invoice_save/"+rowid,
                  type: 'POST',
                  data: {'cost':cost, 'payment_mode':paymode, 'received':received, 'balance':balance},
                  success: function(res){
                      
                    if(res == 1) {
                        
                        location.reload();
                        
                    }
                  }
                });
            
           } else {
               alert('Received amount cannot be empty!');
               return false;
           }
       } else {
           window.print();
       
            $.ajax({
              url: "<?php echo base_url(); ?>token/print_invoice_save/"+rowid,
              type: 'POST',
              data: {'cost':cost, 'payment_mode':paymode, 'received':received, 'balance':balance},
              success: function(res){
                  
                if(res == 1) {
                    
                    location.reload();
                    
                }
              }
            });
        
       }
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

<script>

    /*function paymode_change(dis, rowid)
    {
        var paymodeval = dis.getAttribute('value');
        
        if(paymodeval == 'cash') {
            $("#cashpayinputs_"+rowid).show(300);
        } else {
            $("#cashpayinputs_"+rowid).hide(300);
        }
        
    }*/
    
    function paymode_change(dis, rowid)
    {
        // var paymodeval = dis.getAttribute('value');
        var paymodeval = $('#paymode_input_id_'+rowid).val();

        if(paymodeval == 'cash') {
            $(".cashpayinputs_"+rowid).show(300);
        } else {
            $(".cashpayinputs_"+rowid).hide(300);
        }
        
    }

    /*$('input[type=radio][name=paymode]').change(function() {
        var paymodeval = $('input[type=radio][name=paymode]:checked').val();
        
        if(paymodeval == 'cash') {
            $("#cashpayinputs").show(300);
        } else {
            $("#cashpayinputs").hide(300);
        }
    });*/
</script>

<script>
    function calc_received_balance(dis, rowid)
    {
        var totalcostval = $('#totalcostval_'+rowid).val();
        var receivedval = $('#receivedres_'+rowid).val();
        
        if(receivedval == '') { receivedval = 0; }
        
        var balanceval = parseFloat(receivedval) - parseFloat(totalcostval);
        
        var balanceval_res = balanceval.toFixed(1);
        
        $("#balanceres_"+rowid).val(balanceval_res);
        
    }
</script>


<script>

    function refresh_rows() {
        
        $.ajax({
          url: "<?php echo base_url(); ?>token/refresh_rows",
          success: function(res){
                var data = JSON.parse(res);
                $.each(data, function(i, obj){
                  if(obj.token_gen_status == 1) {
                      
                      var token_html = '<i class="fa fa-qrcode" style="font-size:20px;" data-toggle="modal" id="token_btn_'+obj.id+'" data-target="#token_'+obj.id+'" aria-hidden="true"></i>';
                      
                        if(obj.invoice_gen_status == 1) {
                            token_html += ' <i class="fa fa-check" style="color:green;"></i>';
                        }
                        
                        $("#token_gen_td_"+obj.id).html(token_html);
                      
                      var token_intime = new Date(obj.token_created_at);
                      var token_timeval = token_intime.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })
                      $("#intime_td_"+obj.id).html(token_timeval);
                      
                          if(obj.invoice_gen_status == 1) {
                              
                              var token_funcdef = "calculate_cost("+obj.id+", 'view')";
                              var invoice_html = '<i class="fa fa-eye" style="font-size:20px;" data-toggle="modal" id="invoice_btn_'+obj.id+'" data-target="#invoice_'+obj.id+'" aria-hidden="true" onclick="'+token_funcdef+'"></i>';
                                  
                                  if(obj.print_gen_status == 1) {
                                    
                                    invoice_html += ' <i class="fa fa-check" style="color:green;"></i>';
                                    
                                  } else {
                                      
                                      invoice_html += ' <abbr title="Slip not printed yet"><b style="color:maroon; font-size:20px;" title="Slip not printed yet">!</b></abbr>';
                                      
                                  }
                                  
                                  var onclick_func = "return confirm('Are you sure to undo the invoice generated?')";
                                  invoice_html += ' &nbsp; &nbsp; <a href="<?php echo base_url(); ?>token/undo_invoice_gen/<?php echo $tokens['id']; ?>"><i class="fa fa-undo" style="color:maroon;" onclick="'+onclick_func+'" ></i></a>';
                                  
                                  $("#invoice_gen_td_"+obj.id).html(invoice_html);
                                    
                              var invoice_outtime = new Date(obj.invoice_created_at);
                              var invoice_timeval = invoice_outtime.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })
                              $("#outtime_td_"+obj.id).html(invoice_timeval);
                              
                              var invoiceprintfunc = "printgenspecdiv("+obj.id+")";
                              
                              $("#print_invoice_btn_"+obj.id).attr('onclick', invoiceprintfunc);
                              
                          } else {
                            
                            var invoice_funcdef = "calculate_cost("+obj.id+", 'print')";
                            var invoice_html = '<i class="fa fa-money" style="font-size:20px;" data-toggle="modal" id="invoice_btn_'+obj.id+'" data-target="#invoice_'+obj.id+'" aria-hidden="true" onclick="'+invoice_funcdef+'"></i>';
                            $("#invoice_gen_td_"+obj.id).html(invoice_html);
                            
                          }
                          
                  } else {
                      
                      var html = '<i class="fa fa-print" style="font-size:20px;" data-toggle="modal" id="token_btn_'+obj.id+'" data-target="#token_'+obj.id+'" aria-hidden="true"></i>';
                      $("#token_gen_td_"+obj.id).html(html);
                      
                      var html = '<i style="color:silver;"> N/A </i>';
                      $("#invoice_gen_td_"+obj.id).html(html);
                      
                  }
                
                  
                    
                });
          }
        });
        
    }

    $(document).ready(function(){
    
        refresh_rows();
        
        setInterval(function() {
            refresh_rows();
        }, 1000);
        
    });
</script>