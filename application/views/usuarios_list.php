<h2><img src="<?php echo base_url(); ?>resources/images/block_user.png" style="vertical-align: -5px"/> Lista de Usu&aacute;rios</h2> 
<p id="page-intro">Gerencie suas usu&aacute;rios aqui. Voc&ecirc; pode adcionar/editar e deletar suas usu&aacute;rios.</p> 					
<div class="content-box"><!-- Start Content Box -->
	<div class="content-box-header">			
		<h3>&nbsp;</h3>
		<div style="float: right; padding-right: 10px;padding-top: 7px">
			<form action="<?php echo base_url(); ?>users/prepare_insert/" method="post">
			<input class="button" type="submit" id="add_product" name="add_product" value="Adcionar Usu&aacute;rios" />
			</form>
		</div>
		<div class="clear"></div>			
	</div> <!-- End .content-box-header -->
	<div class="content-box-content">
		<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
			<table>					
			<thead>
				<tr>
					<th>C&oacute;digo</th>
					<th>Usu&aacute;rio</th>
					<th>&Uacute;ltimo acesso</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>		
			</thead>				 									 
			<tbody>
			<?php
			if (count($list)){
				$i = 0;
				foreach($list as $row) {
					++$i;
					if($i % 2 != 0)
						echo '<tr>';
					else
						echo '<tr nowrap="nowrap">';

					echo '<td>'.$row->id.'</td>';
					echo '<td>'.$row->login.'</td>';
					echo '<td>'.$row->last_access.'</td>';
					echo '<td nowrap="nowrap"><a href=" '. base_url() .  'users/prepare_update/' . $row->id . '" class="button">Editar</a></td>';
					echo '<td><a href=" '. base_url() .  'users/prepare_update/' . $row->id . '">';
					if ($row->status == 1)
						echo '<img src="'.base_url().'resources/images/checkmark.png" alt="Inativar" title="Inativar"/>';
					else
						echo '<img src="'.base_url().'resources/images/uncheckmark.png" alt="Ativar" title="Ativar"/>';
					echo '</a></td>';
					echo '</tr>';
				}
			}
			?>				
			</tbody> 
			</table> 
		</div> <!-- End #tab1 -->
	</div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->
<?php echo $pagination; ?>