        <div class="ballance-content mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                           <div class="col-sm-8 content-title"> <h4><?php echo display('balance') ?></h4></div>
                            <div class="col-sm-4"><input id="search_keyword" class="form-control" type="text" name="search_keyword" placeholder="Type keyword for search"></div>
                        </div>
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
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-bg">
                                        <th><?php echo display('cryptocoin') ?></th>
                                        <th><?php echo display('name') ?></th>
                                        <th><?php echo display('total_balance') ?></th>
                                        <th><?php echo display('available_balance') ?></th>
                                        <!-- <th colspan="2" class="text-center">
                                            <?php echo display('action') ?>
                                        </th> -->
                                    </tr>
                                </thead>
                                <tbody id="searchList">                            
                                <?php  foreach ($balances as $key => $value) { ?>
                                    <tr>
                                        <td><div class="d-flex marks-ico">
                                                <div><img src="<?php echo $value->image?IMAGEPATH."$value->image":IMAGEPATH.'upload/coinlist/no-image.jpg' ?>" alt=""></div>
                                                <div class="ico-name">
                                                    <font><?php echo esc($value->currency_symbol); ?></font>
                                                    <span class="text-muted">(<?php echo esc($value->coin_name); ?>)</span>
                                                </div>
                                            </div></td>
                                        <td><?php echo esc($value->coin_name); ?></td>
                                        <td><?php echo esc($value->balance); ?></td>
                                        <td><?php echo esc($value->balance); ?></td>
                                       
                                    </tr>   

                                    
                                 <?php } ?>
                                                    
                              
                             </tbody>
                            </table>
                            <?php echo $pager; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
