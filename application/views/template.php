<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>EasyAdmin - Gerenciador de Dom&iacute;nios</title>
		<link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/reset.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/invalid.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/jquery.click-calendario-1.0.css" type="text/css" media="screen" />

		<!-- Internet Explorer Fixes Stylesheet -->
		<!--[if lte IE 7]>
			<link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/ie.css" type="text/css" media="screen" />
		<![endif]-->
		<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/simpla.jquery.configuration.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/facebox.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/jquery.wysiwyg.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/jquery.click-calendario-1.0.js"></script>
                <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/jquery.numeric.pack.js"></script>
                <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/jquery.floatnumber.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/style.js"></script>
		<!-- Internet Explorer .png-fix -->
		<!--[if IE 6]>
			<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->
	</head>
	<body>
		<div id="body-wrapper"> <!-- Wrapper for the radial gradient background --> 
			<?php echo  $menu; ?>
			<div id="main-content"> <!-- Main Content Section with everything -->
				<?php
					if($this->session->flashdata('error')) {
				?>
					<div class="notification error png_bg">
						<a href="#" class="close"><img src="<?php echo base_url(); ?>resources/images/icons/cross_grey_small.png" title="Fechar" alt="Fechar" /></a>
						<div>
							<?php echo $this->session->flashdata('error'); ?>
						</div>
					</div>
				<?php
					}
					if($this->session->flashdata('msg')) {
				?>
					<div class="notification success png_bg">
						<a href="#" class="close"><img src="<?php echo base_url(); ?>resources/images/icons/cross_grey_small.png" title="Fechar" alt="Fechar" /></a>
						<div>
							<?php echo $this->session->flashdata('msg'); ?>
						</div>
					</div>
				<?php
					}

					echo  $body; 
				?>
				<div id="footer">
					&nbsp;
					<small>
						&#169; Copyright 2013 - Douglas Golino Aguiar
					</small>
				</div><!-- End #footer -->
			</div> <!-- End #main-content -->
		</div>
	</body> 
</html>