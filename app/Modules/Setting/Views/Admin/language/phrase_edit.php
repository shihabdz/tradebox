<?php $request = \Config\Services::request(); ?>
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fs-17 font-weight-600 mb-0"> 
                    <a class="btn btn-success" href="<?php echo base_url("backend/setting/phrase") ?>"> <i class="fa fa-plus"></i> <?php echo display('add_phrase');?></a>
                </h6>
            </div>
            <div class="text-right">
                <div class="actions">
                    <a class="btn btn-success" href="<?php echo base_url("backend/setting/export_phrase/".$language) ?>"> <i class="fa fa-file-export"></i><?php echo display('export_phrase');?> </a>
                    
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importModal">
                        <i class="fa fa-cloud-upload-alt"></i><?php echo display('import_phrase');?>
                    </button>

                    <a class="btn btn-primary" href="<?php echo base_url("backend/setting/language") ?>"> <i class="fa fa-list"></i><?php echo display('language_list');?> </a> 
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
       
        <?php echo form_open('backend/setting/search/'.$request->uri->setSilent()->getSegment(4)); ?>
            <div class="row mb-20">
                <div class="col-sm-7">
                    <input class="form-control" type="text" name="search_box" placeholder="<?php echo display('search_phrase_or_label');?>" required>
                </div>
                <div class="col-sm-1">
                    <button type="submit" class="btn btn-info search-btn"><i class="fa fa-search-plus"></i></button>
                </div>
            </div>
        <?php echo form_close(); ?>

        <?php echo form_open('backend/setting/add-lebel') ?>
        <table class="table table-striped">
            <thead> 
                <tr>
                    <td colspan="3"> 
                        <button type="reset" class="btn btn-danger"><?php echo display('reset');?></button>
                        <button type="submit" class="btn btn-success"><?php echo display('save');?></button>
                    </td>
                </tr>
                <tr>
                    <th><i class="fa fa-th-list"></i></th>
                    <th><?php echo display('phrase');?></th>
                    <th><?php echo display('label');?></th> 
                </tr>
            </thead>
            <tbody>
                <?php echo  form_hidden('language', $language) ?>
                <?php 
          
                    $sl = 1;
                    if (!empty($phrases)) {
                ?>
                  

                    <?php if($search_result){ ?>

                    <tr class="green-yellow">
                        <td class="pt-20"><?php echo  esc($sl++) ?></td>
                        <td class="pt-20 blink">
                           
                                <span class="search-text"><?php echo  esc($search_result->phrase) ?></span>
                                <input type="hidden" name="phrase[]" value="<?php echo  esc($search_result->phrase) ?>" class="form-control" readonly>
                           
                        </td>
                        <td><input type="text" name="lang[]" value="<?php echo  esc($search_result->$language) ?>" class="form-control"></td> 
                    </tr>

                    <?php } ?>

                    <?php foreach ($phrases as $value) { ?>
                
                        <?php if(!empty($search_lang_id) && $search_lang_id==$value->id){ continue; }?>
                        <tr class="<?php echo  (empty($value->$language)?"bg-danger":null) ?> ">
                            <td><?php echo  esc($sl++) ?></td>
                            <td><input type="text" name="phrase[]" value="<?php echo  esc($value->phrase) ?>" class="form-control" readonly></td>
                            <td><input type="text" name="lang[]" value="<?php echo esc($value->$language) ?>" class="form-control"></td> 
                        </tr>
                    <?php } } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="1"> 
                        <button type="reset" class="btn btn-danger"><?php echo display('reset');?></button>
                        <button type="submit" class="btn btn-success"><?php echo display('save');?></button>
                    </td>
                    <td colspan="2">
                        <?php echo htmlspecialchars_decode($pager) ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <?php echo form_close() ?>
    </div>
   
</div>

<!-- Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel"><?php echo display('Modal title') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <?php echo form_open_multipart('backend/setting/import_phrase/'.$language, array('class'=>'form-inline float-left mr-1')); ?>
   
            <input type='file' name='file' class="form-control" placeholder="File" accept=".xlsx, .xls, .csv">
            <button type="submit" class="btn btn-primary " >
                <?php echo display('submit');?>
            </button>
        <?php echo form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo display('close');?></button>
      </div>
    </div>
  </div>
</div>