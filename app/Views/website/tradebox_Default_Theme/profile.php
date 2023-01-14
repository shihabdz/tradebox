<div class="profile-header">
    <div id="author-header">
        <img src="<?php echo IMAGEPATH."assets/website/img/author-header.jpg" ?>" alt="">
    </div>
    <div class="container text-center">
         <?php if ($session->get('message') != null) {  ?>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo $session->get('message'); ?>
            </div> 
            <?php } ?>
                
            <?php if ($session->get('exception') != null) {  ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo $session->get('exception'); ?>
            </div>
            <?php } ?>
        <div class="author-avatar">
            <img src="<?php echo $user_info->image?IMAGEPATH.$user_info->image:base_url("/public/assets/images/icons/user.png") ?>" alt="<?php echo esc($user_info->first_name); ?>">
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 form-design">
                <h3 class="author-name"><?php echo esc($user_info->first_name); ?> <?php echo esc($user_info->last_name); ?></h3>
                <p><?php echo esc($user_info->bio); ?></p>

                  <div class="form-group row">
                    <label for="inputPassword" class="col-sm-3 col-form-label"><?php echo display('affiliate_url');?></label>
                    <div class="col-sm-9">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="copyed" aria-label="Recipient's username" aria-describedby="button-addon2" value="<?php echo base_url()?>/register?ref=<?php echo $session->get('user_id')?>">
                            <div class="input-group-append">
                                <button class=" btn btn-kingfisher-daisy" type="button" onclick="copyFunction()"><?php echo display('copy');?></button>
                            </div>
                        </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
<!-- /.End of profile header -->
<div class="profile-info">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-5">
                <div class="bio-info">
                    <dl class="dl-horizontal">
                        <!-- remove from here 2factor authentication -->
                        <dt><?php echo display('user_id') ?> :</dt>
                        <dd><?php echo esc($user_info->user_id); ?></dd>
                        <dt><?php echo display('firstname') ?> :</dt>
                        <dd><?php echo esc($user_info->first_name); ?></dd>
                        <dt><?php echo display('lastname') ?> :</dt>
                        <dd><?php echo esc($user_info->last_name); ?></dd>
                        <dt><?php echo display('email') ?> :</dt>
                        <dd class="d-flex"><?php echo esc($user_info->email); ?> 

                        <?php echo (esc($user_info->verified) == 0 || esc($user_info->verified) == 2|| esc($user_info->verified) == 3 || esc($user_info->verified) == 4|| esc($user_info->verified) == 5|| esc($user_info->verified) == 7 || esc($user_info->verified) == 14 || esc($user_info->verified) == 15 || esc($user_info->verified) == 10)?"<a href='".base_url('email-verify')."' class='btn btn-success'>".display('email-verify')."</a>":((esc($user_info->verified) == 1 || esc($user_info->verified) == 6 || esc($user_info->verified) == 8 || esc($user_info->verified) == 9 || esc($user_info->verified) == 10 || esc($user_info->verified) == 12 || esc($user_info->verified) == 13)?" <span class='verify-color'><i class='fa fa-check-circle'></i></span>":" <a href='".base_url('email-verify')."' class='btn btn-success'>".display('email-verify')."</a>"); ?>


                        </dd>
                        <dt><?php echo display('phone') ?> :</dt>
                        <dd class="d-flex"><?php if(empty($user_info->phone)) {echo "<span class='verify-cancel'>Update your phone number</span>";} else { echo esc($user_info->phone); ?> 
                         <?php echo (esc($user_info->verified) == 0 ||  esc($user_info->verified) == 2|| esc($user_info->verified) == 3 || esc($user_info->verified) == 4|| esc($user_info->verified) == 6|| esc($user_info->verified) == 8 || esc($user_info->verified) == 13 || esc($user_info->verified) == 11)?"<a href='".base_url('phone-verify')."' class='btn btn-success'>".display('phone-verify')."</a>":((esc($user_info->verified) == 1 || esc($user_info->verified) == 5 || esc($user_info->verified) == 7 || esc($user_info->verified) == 9 || esc($user_info->verified) == 10 || esc($user_info->verified) == 12 || esc($user_info->verified) == 14 || esc($user_info->verified) == 15)?" <span class='verify-color'><i class='fa fa-check-circle'></i></span>":" <a href='".base_url('email-verify')."' class='btn btn-success'>".display('phone-verify')."</a>"); }?>



                        </dd>
                        <dt><?php echo display('referral_id') ?> :</dt>
                        <dd><?php echo esc($user_info->referral_id); ?></dd>
                        <dt><?php echo display('language') ?></dt>
                        <dd><?php echo esc($user_info->language); ?></dd>
                        <dt><?php echo display('verify') ?></dt>
                        <dd><?php echo (esc($user_info->verified) == 0 || esc($user_info->verified) == 5|| esc($user_info->verified) == 6|| esc($user_info->verified) == 9)?"<a href='".base_url('profile-verify')."'  class='btn btn-success'>".display('verify')."</a>":((esc($user_info->verified) == 1 || esc($user_info->verified) == 4 || esc($user_info->verified) == 7 || esc($user_info->verified) == 8)?" <span class='verify-color'>Verified <i class='fa fa-check-circle'></i></span>":(($user_info->verified==2 || $user_info->verified==10 || $user_info->verified==11 || $user_info->verified==15)?"<span class='verify-cancel'>Cancel</span>":"<span class='verify-processing'>Processing</span>")); ?></dd>
                        <dt><?php echo display('account_created') ?> :</dt>
                        <dd><?php $date=date_create($user_info->created); echo date_format($date,"jS F Y"); ?></dd>
                        <dt><?php echo display('registered_ip') ?> :</dt>
                        <dd><?php echo esc($user_info->ip); ?></dd>
                        <dt><a class="btn btn-kingfisher-daisy" href="<?php echo base_url("edit-profile") ?>" class="btn btn-kingfisher-daisy"><?php echo display('edit_profile') ?></a></dt>
                        <dd><a class="btn btn-kingfisher-daisy" href="<?php echo base_url("change-password") ?>" class="btn btn-kingfisher-daisy"><?php echo display('change_password') ?></a></dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-6 col-lg-7">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr  class="table-bg">
                                <th scope="col"><?php echo display('access_time') ?></th>
                                <th scope="col"><?php echo display('log_type');?></th>
                                <th scope="col"><?php echo display('user_agent') ?></th>
                                <th scope="col"><?php echo display('user_id') ?></th>
                                <th scope="col"><?php echo display('ip') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user_log as $key => $value) { ?>
                            <tr>
                                <th><?php $date=date_create($value->access_time); echo date_format($date,"jS F Y"); ?></th>
                                <td><?php echo esc($value->log_type); ?></td>
                                <td><?php $user_agent = json_decode($value->user_agent, true); echo " Browser: ".esc($user_agent['browser'])." <br>Platform: ".esc($user_agent['platform']) ?></td>
                                <td><?php echo esc($value->user_id); ?></td>
                                <td><?php echo esc($value->ip); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>