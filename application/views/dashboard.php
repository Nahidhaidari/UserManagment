

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang['title'] ?>
        <small><?php echo $lang['title_small'] ?></small>
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php if($this->session->userdata('userId')==1){
                      echo $this->db->query('select count(*) as count from tbl_tasks')->result()[0]->count;
                    }else{
                      echo $this->db->query('select count(*) as count from tbl_tasks where user_id='.$this->session->userdata('userId'))->result()[0]->count;
                  } ?></h3>
                  <p><?=$lang['tasks']?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo base_url(); ?>task" class="small-box-footer"><?=$lang['more-info']?>  <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php if($this->session->userdata('userId')==1){
                      echo $this->db->query('select count(*) as count from tbl_tasks where status=0')->result()[0]->count;
                    }else{
                      echo $this->db->query('select count(*) as count from tbl_tasks where status=0 and user_id='.$this->session->userdata('userId'))->result()[0]->count;
                  } ?><sup style="font-size: 20px"></sup></h3>
                  <p><?=$lang['c-tasks']?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="<?php echo base_url(); ?>task" class="small-box-footer"> <?=$lang['more-info']?> <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <?php if($this->session->userdata('userId')==1){ ?>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $this->db->query('select count(*) as count from tbl_users where userId!=1')->result()[0]->count; ?></h3>
                  <p><?=$lang['users']?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo base_url(); ?>userListing" class="small-box-footer"><?=$lang['more-info']?><i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <?php } ?>
          </div>
    </section>
</div>