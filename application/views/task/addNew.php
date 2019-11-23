<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> <?php echo $lang['title'] ?>
        <small><?php echo $lang['title_small'] ?></small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $lang['lbl_details'] ?></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUser" action="<?php echo base_url() ?>task/addNewTask" method="post" role="form"  enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name"><?php echo $lang['lbl_taskname'] ?></label>
                                        <input type="text" class="form-control required" value="<?php ?>" id="name" name="name" maxlength="128">
                                    </div>
                                    <div class="form-group">
                                        <label for="email"><?php echo $lang['lbl_taskdescription'] ?></label>
                                        <textarea class="form-control" name="description" id="" cols="30" rows="5"></textarea>
                                    </div>
                                    <select class="form-control required" id="user" name="user">
                                            <option value="0">Select User</option>
                                            <?php
                                            if(!empty($users))
                                            {
                                                foreach ($users as $usr)
                                                {
                                                    ?>
                                                    <option value="<?php echo $usr->userId ?>"><?php echo $usr->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                    </select>
                                    
                                </div>
                                
                            </div>

                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="<?php echo $lang['btn_submit'] ?>" />
                            <input type="reset" class="btn btn-default" value="<?php echo $lang['btn_reset'] ?>" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>