<h2>
	<img src="<?php echo base_url(); ?>resources/images/table.png" style="vertical-align: -5px"/>
	Cadastro de Dom&iacute;nios
</h2>
<p id="page-intro">Digite as informa&ccedil;&otilde;es do dom&iacute;nio ou subdom&iacute;nio </p> 
<div class="content-box"><!-- Start Content Box -->
	<div class="content-box-header">
        	<h3>Todos os campos s&atilde;o requeridos</h3>
                <div class="clear"></div>

	</div> <!-- End .content-box-header -->
<div class="content-box-content">
	<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
			<?php echo  form_open_multipart($action); ?>
					<input type="hidden" value="<?php echo $id;?>" name="id" id="id"/>						
					<p>
						<label>URL</label>
						<?php
							$data = array(
										  'name'        => 'url',
										  'id'          => 'url',
										  'value'       => $url,
										  'maxlength'   => '120',
										  'size'        => '20',
										  'class'       => 'text-input medium-input'
										);

							echo form_input($data);
						?>
						<br /><small>Entre com a url do dom&iacute;nio ou subdom&iacute;nio.</small>
					</p>

					<p>
						<label>SubDom&iacute;nio</label>
						<?php
							$data = array(
										  'name'        => 'subdomain',
										  'id'          => 'subdomain',
										  'value'       => '1',
										  'checked'		=> $subdomain == 1 ? true : false
										);

							echo form_checkbox($data);
						?>
						<small>Marque esta op&ccedil;&atilde;o somente se estiver cadastrando um subdom&iacute;nio.</small>						
					</p>
					
					<p>
						<label>Tema *</label>
						<?php
						$data = array(
									  'name'        => 'theme',
									  'id'          => 'theme',
									  'value'       => $theme,
									  'maxlength'   => '25',
									  'size'        => '20',
									  'class'       => 'text-input small-input'
									);
						echo form_input($data);
						?>
						<br /><small>Entre com um valor para o tema principal do dom&iacute;nio.</small>
					</p>

					<p>
						<label>Imagem para o Logo</label>
						<?php
							$data = array(
										  'name'        => 'image_logo',
										  'id'          => 'image_logo',
										  'value'       => '',
										  'maxlength'   => '120',
										  'size'        => '20',
										  'class'       => 'text-input medium-input'
										);

							echo form_upload($data);
						?>
						<br /><small>Entre com uma imagem ( 70X70 ) para ser o logo do dom&iacute;nio.</small>
					</p>					

					<p>
						<label>Tag: Title *</label>
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
						<br /><small>Entre com um valor para Tag &#60;title&#62;.</small>
					</p>					

					<input type="hidden" value="<?php echo $id;?>" name="id" id="id"/>

					<p>
						<label>Meta Tag: description</label>
						<?php
						$data = array(
									  'name'        => 'tag_description',
									  'id'          => 'tag_description',
									  'value'       => $tag_description,
									  'maxlength'   => '200',
									  'size'        => '100',
									  'class'       => 'text-input large-input'
									);
						echo form_input($data);
						?>
						<br /><small>Entre com um valor para Meta Tag "description".</small>
					</p>

					<p>
						<label>Meta Tag: keywords</label>
						<?php
						$data = array(
									  'name'        => 'tag_keywords',
									  'id'          => 'tag_keywords',
									  'value'       => $tag_keywords,
									  'maxlength'   => '200',
									  'size'        => '100',
									  'class'       => 'text-input large-input'
									);
						echo form_input($data);
						?>
						<br /><small>Entre com um valor para Meta Tag "keywords".</small>
					</p>

					<p>
						<label>Java Script</label>
						<?php
						$data = array(
									  'name'        => 'scripts_js',
									  'id'          => 'scripts_js',
									  'value'       => $scripts_js
									);
						echo form_textarea($data);
						?>
						<br /><small>Entre com os c&oacute;digos Java Script.</small>	
					</p>					
					
					<p>
						<label>Facebook Curtir</label>
						<?php
						$data = array(
									  'name'        => 'facebook_like',
									  'id'          => 'facebook_like',
									  'value'       => $facebook_like
									);
						echo form_textarea($data);
						?>
						<br /><small>Entre com o c&oacute;digo personalizado do "curtir" do facebook, somente se houver um facebook para este dom&iacute;nio.</small>	
					</p>

					<p>
						<label>Texto Fixo</label>
						<?php
						$data = array(
									  'name'        => 'fixed_text',
									  'id'          => 'fixed_text',
									  'value'       => $fixed_text
									);
						echo form_textarea($data);
						
						echo display_ckeditor($ckeditor_text);
						?>
						<br /><small>Entre com um texto fixo para todas as p&aacute;ginas.</small>	
					</p>

					<p>
						<input class="button" type="submit" id="submit_product" name="submit_product" value="Gravar" />
					</p>
					</fieldset>
					<div class="clear"></div><!-- End .clear -->
			<?php echo form_close(); ?>
	</div> <!-- End #tab1 -->
</div> <!-- End .content-box-content -->