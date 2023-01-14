<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="ajaxtable" class="table table-bordered table-hover">
                <thead>
                    <tr> 
                        <th><?php echo display('sl_no') ?></th>
                        <th><?php echo display('user_id') ?></th>
                        <th><?php echo display('fullname') ?></th>
                        <th><?php echo display('referral_id') ?></th>
                        <th><?php echo display('email') ?></th>
                        <th><?php echo display('mobile') ?></th>
                        <th><?php echo display('status') ?></th> 
                        <th><?php echo display('verify_email') ?></th> 
                        <th><?php echo display('verify_phone') ?></th> 
                        <th><?php echo display('verify') ?></th> 
                        <th><?php echo display('action') ?></th>  
                    </tr>
                </thead>
                <tbody>
                     
                </tbody>
            </table>
        </div>
  </div>
</div>
<script src="<?php echo BASEPATH.'assets/plugins/sweetalert/sweetalert.js' ?>" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo BASEPATH.'assets/plugins/sweetalert/sweetalert.css' ?>" />
<script src="<?php echo BASEPATH.'assets/js/user.js?v=2.2' ?>" type="text/javascript"></script>