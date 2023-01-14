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
<?php
	if ($article) {

		foreach ($article as $key => $value) {
			$headline     =   isset($lang) && $lang =="french"?$value->headline_fr:$value->headline_en;
			$article1     =   isset($lang) && $lang =="french"?$value->article1_fr:$value->article1_en;
			$article2     =   isset($lang) && $lang =="french"?$value->article2_fr:$value->article2_en;
			$article_pdf=   $value->article_pdf;
			$pageHeight = $value->pageHeight .'px';

		}
?>

	<div class="about_content">
		<div class="container">
			<div class="row about-text justify-content">
				<div class="col-md-12">	
					<p class="about_text">						
						<embed src="<?php echo IMAGEPATH . $article_pdf;?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="<?php echo $pageHeight;?>" />					
					</p>
				</div>
			</div>
		</div>
	</div>
	<!-- /.End of about content -->
	<?php } ?> 