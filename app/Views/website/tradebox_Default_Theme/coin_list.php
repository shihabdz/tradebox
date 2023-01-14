<?php

    $cat_title1  = isset($lang) && $lang =="french"?$cat_info->cat_name_fr:$cat_info->cat_name_en;
    $cat_title2  = isset($lang) && $lang =="french"?$cat_info->cat_title1_fr:$cat_info->cat_title1_en;
?>
<div class="page_header cryp_wrapper" data-parallax-bg-image="<?php echo IMAGEPATH.$cat_info->cat_image; ?>" data-parallax-direction="">
    <div id="banner_bg_effect" class="banner_effect"></div>
    <div class="header-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="haeder-text">
                        <h1><?php echo htmlspecialchars_decode($cat_title1); ?></h1>
                        <p><?php echo htmlspecialchars_decode($cat_title2); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  /.End of page header -->

<!-- price spick -->
<div class="price-spike">
    <div class="container">
        <div class="row">          
            <?php foreach ($coin as $key => $value) { ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="imagine-card">
                    <div class="imagine-card-head">
                        <div class="imagine-card-logo">

                            <img src="<?php echo $value->image?IMAGEPATH.$value->image:$value->url; ?>" alt="<?php echo esc($value->full_name); ?>">
                        </div>
                        <div>
                            <div class="imagine-card-name"><?php echo esc($value->symbol); ?></div>
                            <div class="imagine-card-date"><?php echo esc($value->full_name); ?></div>
                        </div>
                    </div>
                    <div class="imagine-card-bottom">
                        <div class="imagine-card-chart">
                            <!-- <span class="bdtasksparkline value_graph" id="GRAPH_<?php echo esc($value->symbol); ?>"></span> -->
                            <span class="Percent" id="LASTPRICE_<?php echo esc($value->symbol); ?>"></span>

                            
                        </div>
                        <div>
                            <div class="imagine-card-change">
                                <span class="Percent" id="CHANGE24HOURPCT_<?php echo esc($value->symbol); ?>"></span>
                                <div class="imagine-card-points">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
        <div class="row">
            <div class="col-md-12"><?php echo $pager ;?></div>
        </div>
        
    </div>

</div>
<!--  ./End of price spike -->

<!-- /.End of live exchange -->
<div class="newslatter">
    <div class="container">
         <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-6">
                <div class="newslatter-text">
                    <h3><?php echo display('email_newslatter'); ?></h3>
                    <p><?php echo display('subscribe_to_our_newsletter'); ?></p>
                </div>
                <?php echo form_open('subscribe','id="subscribeForm"  class="newsletter-form" name="subscribeForm" '); ?>
                <div class="input-group newslatter-form">
                    <input type="email" name="subscribe_email"class="form-control" placeholder="example@mail.com" required>
                    <div class="input-group-append">
                        <button class="btn btn-kingfisher-daisy" type="submit"><?php echo display('submit') ?></button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<!-- /.End of newslatter -->