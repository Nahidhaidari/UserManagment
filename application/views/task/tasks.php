<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i><?php echo $lang['title'] ?>
        <small><?php echo $lang['title_small'] ?></small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <?php if($this->session->userdata('userId')==1){ ?>
                        <a class="btn btn-primary" href="<?php echo base_url(); ?>task/addNew"><i class="fa fa-plus"></i> <?php echo $lang['btn_add'] ?></a>
                        <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $lang['title_small'] ?></h3>
                    <div class="box-tools">
                     
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th><?php echo $lang['col_id'] ?></th>
                        <th><?php echo $lang['col_name'] ?></th>
                        <th><?php echo $lang['col_description'] ?></th>
                        <th><?php echo $lang['col_user'] ?></th>
                        <th><?php echo $lang['col_status'] ?></th>
                        <th><?php echo $lang['col_date'] ?></th>
                        <th class="text-center"><?php echo $lang['col_action'] ?></th>
                    </tr>
                    <?php
                    if(!empty($taskRecords))
                    {
                    //  echo "<pre>";
                    //  print_r($taskRecords);
                    //  echo "</pre>";
                    //  die;
                        foreach($taskRecords as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $record->id ?></td>
                        <td><?php echo $record->name ?></td>
                        <td><?php echo $record->description ?></td>
                        <td><?php echo $record->user_name ?></td>
                        <td><?php  if($record->status==0){
                            echo "<span class='label label-success'>Copmlete</span>";  
                        }else{
                            echo "<span class='label label-warning'>Pending</span>";  

                        } ?></td>
                        <td><?php echo $record->create_date ?></td>
                        <td class="text-center">
                            <?php if($this->session->userdata('userId')==1){ ?>
                                <a class="btn btn-sm btn-danger" href="<?php echo base_url().'task/deleteTask/'.$record->id ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                <?php }else{
                                    ?>
                                <a class="btn btn-sm btn-success" href="<?php echo base_url().'task/completeTask/'.$record->id ?>" title="Complete"><i class="fa  fa-street-view"></i></a>
                                <?php
                            } ?>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
