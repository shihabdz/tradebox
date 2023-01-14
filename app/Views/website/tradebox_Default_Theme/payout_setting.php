<div class="payout-content">
    <div class="container mt-4 mb-4">
        <div class="row">
            <div class="col-lg-12">
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
                <div class="row form-design">
                  
                    <div class="col-lg-6 offset-lg-3 mt-5">
                        <h3><?php echo display('payout-setting');?></h3>

                        <div class="mb-3 mt-5">  
                            <?php echo form_open('payout-setting/payeer');?>
                            <label><?php echo display('payeer_wallet');?>  <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input class="form-control" name="wallet_id" value="<?php echo esc(@$payeer_btc->currency_symbol) == 'BTC'?esc(@$payeer_btc->wallet_id):''; ?>" required type="text">
                                <input class="form-control" name="currency_symbol" value="BTC" type="hidden">
                                <input class="form-control" name="currency_symbol1" value="USD" type="hidden">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-kingfisher-daisy"><?php echo display("update") ?></button>
                                </div>
                            </div>
                            <?php echo form_close();?>
                        </div> 
                        <div class="mb-3">  
                            <?php echo form_open('payout-setting/paypal');?>
                            <label><?php echo display('paypal');?> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input class="form-control" name="wallet_id" value="<?php echo esc(@$paypal->wallet_id);?>" required type="text">
                                <input class="form-control" name="currency_symbol" value="USD" type="hidden">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-kingfisher-daisy"><?php echo display("update") ?></button>
                                </div>
                            </div>
                            <?php echo form_close();?>
                        </div> 
                        <div class="mb-3">  
                            <?php echo form_open('payout-setting/stripe');?>
                            <label> <?php echo display('stripe');?> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input class="form-control" name="wallet_id" value="<?php echo esc(@$stripe->wallet_id);?>" required type="text">
                                <input class="form-control" name="currency_symbol" value="USD" type="hidden">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-kingfisher-daisy"><?php echo display("update") ?></button>
                                </div>
                            </div>
                            <?php echo form_close();?>
                        </div> 
                        
                    </div>
                        
                    </div>
                </div>
                
            </div>

        </div>
    </div>
</div>