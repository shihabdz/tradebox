<div class="cryp_wrapper">
    <div class="profile-verify mt-4 mb-4">
        <div class="user-login form-design">
            <h3 class="user-login-title mb-4"><?php echo display('verify_email');?></h3>
            <p class="text-white"> <?php echo display('verify_text_email');?></p>
            <?php echo form_open_multipart("email-verify") ?>
                               
                <div class="form-group row">
                    <label for="verify_code" class="col-md-4 col-form-label"><?php echo display('verify_code') ?> <i class="text-danger">*</i></label>
                    <div class="col-md-8">
                        <input name="verify_code" type="text" class="form-control" id="verify_code" placeholder="" value="" required="">
                    </div>
                </div>                       
                
               
                <span id="verify_field"></span>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-kingfisher-daisy"><?php echo display('verify_email') ?></button>
                    </div>
                </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>