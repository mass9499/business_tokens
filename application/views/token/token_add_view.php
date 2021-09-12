

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add
        <small>Token</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Token</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          
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
              <h3 class="box-title"></h3>
            </div>
            <form role="form" action="<?php echo base_url(); ?>token/token_save" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>
                <div class="row">
                         <div class="col-md-4">
                         <div class="form-group">
                        <label for="tokenid">Token ID</label>
                        <input type="text" class="form-control" id="tokenid" name="token_id" value="<?php echo date('YmdHis'); ?>" autocomplete="off" readonly >
                        </div>
                        </div>
    
                        <div class="col-md-4">
                        <div class="form-group">
                      <label for="name">Parent Name</label>
                      <input type="name" class="form-control" id="name" name="parent_name" placeholder="Name" autocomplete="off" required>
                      </div>
                      </div>
                
                
                    <div class="col-md-4">
                    <div class="form-group">
                      <label for="phone"> Phone No</label>
                      <input type="number" class="form-control" id="phone" name="parent_phone" placeholder="phone" autocomplete="off" required>
                    </div>
                    </div>
                </div>
                
                <hr>
                <input type="hidden" name="child_count" id="childcount" value="1">
                <div id="childrowscontainer">
                    <div class="row childrows" id="childrow1">
                        <div class="col-md-4">
                            <div class="form-group">
                              <label for="childname">Child Name</label>
                              <input type="text" class="form-control" name="child_name[]" placeholder="Child Name" autocomplete="off" required>
                            </div>
                        </div>
                    
                        <div class="col-md-4">
                            <div class="form-group">
                              <label for="age">Child Age</label>
                              <input type="number" class="form-control" name="child_age[]" placeholder="Age" autocomplete="off" required>
                            </div>
                        </div>
                    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gender">Child Gender</label>
                                <select class="form-control" name="child_gender[]" id="sel1" required>
                                <option value="">Select Gender</option>
                                <option value="Boy">Boy</option>
                                <option value="Girl">Girl</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <span class="pull-right">
                    <span class="btn btn-info btn-sm" id="add_child_btn" onclick="add_child()"><i class="fa fa-plus"></i> Add more Child</span>
                    &nbsp; 
                    <span class="btn btn-danger btn-sm" id="remove_child_btn" onclick="remove_child()" style="display:none;"><i class="fa fa-minus"></i></span>
                </span>
                
                <br><br>
                
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                                <label for="gender">Price Master</label>
                                <select class="form-control" name="price_master" id="price_master" required>
                                    <option value="">Select Price Master</option>
                                    <?php foreach($price_master as $pm) { ?>
                                        <option <?php if($pm['active_status'] == 1) { ?> selected <?php } ?> value="<?php echo $pm['id']; ?>"><?php echo $pm['title'].' - Primary cost: '.$pm['primary_cost'].' | Secondary cost: '.$pm['secondary_cost']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                    <center>
                        <button type="submit" class="btn btn-primary">Save Token</button>
                        <a href="<?php echo base_url('dashboard') ?>" class="btn btn-warning">Back</a>
                    </center>
              </div>
            </form>
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

<div id="childroworig" style="display:none;">
    <div class="row childrows">
        <div class="col-md-4">
            <div class="form-group">
              <label for="childname">Child Name</label>
              <input type="text" class="form-control" name="child_name[]" placeholder="Child Name" autocomplete="off" required>
            </div>
        </div>
    
        <div class="col-md-4">
            <div class="form-group">
              <label for="age">Child Age</label>
              <input type="number" class="form-control" name="child_age[]" placeholder="Age" autocomplete="off" required>
            </div>
        </div>
    
        <div class="col-md-4">
            <div class="form-group">
                <label for="gender">Child Gender</label>
                <select class="form-control" name="child_gender[]" id="sel1" required>
                <option>Select Gender</option>
                <option value="Boy">Boy</option>
                <option value="Girl">Girl</option>
                </select>
            </div>
        </div>
    </div>
</div>

<script>
    function add_child()
    {
        $("#remove_child_btn").css("display","inline");
        var old_child_count = $("#childcount").val();
        
        $("#childroworig > div").clone().appendTo("#childrowscontainer");
        
        var new_child_count = parseInt(old_child_count) + parseInt(1);
        $("#childcount").val(new_child_count);
    }
    
    function remove_child()
    {
        var old_child_count = $("#childcount").val();
        
        if(old_child_count > 1) {
            $("#childrowscontainer .childrows:last-child").remove();
        
            var new_child_count = parseInt(old_child_count) - parseInt(1);
            $("#childcount").val(new_child_count);
            if(new_child_count == 1) {
                $("#remove_child_btn").css("display","none");
            }
        } else {
            $("#remove_child_btn").css("display","none");
        }
        
    }
</script>