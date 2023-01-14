
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?$title:null) ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body" > 
                    <div class="row">
                        <div class="form-group col-lg-4 offset-md-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-danger text-center autoupdate-version">
                                        <h2><?php echo display('allow_url_fopen'); ?></h2>
                                        <p><?php echo display('server_configuration'); ?> </p>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>  
            </div>
        </div>
    </div>
</div>