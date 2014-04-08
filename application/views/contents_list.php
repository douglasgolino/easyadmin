<h2><img src="<?php echo base_url(); ?>resources/images/write.png" style="vertical-align: -5px"/> Lista de Conte&uacute;dos</h2> 
<p id="page-intro">Gerencie seus conte&uacute;dos aqui. Voc&ecirc; pode adcionar/editar e deletar seus conte&uacute;dos.</p>
	<div class="content-box"><!-- Start Content Box -->
		<div class="content-box-header">			
			<h3>&nbsp;</h3>
			<div style="float: left;padding-top: 3px;">
				<form action="<?php echo base_url(); ?>contents/index/" method="post">
					<?php
					$data = array(
								  'name'        => 'find_content',
								  'id'          => 'find_content',
								  'value'       => $find_content,
								  'maxlength'   => '60',
								  'size'        => '60',
								  'class'       => 'text-input medium-input'
								);
					echo form_input($data);
					?>				
					<input class="button" type="submit" id="find" name="find" value="Pesquisar" />
					&nbsp;
					<a href="<?php echo base_url() ?>contents/clear_research/">Limpar</a>
				</form>
			</div>			
			<div style="float: right; padding-right: 10px;padding-top: 7px">
				<form action="<?php echo base_url(); ?>contents/prepare_insert/" method="post">
					<input class="button" type="submit" id="add_product" name="add_product" value="Adcionar Conte&uacute;dos" />
				</form>
			</div>
			<div class="clear"></div>			
		</div> <!-- End .content-box-header -->
		<div class="content-box-content">
			<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->				
				<table border="1">						
				<thead>
					<tr>
					   <th>Dom&iacute;nio</th>
					   <th>Tag: Title</th>
					   <th>&nbsp;</th>
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


						echo '<td>'.$row->domain.'</td>';					
						echo '<td>'.$row->tag_title.'</td>';
						echo '<td nowrap="nowrap"><a href=" '. base_url() .  'contents/prepare_update/' . $row->id . '" class="button">Editar</a></td>';
						echo '<td><a href="#" onclick="destroy(' . $row->id . ');">Deletar</a></td>';

						echo '<td><a href=" '. base_url() .  'contents/change_status/' . $row->id . '">';
						if ($row->status == 1) {							
							echo '<img src="'.base_url().'resources/images/checkmark.png" alt="Bloquear" title="Bloquear"/>';
						}else{
							echo '<img src="'.base_url().'resources/images/uncheckmark.png" alt="Liberar" title="Liberar"/>';
						}																
						echo '</tr>';
					}
				}
				?>				
				</tbody> 
				</table> 
			</div> <!-- End #tab1 -->
		</div> <!-- End .content-box-content -->
	</div> <!-- End .content-box -->
	<?php echo $paginacao; ?>
<script>
function destroy(id) {
	if (confirm("Deseja realmente excluir este registro ?")) {
		window.location = '<?php echo base_url(); ?>contents/delete/'+id;
	}
}
</script>