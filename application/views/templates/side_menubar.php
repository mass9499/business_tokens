
<style>
	
	.ui-datepicker-inline.ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all {
		width:100% !important;
		background-color:transparent !important;
		color:#fff !important;
		border-radius:0px;
		border:none;
	}
	
	.ui-datepicker-header.ui-widget-header.ui-helper-clearfix.ui-corner-all {
		background-color:transparent !important;
		color:#fff;
		border:none;
	}
	
	.ui-state-default {
		background-color:transparent !important;
		border:none !important;
		color:#fff !important;
		
	}
	
	.ui-icon.ui-icon-circle-triangle-w, .ui-icon.ui-icon-circle-triangle-e {
		background-color: orange;
		border-radius: 2px;
	}
	
	 .ui-datepicker-days-cell-over.ui-datepicker-current-day.ui-datepicker-today {
		 background-color:orange !important;
		 border-radius:4px;
	 }
	 
	 .treeview_menu_active { display:block; }
</style>

<!--style>
	.datepicker-switch { color:silver; } .datepicker-switch:hover { color:black; }
	.next { color: #fff; } .next:hover { color: black; }
	.prev { color: #fff; } .prev:hover { color: black; }
	.dow { color: #fff; }
	.day { color: silver; }
	.month { color: #fff; } .month:hover { color: black; } .month.focused { color:grey; }
	.year { color: #fff; } .year:hover { color: black; } .year.focused { color:grey; }
</style-->


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<aside class="main-sidebar" style="position:fixed;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        
        <li class="treeview" id="OrderMainNav">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Token Billing</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
               <ul class="treeview-menu treeview_menu_active">
                  <li id="createOrderSubMenu"><a href="<?php echo base_url('token/add_token_view') ?>"> &nbsp; &nbsp; &nbsp; &nbsp; <i class="fa fa-circle-o"></i> New Token</a></li>
                  <li id="manageOrderSubMenu"><a href="<?php echo base_url('token/token_list') ?>"> &nbsp; &nbsp; &nbsp; &nbsp; <i class="fa fa-circle-o"></i>Token List</a></li>
                  <!--<li id="manageOrderSubMenu"><a href="<?php echo base_url('occupancy/index') ?>"> &nbsp; &nbsp; &nbsp; &nbsp; <i class="fa fa-circle-o"></i>Occupancy Slot</a></li>-->
                  <li id="manageOrderSubMenu"><a href="<?php echo base_url('token/token_pricemaster_view') ?>"> &nbsp; &nbsp; &nbsp; &nbsp; <i class="fa fa-circle-o"></i>Price Master</a></li> 
               </ul>
            </li>
          
          
            <li class="treeview" id="ReportMainNav">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Reports</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu treeview_menu_active">
                  <li id=""><a href="<?php echo base_url('token/invoice') ?>"> &nbsp; &nbsp; &nbsp; &nbsp; <i class="fa fa-circle-o"></i>Date wise</a></li>
                  <li id=""><a href="<?php echo base_url('reports') ?>"> &nbsp; &nbsp; &nbsp; &nbsp; <i class="fa fa-circle-o"></i>Month Wise</a></li>
               </ul>
            </li>
            
        <br><br><br>
        <div style="padding:3px;">
            <div class="calendarview" style="border-top:1px solid orange; border-bottom:1px solid orange;">
    			<div id="holder"></div>
    			<div id="sidebardatepicker"></div>						
    		</div>
		</div>
      	<div style="position: absolute; bottom: 0px; width:100%;">
		   <abbr title="Company info"><a href="<?php echo base_url('company/') ?>"><div class="col-md-3 col-xs-3 btn btn-info" style="border-radius:0px; padding:10px 0px;"><center><i class="fa fa-info"></i></center></div></a></abbr>
           <abbr title="Profile details"><a href="<?php echo base_url('users/profile/') ?>"><div class="col-md-3 col-xs-3 btn btn-primary" style="border-radius:0px; padding:10px 0px;"><center><i class="fa fa-user"></i> </center></div></a></abbr>
           <abbr title="Settings"><a href="<?php echo base_url('users/setting/') ?>"><div class="col-md-3 col-xs-3 btn btn-warning" style="border-radius:0px; padding:10px 0px;"><center><i class="fa fa-wrench"></i> </center></div></a></abbr>
           <abbr title="Sign-out"><a onclick="return confirm_logout()" href="#"><div class="col-md-3 col-xs-3 btn btn-danger" style="border-radius:0px; padding:10px 0px;"><center><i class="glyphicon glyphicon-log-out"></i> </center></div></a></abbr>
		<a id="logoutoriginalbtn" href="<?php echo base_url('auth/logout') ?>" style="display:none;"><div class="col-md-3 col-xs-3 btn btn-danger" style="border-radius:0px;"><center><i class="glyphicon glyphicon-log-out"></i> </center></div></a>
		</div>
		
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  
  <script>	
		function confirm_logout()
		{
			if(confirm('Are you sure you want to logout?') == true) {
				//$("#logoutoriginalbtn").click();
				window.location.href='<?php echo base_url('auth/logout') ?>';
			} else {
				return false;
			}				
		}
  </script>
  
	<script type="text/javascript">
	  $(function() {
		$("#sidebardatepicker").datepicker({
		  numberOfMonths:1	  
		});
	  });
	</script>