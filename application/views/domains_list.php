<h2><img src="<?php echo base_url(); ?>resources/images/table.png" style="vertical-align: -5px"/> Lista de Dom&iacute;nios </h2> 
<p id="page-intro">Gerencie seus dom&iacute;nios aqui. Voc&ecirc; pode adcionar/editar e deletar seus dom&iacute;nios .</p> 					
	<div class="content-box"><!-- Start Content Box -->
		<div class="content-box-header">			
			<h3>&nbsp;</h3>
			<div style="float: right; padding-right: 10px;padding-top: 7px">
				<form action="<?php echo base_url(); ?>domains/prepare_insert/" method="post">
				<input class="button" type="submit" id="add_product" name="add_product" value="Adcionar Dom&iacute;nios" />
				</form>
			</div>
			<div class="clear"></div>			
		</div> <!-- End .content-box-header -->
		<div class="content-box-content">
			<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
				<table border="1">					
				<thead>
					<tr>
						<th>Url do dom&iacute;nio</th>
						<th>Subdom&iacute;nio</th>
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
						
						if($i % 2 != 0){
							echo '<tr>';
						}else{
							echo '<tr nowrap="nowrap">';
						}

						$url = $row->url;
						$size = strlen($url);
						if($size > 30) {
							$url = substr_replace($url, " ...", 65, $size - 30);
						}						

						if($row->subdomain == 1){
							echo '<td>'.$url.'</td>';
							echo '<td> S </td>';
						}else{
							echo '<td>www.'.$url.'</td>';
							echo '<td> N </td>';
						}						
						echo '<td nowrap="nowrap"><a href=" '. base_url() .  'domains/prepare_update/' . $row->id . '" class="button">Editar</a></td>';
						echo '<td><a href="#" onclick="destroy(' . $row->id . ');">Deletar</a></td>';
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
		window.location = '<?php echo base_url(); ?>domains/delete/'+id;
	}
}
</script>