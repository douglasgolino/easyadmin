<h2>
	<img src="<?php echo base_url(); ?>resources/images/lock.png" style="vertical-align: -5px"/>
	Mudar minha Senha
</h2>
<p id="page-intro">Digite as informa&ccedil;&otilde;es abaixo para trocar sua senha</p>
<div class="content-box"><!-- Start Content Box -->
	<div class="content-box-header">
        	<h3>Todos os campos s&atilde;o requeridos</h3>
                <div class="clear"></div>

        </div> <!-- End .content-box-header -->
<div class="content-box-content">
        <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
                <?php echo form_open($action); ?>
                        <fieldset>
                        <p>
                                <label>Nova Senha</label>
                                <?php
								$data = array(
												  'name'        => 'new_password',
												  'id'          => 'new_password',
												  'value'       => '',
												  'maxlength'   => '20',
												  'size'        => '20',
												  'class'       => 'text-input small-input'
												);

								echo form_password($data);
                                ?>
                                <br /><small>Entre com a nova senha.</small>
                        </p>
                        <p>
                                <label>Confirma&ccedil;&atilde;o de Senha</label>
                                <?php
								$data = array(
												  'name'        => 'password_confirmation',
												  'id'          => 'password_confirmation',
												  'value'       => '',
												  'maxlength'   => '20',
												  'size'        => '20',
												  'class'       => 'text-input small-input'
												);

								echo form_password($data);
                                ?>
                                <br /><small>Entre com a confirma&ccedil;&atilde;o de senha.</small>
                        </p>
                        <p>
                                <input class="button" type="submit" id="submit_product" name="submit_product" value="Gravar" />
                        </p>
                        </fieldset>
                        <div class="clear"></div><!-- End .clear -->
                <?php echo form_close(); ?>
        </div> <!-- End #tab1 -->
</div> <!-- End .content-box-content -->