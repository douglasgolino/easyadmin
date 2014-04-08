<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>EasyAdmin - Gerenciador de Dom&iacute;nios</title>
		<link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/reset.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/invalid.css" type="text/css" media="screen" />
		<!-- Internet Explorer Fixes Stylesheet -->
		<!--[if lte IE 7]>
			<link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/ie.css" type="text/css" media="screen" />
		<![endif]-->	
	</head>
	<body id="login">
		<div id="login-wrapper" class="png_bg">
			<div id="login-top">
				<h1>EasyFin</h1>
				<!-- Logo (221px width) -->
				<img id="logo" src="<?php echo base_url(); ?>resources/images/logo.png" alt="EasyFin Logo"/>
			</div> <!-- End #logn-top -->
			<div id="login-content">
				<?php echo form_open('login/make_login'); ?>
				<div class="notification error png_bg" <?php if(! $this->session->flashdata('error')) echo 'style="visibility:hidden"'; ?>>
					<div>
						<?php echo $this->session->flashdata('error'); ?>
					</div>
				</div>				
				<p>
				<label>Usu&aacute;rio</label>
				<?php
				$data = array(
							  'name'        => 'login',
							  'id'          => 'login',
							  'value'       => 'admin',
							  'maxlength'   => '12',
							  'size'        => '15',
							  'class'       => 'text-input',
							);

				echo form_input($data);
				?>	
				</p>
				<div class="clear"></div>
				<p>
				<label>Senha</label>
				<?php
				$data = array(
							  'name'        => 'password',
							  'id'          => 'passwrod',
							  'value'       => '123456',
							  'maxlength'   => '12',
							  'size'        => '15',
							  'class'       => 'text-input',
							);			
				echo form_password($data);								
				?>
				</p>
				<div class="clear"></div>
				<div class="clear"></div>
				<p>
					<input class="button" type="submit" id="submit" name="submit" value="Entrar" />
				</p>
				<?php echo form_close(); ?>		
			</div> <!-- End #login-content -->
		</div> <!-- End #login-wrapper -->
  </body>
</html>