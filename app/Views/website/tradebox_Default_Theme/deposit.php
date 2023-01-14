<div class="cryp_wrapper">
  <div class="col-lg-4 offset-lg-4 form-content login mt-4 mb-4">
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
   <!-- /.end of alert message -->
   <div class="deposit-info mb-0 form-design">
      <h3 class="user-login-title mb-3"><?php echo display('deposit');?></h3>
      <?php echo form_open_multipart('deposit/payment_gateway', array('name'=>'deposit_form', 'id'=>'deposit_form', 'class'=>'mb-4'));?>
    

      <div class="form-group">
         <label for="deposit_type" class=""><?php echo display('deposit_type') ?> <span class="text-danger">*</span></label>
         <select class="custom-select basic-single" name="deposit_type" required id="deposit_type">
            <option><?php echo display('select_option');?></option>
            <?php if($deposit_type) { foreach($deposit_type as $dtype) { ?>
                <option value="<?php echo $dtype->identifire ;?>"><?php echo display($dtype->identifire) ?></option>
           <?php  }} ?>           
         </select>
      </div>
      <div class="form-group">
         <label for="crypto_coin" id="coinlabel" class=""><?php echo display('currency');?> <span class="text-danger">*</span></label>
         <select class="custom-select basic-single" name="crypto_coin" id="crypto_coin"  required>
            <option><?php echo display('select_option');?></option>
         </select>
      </div>

       <div class="form-group" id="deposit_with_block">
         <label for="payment_method"  class=""><?php echo display('deposit_with');?> <span class="text-danger">*</span></label>
         <select class="custom-select basic-single" name="deposit_with" required  id="deposit_with">
            <option value=""><?php echo display('deposit_with');?></option>
            <?php if($network) {?> <!-- if BEP20 or ERC20 Module is available then this option is enable -->
               <option value="blockchain_network"><?php echo display('blockchain_network');?></option>
            <?php } ?>            
            <option value="payment_gateway"><?php echo display('payment_gateway');?></option>
         </select>
          <span id="notavailable" class="form-text text-danger"></span> 
      </div>


      <div class="form-group" id="payment_block">
         <label for="payment_method" id="depositmethodlabel" class=""><?php echo display('deposit_method');?> <span class="text-danger">*</span></label>
         <select class="custom-select basic-single" name="method" required  id="payment_method">
            <option value=""><?php echo display('deposit_method');?></option>
         </select>
         <!-- <span id="fee" class="form-text text-success"></span> -->
      </div>
     

      <div class="form-group" id="deposit_amount_block">
         <label for="deposit_amount" class=""><?php echo display('deposit_amount');?> <span class="text-danger">*</span></label>
         <input class="form-control" name="amount" step="any" min="0" type="number" id="deposit_amount"  autocomplete="off" required>
      </div>      
    
      <button type="submit" class="btn btn-kingfisher-daisy w-md m-b-5 mt-3"><?php echo display('deposit');?></button>
      <a href="<?php echo base_url();?>" class="btn btn-danger w-md m-b-5 mt-3"><?php echo display('cancel')?></a>
   </div>
   <input type="hidden" name="level" id="level" value="deposit">
    <input type="hidden" name="fees" id="fees" value="0">
   <?php echo form_close();?>  
  </div>
</div>