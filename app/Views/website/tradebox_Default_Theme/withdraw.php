<div class="col-lg-4 offset-lg-4  form-content login mt-4 mb-4">
    <div class="mb-4 form-design">
        <!-- alert message -->
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
        <!-- /.alert message -->
        <h3 class="user-login-title mb-3"><?php echo display('withdraw');?></h3>
        <?php echo form_open('withdraw',array('name'=>'withdraw','id'=>'withdraw_form'));?>
        <div class="form-group">
           <label for="withdraw_type" class=""><?php echo display('withdraw');?> <span class="text-danger">*</span></label>
           <select class="form-control basic-single" name="withdraw_type" id="withdraw_type" required>
              <option><?php echo display('select_option');?></option>
              <?php if($withdraw_type) { foreach($withdraw_type as $dtype) { ?>
                <option value="<?php echo $dtype->identifire ;?>"><?php echo display($dtype->identifire) ?></option>
           <?php  }} ?>  
           </select>
        </div>
        <div class="form-group">
           <label for="crypto_coin" id="coinlabel" class=""><?php echo display('coin');?> <span class="text-danger">*</span></label>
           <select class="form-control basic-single" name="crypto_coin" id="crypto_coin"  required>
              <option><?php echo display('select_option');?></option>
           </select>
        </div>
       
         <div class="form-group" id="deposit_with_block">
         <label for="payment_method"  class=""><?php echo display('withdraw_with');?> <span class="text-danger">*</span></label>
         <select class="custom-select basic-single" name="withdraw_with" required  id="withdraw_with">
            <option value=""><?php echo display('withdraw_with');?></option>
            <?php if($network) {?> <!-- if BEP20 or ERC20 Module is available then this option is enable -->
               <option value="blockchain_network"><?php echo display('blockchain_network');?></option>
            <?php } ?>            
            <option value="payment_gateway"><?php echo display('payment_gateway');?></option>
         </select>
          <span id="notavailable" class="form-text text-danger"></span> 
      </div>
        <div class="form-group" id="payment_block">
           <label for="payment_method"  id="depositmethodlabel" class=""><?php echo display('payment_method');?> <span class="text-danger">*</span></label>
           <select class="form-control basic-single" name="method" id="payment_method"  onchange="WalletId(this.value);" >
              <option><?php echo display('payment_method')?></option>
           </select>
           <div id="walletidis" class="form-text text-success"></div>
        </div>
        <div id="coinwallet" class="form-group"></div>

       <div class="form-group" id="waletfield">
         <label for="walletid" class=""><?php echo display('wallet_id');?></label>
         <input class="form-control" name="walletid" id="walletid" required >
         <!-- <input type="hidden" name="method" id="method" value="bep20"> -->
      </div>

        <div class="form-group">
           <label for="amount" class=""><?php echo display('balance');?> <span class="text-danger">*</span></label>
           <input class="form-control" name="amount" step="any" min="0" type="number" id="amount" onkeyup="widthdrawFee()" autocomplete="off" required>
           <span id="fee" class="form-text text-success"></span>
        </div>



        <div class="form-group row">
           <label for="p_name" class="col-sm-5"><?php echo display('otp_send_to')?> <span class="text-danger">*</span></label>
           <div class="col-sm-7">
            <?php if($smsPermission->withdraw == 1){ ?>
              <div class="custom-control custom-radio custom-control-inline">
                 <input type="radio" id="inlineRadio1" value="1" name="varify_media" class="custom-control-input">
                 <label class="custom-control-label" for="inlineRadio1"><?php echo display('sms')?></label>
              </div>
            <?php } ?>
            <?php if($emailPermission->withdraw == 1){ ?>
              <div class="custom-control custom-radio custom-control-inline">
                 <input type="radio" id="inlineRadio2" value="2" name="varify_media" class="custom-control-input">
                 <label class="custom-control-label" for="inlineRadio2"><?php echo display('email')?></label>
              </div>
            <?php } ?>
           </div>
        </div>      
        <input type="hidden" name="level" value="withdraw">
         <input type="hidden" name="fees" id="fees" value="">
        <div class=" m-b-15">
           <button type="submit" disabled class="btn btn-kingfisher-daisy"><?php echo display('withdraw');?></button>
           <a href="<?php echo base_url();?>" class="btn btn-danger"><?php echo display('cancel')?></a>
        </div>
        <?php echo form_close();?>
    </div>
</div>
     