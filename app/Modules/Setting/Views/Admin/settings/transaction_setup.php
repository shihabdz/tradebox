<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href="#" class="action-item"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="border_preview">
                    <?php echo form_open_multipart("backend/setting/transaction-save") ?>
                    <div class="row">
                        <div class="form-group col-lg-2">
                            <label class="font-weight-600" for="currency_symbol"><?php echo display('coin') ?><i class="text-danger">*</i></label>
                            <select class="form-control basic-single" name="currency_symbol">
                                <option value="">--<?php echo display("select_option") ?>--</option>
                                <?php foreach ($coins as $key => $value) { ?>
                                    <option value="<?php echo esc($value->symbol); ?>"><?php echo esc($value->coin_name. ' ('.$value->symbol.')'); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-lg-2">
                            <label class="font-weight-600"><?php echo display('transaction_type');?> <i class="text-danger">*</i></label>
                            <select class="form-control" name="trntype"  >
                               <option value="">--<?php echo display("select_option") ?>--</option>
                               <option value="DEPOSIT"><?php echo display('deposit');?></option>
                               <option value="WITHDRAW"><?php echo display('withdraw');?></option>
                               <option value="TRANSFER"><?php echo display('transfer');?></option>
                           </select>
                       </div> 
                      
                        <div class="form-group col-lg-2">
                            <label class="font-weight-600"><?php echo display('account_type');?> <i class="text-danger">*</i></label>
                            <select class="form-control" name="acctype"  >
                               <option value="">--<?php echo display("select_option") ?>--</option>
                               <option value="VERIFIED"><?php echo display('verified');?></option>
                               <option value="UNVERIFIED"><?php echo display('unverified');?></option>
                           </select>
                       </div>

                       <div class="form-group col-lg-2">
                            <label class="font-weight-600" for="lower">Min <?php echo display('limit_amount');?> <i class="text-danger">*</i></label>
                            <input step="any" type="number" class="form-control" name="lower"  >
                        </div>
                       <div class="form-group col-lg-2">
                            <label class="font-weight-600">Max <?php echo display('limit_amount');?> <i class="text-danger">*</i></label>
                            <input step="any" type="number" class="form-control" name="upper"  >
                        </div> 
                    </div>
            <div>
                <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
</div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " >
        <div class="card">
            <div class="card-body">
                <table id="example" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo display("transaction_type") ?></th>
                            <th><?php echo display("account_type") ?></th>
                            <th><?php echo display("coin") ?></th>
                            <th class="text-right"><?php echo display("minimum_limit") ?> </th>
                            <th class="text-right"><?php echo display("maximum_weekly_limit") ?></th>
                            <th class="text-right"><?php echo display("monthly_limit") ?></th>
                            <th class="text-right"><?php echo display("yearly_limit") ?></th>
                            <th class="text-center"><?php echo display('action');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($transaction_setup)){ 
                            foreach ($transaction_setup as $key => $value) {  
                        ?>
                            <tr>
                                <td><?php echo esc($value->trntype);?></td>
                                <td><?php echo esc($value->acctype);?></td>
                                <td><?php echo esc($value->currency_symbol);?></td>
                                <td class="text-right"><?php echo esc($value->lower);?></td>
                                <td class="text-right"><?php echo esc($value->upper*1);?></td>
                                <td class="text-right"><?php echo esc($value->upper*4.33);?></td>
                                <td class="text-right"><?php echo esc($value->upper*52);?></td>
                                <td class="text-center">
                                    <a href="<?php echo base_url('backend/setting/delete-transaction/'.$value->id) ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="hvr-buzz-out fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                    <?php echo htmlspecialchars_decode($pager); ?>
                </div>
            </div>
        </div>
    </div>
    
<!-- Third Party Scripts(used by this page)-->
<!-- summernote css -->
<script src="<?php echo BASEPATH.'/assets/plugins/select2/dist/js/select2.min.js' ?>"></script>
<script src="<?php echo BASEPATH.'/assets/dist/js/pages/demo.select2.js' ?>"></script>