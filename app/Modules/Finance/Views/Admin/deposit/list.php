<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <table  id="example" class="table table-bordered table-hover">
                    <thead>
                        <tr> 
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('user_id') ?></th>
                            <th><?php echo display('name') ?></th>
                            <th class="text-right"><?php echo display('amount') ?></th>
                            <th><?php echo display('currency') ?>/<?php echo display('coin') ?></th>
                            <th><?php echo display('payment_method') ?></th>
                            
                            <th><?php echo display('transaction_hash') ?></th>
                            <th><?php echo display('date') ?></th>
                            <th class="text-center"><?php echo display('action')."/".display('status'); ?></th>
                        </tr>
                    </thead> 
                    <tbody>
                        <?php if (!empty($deposit)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($deposit as $value) { ?>
                        <tr>
                            <td><?php echo $sl++; ?></td>
                            <td><?php echo esc($value->user_id); ?></td>
                            <td><?php echo esc($value->first_name.' '. $value->last_name); ?></td>
                            <td class="text-right"><?php echo esc((float)$value->amount); ?></td>
                            <td><?php echo esc($value->currency_symbol); ?></td>
                            <td><?php echo $value->method_id=='bitcoin'?'Gourl':esc($value->method_id); ?></td>
                           
                            <td>
                               <?php if($value->method_id == "erc20"){?>
                                <a target="_blank" href="https://etherscan.io/tx/<?php echo $value->transaction_hash ?>"><?php echo esc($value->transaction_hash);?></a>
                                <?php } else { ?>

                                    <a target="_blank" href="https://bscscan.com/tx/<?php echo $value->transaction_hash ?>"><?php echo esc($value->transaction_hash);?></a>

                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                    $date=date_create($value->deposit_date);
                                    echo date_format($date,"jS F Y"); 
                                ?>
                            </td>
                             <?php if($value->status == 0 && $value->expire_date >= date('Y-m-d h:i:s')){?>
                                 <td class="text-center"><i title="<?php echo display('pending');?>" class="fas fa-spinner fa-pulse text-danger"></i></td>

                            <?php } else if (esc($value->status)==1) { ?>
                            <td class="text-center">
                                <div class="progress">
                                  <div title="First Step Completed!" class="progress-bar progress-bar-striped bg-success progress-bar-animated width85" role="progressbar" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100"> <?php echo display('processing');?> 
                                  </div>
                                </div>
                            </td>
                            <?php } else if(esc($value->status)==2){ ?>
                            <td class="text-center"> <i title="<?php echo display('fund_received');?>" class="fas fa-check text-warning"></i></td>
                            <?php } else if(esc($value->status)==3){ ?>
                            <td class="text-center"> <i title="<?php echo display('success');?>" class="fas fa-check text-success"></i></td>
                            <?php } else if(esc($value->status)==4){ ?>
                            <td class="text-center"> <i title="<?php echo display('canceled');?>" class="fas fa-times text-danger"></i></td>
                             <?php } else if ($value->status == 0 && $value->expire_date < date('Y-m-d h:i:s')){ ?>
                            <td class="text-center"> <i title="Expired" class="far fa-calendar-times text-danger"></i></td>
                             <?php } else { ?>
                            <td class="text-center">
                                <a href="<?php echo base_url()?>/backend/finance/confirm-deposit?id=<?php echo $value->id;?>&user_id=<?php echo $value->user_id;?>&set_status=3&csym=<?php echo $value->currency_symbol;?>" class="btn btn-success btn-sm text-white"><?php echo display('confirm')?></a>
                                <a href="<?php echo base_url()?>/backend/finance/cancel-deposit?id=<?php echo $value->id;?>&user_id=<?php echo $value->user_id;?>&set_status=4&csym=<?php echo $value->currency_symbol;?>" class="btn btn-danger btn-sm text-white"><?php echo display('cancel')?></a>
                            </td>
                           <?php } ?>

                            
                        </tr>
                        <?php } ?>  
                    </tbody>
                </table>
                <?php echo  htmlspecialchars_decode($pager); ?>
            </div> 
        </div>
    </div>
</div>

 