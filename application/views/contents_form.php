<h2>
	<img src="<?php echo base_url(); ?>resources/images/write.png" style="vertical-align: -5px"/>
	Cadastro de Conte&uacute;dos
</h2>
<p id="page-intro">Digite as informa&ccedil;&otilde;es do "corpo" do site.</p> 
<div class="content-box"><!-- Start Content Box -->
	<div class="content-box-header">
			<h3>Campos com * s&atilde;o requeridos</h3>
				<div class="clear"></div>

	</div> <!-- End .content-box-header -->
<div class="content-box-content">
	<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
			<?php echo form_open($action); ?>
					<fieldset>
					<p>
						<label>Dom&iacute;nios Cadastrados *</label>
						<?php
						echo form_dropdown('domains', $domains, $domainId);
						?>
						<br /><small>Escolha um dom&iacute;nio para receber as configura&ccedil;&otilde;es abaixo.</small>
					</p>					
					
					<p>
						<label>T&iacute;tulo *</label>
						<?php
						$data = array(
									  'name'        => 'tag_title',
									  'id'          => 'tag_title',
									  'value'       => $tag_title,
									  'maxlength'   => '100',
									  'size'        => '60',
									  'class'       => 'text-input medium-input'
									);
						echo form_input($data);
						?>
						<br /><small>Entre com um valor para &#60;t&iacute;tulo&#62;.</small>
					</p>					

					<input type="hidden" value="<?php echo $id;?>" name="id" id="id"/>

					<p>
						<label>Tag: Body</label>
						<?php
						$data = array(
									  'name'        => 'tag_body',
									  'id'          => 'tag_body',
									  'value'       => $tag_body
									);
						echo form_textarea($data);
						
						echo display_ckeditor($ckeditor_text);
						?>
						<br /><small>Entre com um valor para Tag &#60;body&#62;.</small>	
					</p>											
										
					<p>
						<input class="button" type="submit" id="submit_product" name="submit_product" value="Gravar" />
					</p>
					</fieldset>
					<div class="clear"></div><!-- End .clear -->
			<?php echo form_close(); ?>
	</div> <!-- End #tab1 -->
</div> <!-- End .content-box-content -->