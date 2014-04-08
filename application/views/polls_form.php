<h2>
	<img src="<?php echo base_url(); ?>resources/images/clipboard.png" style="vertical-align: -5px"/>
	Cadastro de Enquetes
</h2>
<p id="page-intro">Digite as informa&ccedil;&otilde;es da enquete do dom&iacute;nio.</p> 
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
						<br /><small>Escolha um dom&iacute;nio para receber para a enquete abaixo.</small>
					</p>					
					
					<p>
						<label>Pergunta da Enquete *</label>
						<?php
						$data = array(
									  'name'        => 'question',
									  'id'          => 'question',
									  'value'       => $question,
									  'maxlength'   => '150',
									  'size'        => '60',
									  'class'       => 'text-input medium-input'
									);
						echo form_input($data);
						?>
						<br /><small>Entre com um valor para a pergunta da enquete.</small>
					</p>					

					<input type="hidden" value="<?php echo $id;?>" name="id" id="id"/>
					
					<p>
						<label>1&#170; Alternativa *</label>
						<?php
						$data = array(
									  'name'        => 'answer_1',
									  'id'          => 'answer_1',
									  'value'       => $answer_1,
									  'maxlength'   => '150',
									  'size'        => '60',
									  'class'       => 'text-input medium-input'
									);
						echo form_input($data);
						?>
						<br /><small>Entre com um valor para a 1&#170; alternativa da enquete.</small>
					</p>
					
					<p>
						<label>2&#170; Alternativada *</label>
						<?php
						$data = array(
									  'name'        => 'answer_2',
									  'id'          => 'answer_2',
									  'value'       => $answer_2,
									  'maxlength'   => '150',
									  'size'        => '60',
									  'class'       => 'text-input medium-input'
									);
						echo form_input($data);
						?>
						<br /><small>Entre com um valor para a 2&#170; alternativa da enquete.</small>
					</p>
					
					<p>
						<label>3&#170; Alternativa</label>
						<?php
						$data = array(
									  'name'        => 'answer_3',
									  'id'          => 'answer_3',
									  'value'       => $answer_3,
									  'maxlength'   => '150',
									  'size'        => '60',
									  'class'       => 'text-input medium-input'
									);
						echo form_input($data);
						?>
						<br /><small>Entre com um valor para a 3&#170; alternativa da enquete.</small>
					</p>
										
										
					<p>
						<input class="button" type="submit" id="submit_product" name="submit_product" value="Gravar" />
					</p>
					</fieldset>
					<div class="clear"></div><!-- End .clear -->
			<?php echo form_close(); ?>
	</div> <!-- End #tab1 -->
</div> <!-- End .content-box-content -->