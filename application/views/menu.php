<div id="sidebar">
	<div id="sidebar-wrapper"> <!-- Sidebar with logo and menu --> 
		<h1 id="sidebar-title"><a href="#">&nbsp;</a></h1>
		<!-- Logo (221px wide) --> 
		<a href="<?php echo base_url();?>home/index"><img id="logo" src="<?php echo base_url(); ?>resources/images/logo.png" alt="EasyAdmin Logo"/></a>
			<!-- Sidebar Profile links -->
		<div id="profile-links">
		&Uacute;ltimo acesso: <?php echo $this->session->userdata('userLastAccess'); ?>
		</div>		
		<ul id="main-nav">  <!-- Accordion Menu --> 
			<li>
				<a class="nav-top-item no-submenu <?php echo $home; ?>" href="<?php echo base_url();?>home/index">
				In&iacute;cio
				</a>
			</li>
			<li> 
				<a class="nav-top-item <?php echo $domains; ?>" href="#">
				Dom&iacute;nios
				</a>
				<ul>
					<li><a class=" <?php echo $domains_list; ?>" href="<?php echo base_url();?>domains/index">Lista de Dom&iacute;nios</a></li> 
					<li><a class=" <?php echo $insert_update_domains; ?>" href="<?php echo base_url();?>domains/prepare_insert/">Adcionar Dom&iacute;nios</a></li>
				</ul>        
			</li> 			
			<li> 
				<a class="nav-top-item <?php echo $contents; ?>" href="#">
				Conte&uacute;dos
				</a> 
				<ul> 
					<li><a class=" <?php echo $contents_list; ?>" href="<?php echo base_url();?>contents/index">Lista de Conte&uacute;dos</a></li> 
					<li><a class=" <?php echo $insert_update_contents; ?>" href="<?php echo base_url();?>contents/prepare_insert/">Adcionar Conte&uacute;dos</a></li>
				</ul>       
			</li>
			<li> 
				<a class="nav-top-item <?php echo $polls; ?>" href="#">
				Enquetes
				</a> 
				<ul> 
					<li><a class=" <?php echo $polls_list; ?>" href="<?php echo base_url();?>polls/index">Lista de Enquetes</a></li> 
					<li><a class=" <?php echo $insert_update_polls; ?>" href="<?php echo base_url();?>polls/prepare_insert/">Adcionar Enquete</a></li>
				</ul>       
			</li>
			<li> 
				<a class="nav-top-item <?php echo $users; ?>" href="#">
				Usu&aacute;rios
				</a>
				<ul>
					<li><a class=" <?php echo $change_password; ?>" href="<?php echo base_url();?>users/prepare_change_password">Mudar minha Senha</a></li> 
				</ul>        
			</li> 			
			<li> 
				<a class="nav-top-item no-submenu <?php echo $logout; ?>" href="<?php echo base_url();?>login/make_logout">
				Sair
				</a>       
			</li> 
		</ul> <!-- End #main-nav --> 
	</div>
</div> <!-- End #sidebar -->