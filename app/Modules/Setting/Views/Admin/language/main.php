<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fs-17 font-weight-600 mb-0">&nbsp;</h6>
            </div>
            <div class="text-right">
                <div class="actions">
                    <a class="btn btn-success" href="<?php echo base_url("backend/setting/phrase") ?>"> <i class="fa fa-plus"></i><?php echo display('add_phrase');?> </a> 
                </div>
            </div>
        </div>
    </div>
    <div class="card-body"> 
      <table class="table table-striped" id="languageTable">
        <thead>
            <tr class="bnone" >
                <?php echo form_open('backend/setting/add-language', 'class="form-inline"') ?> 
                <td width="300">
                    <div class="form-group">
                        <label class="sr-only" for="addLanguage"> <?php echo display('language_name');?></label>
                        <input name="language" type="text" class="form-control" id="addLanguage" placeholder="<?php echo display('language_name');?>">
                    </div>
                </td>
                <td colspan="2" ><button type="submit" class="btn btn-primary btn-lg lge-btn"><?php echo display('save');?></button></td>
                <?php echo form_close(); ?>
            </tr>
            <tr>
                <td><i class="fa fa-th-list"></i></td>
                <td><?php echo display('language');?></td>
                <td><i class="fa fa-cogs"></i></td>
            </tr>
            
        </thead>

        <tbody>

            <?php 
                if (!empty($languages)) { 
                $sl = 1; foreach ($languages as $key => $language) {
            ?>
                <tr>
                    <td><?php echo $sl++ ?></td>
                    <td><?php echo esc($language) ?></td>
                    <td><a href="<?php echo base_url("backend/setting/edit-phrase/$key") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a> 
                    <?php if(count($languages) > 1) { ?>
                    <a data-id = "<?php echo $key ;?>" data-url = "<?php echo base_url("backend/setting/delete-phrase/$key") ?>"  href="#"  data-message="<?php echo display('are_you_sure');?>"  class="btn btn-xs btn-danger actionDelete" data-toggle="tooltip" data-placement="left" title="Delete"><i class="fa fa-window-close"></i></a>  
                    <?php } ?> 

                    </td> 
                </tr>
                <?php } } ?>
        </tbody>
      </table>
    </div>
  
</div>
<script src="<?php echo BASEPATH.'assets/plugins/sweetalert/sweetalert.js' ?>" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo BASEPATH.'assets/plugins/sweetalert/sweetalert.css' ?>" />
<script src="<?php echo BASEPATH.'assets/js/language.js?v=1.0' ?>" type="text/javascript"></script>