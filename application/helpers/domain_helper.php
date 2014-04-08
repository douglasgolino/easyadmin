<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

function prepare_index_file(&$argData) {
	$return = '';
	$return .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
	$return .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
	$return .= "<head>\n";
	$return .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n";
	if (trim($argData->scripts_js) != "") {
		$return .= "<script type=\"text/javascript\">" . $argData->scripts_js . "</script>\n";
	}
	$return .= "<title>" . $argData->tag_title . "</title>\n";
	if (trim($argData->tag_description) != "") {
		$return .= "<meta name=\"description\" content=\"". $argData->tag_description . "\" />\n";
	}
	if(trim($argData->tag_keywords) != "") {
		$return .= "<meta name=\"keywords\" content=\"". $argData->tag_keywords . "\" />\n";
	}
	$return .= "<?php \n";
	$return .= '$content_id = ' . $argData->id . "; \n";		
	$return .= "include('recebe_post.php'); \n";
	$return .= "?> \n";	
	$return .= "</head>\n";
	$return .= "<body>\n\n";
	$return .= $argData->tag_body."\n\n";
	$return .= "<iframe src=\"http://www.facebook.com/plugins/like.php?href=http://$argData->url&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=35\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; overflow:hidden; width:450px; height:35px;\" allowTransparency=\"true\"></iframe>\n\n";
	$return .= "<BR>\n";
	$return .= "<div id='interna_pop' style='font-family: Verdana, Tahoma, Georgia, Helvetica, Arial, Helvetica, sans-serif;font-size:12px;width:480px;'>\n";
	$return .= "<h3>Deixe seu coment&aacute;rio</h3><BR>\n";
	$return .= "<form action='#' method='post' name='formulario' id='formulario'>\n";
	$return .= "<input type='hidden' name='content_id' value=''/>\n";
	$return .= "<div style='padding:2px; width: 80px; float:left; text-align:right'>Nome:</div>\n";
	$return .= "<div style='padding:2px'><INPUT TYPE='text' NAME='nome' size='50' value=''></div>\n";
	$return .= "<div style='padding:2px; width: 80px; float:left; text-align:right'>E-mail:</div>\n";
	$return .= "<div style='padding:2px'> <INPUT TYPE='text' NAME='email' size='50' value=''></div>\n";
	$return .= "<div style='padding:2px; width: 80px; float:left; text-align:right'>Coment&aacute;rio:</div>\n";
	$return .= "<div style='padding:2px; valign:top'><TEXTAREA NAME='comentario' ROWS='6' COLS='38'></TEXTAREA></div>\n";
	$return .= "<BR>\n";
	$return .= "<center><input type='submit' name='mysubmit' value='Comentar!'/></center>\n";
	$return .= "</form>\n";
	$return .= "</div>\n";
	$return .= "<?php \n";
	$return .= "include ('mostra_comentarios.php') \n";
	$return .= "?> \n";
	$return .= "\n\n</body>\n";
	$return .= "\n</html>";

	return $return;
}

function prepare_directory(&$argData){
	$directory = $argData->directory;

	if($argData->subdomain == 1){//se for subdominio verifica se existe diretorio do dominio	
		$arrDir = explode('/', $directory);
		$directory_domain = $arrDir[0].'/'.$arrDir[1];
		if (!file_exists($directory_domain)){
			mkdir($directory_domain, 0777);
		}
	}
	
	if (file_exists($directory)){
		$arrFiles = array ('index.php', 'config.php', 'recebe_post.php', 'mostra_comentarios.php');
		foreach ($arrFiles as $file){
			if (file_exists($directory.$file)) {
				unlink($directory.$file);
			}
		}
	} else {
		mkdir($directory, 0777);
	}
}

function prepare_config_file(){
	$return = '';
	$return .= "<?php \n";
	$return .= 'if(!($conexao = mysql_connect("186.202.50.68", "easyadmin", "ea1751\$d"))) { '." \n";
	$return .= "echo 'Nao foi possivel estabelecer uma conexao com o gerenciador MySQL. Favor Contactar o Administrador.'; \n";
	$return .= "exit; \n";
	$return .= "} \n";
	$return .= 'mysql_select_db("easyadmin", $conexao);' . "\n";
	$return .= "?> \n";
	return $return;
}

function prepare_recebe_post_file(){
	$return = '';
	$return .= "<?php \n";
	$return .= "include('config.php'); \n";
	$return .= "\n \n";
	$return .= 'function escape($string) {'. "\n";
	$return .= '    get_magic_quotes_gpc() ? stripslashes($string) : $string;'. "\n";
	$return .= '    $string = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($string) : mysql_escape_string($string);'. "\n";
	$return .= '    $string = htmlspecialchars($string);';
	$return .= '    return $string;'. "\n";
	$return .= '}'. "\n";
		
	$return .= 'if ($_POST["nome"] != "" && $_POST["email"] != "" && $_POST["comentario"] != ""){ '."\n";
	$return .= '$nome = $_POST["nome"]; '."\n";
	$return .= '$nome = ((trim($nome) != "") && (strlen(trim($nome)) > 3) ) ? trim($nome) : ""; '."\n";	
	$return .= '$nome = escape($nome); '."\n";
	
	$return .= '$email = $_POST["email"];'."\n";
	$return .= '$email = ((trim($email) != "") && (strlen(trim($email)) > 8) ) ? trim($email) : ""; '."\n";	
	$return .= '$email = escape($email);'."\n";	
	
	$return .= '$comentario = $_POST["comentario"]; '."\n";
	$return .= '$comentario = ((trim($comentario) != "") && (strlen(trim($comentario)) > 20) ) ? trim($comentario) : ""; '."\n";
	$return .= '$comentario = escape($comentario); '."\n";
	$return .= '$comentario = str_replace(\'...\', \'.\', $comentario); '."\n";
	$return .= '$comentario = str_replace(\'!!!\', \'!\', $comentario); '."\n";
	
	$return .= '$pos = strrpos($comentario, "href"); '."\n";
	$return .= 'if ($pos === false){ '."\n";
	$return .= '	if((trim($nome) != "") && (trim($email) != "") && (trim($comentario) != "")){ '."\n";
	$return .= '		$sql = "INSERT INTO `comments` (`content_id`, `name`, `email`, `comment`) VALUES (\'".$content_id."\', \'".$nome."\', \'".$email."\', \'".$comentario."\')";'."\n";
	$return .= '		$res = mysql_query($sql,$conexao) or die(mysql_error()); '."\n";
	$return .= '		if($res){'."\n";
	$return .= '			echo "<script type=\'text/javascript\'> alert(\'Seu comentario foi registrado com sucesso e aguarda moderacao.\'); </script>"; '."\n";
	$return .= '			echo "<meta http-equiv=\'refresh\' content=\'3; URL=index.php\'>";'."\n";
	$return .= "		} \n";
	$return .= "	} \n";
	$return .= "} \n";
	$return .= "} \n";
	$return .= "?> \n";	
	return $return;
}

function prepare_mostra_comentarios_file(){
	$return = '';
	$return .= "<?php \n";
	
	$return .= '$sql = "SELECT `id`, `content_id`, `name`, `email`, `comment`, `create_date` ';
	$return .= 'FROM `comments` WHERE `content_id` = ".$content_id. " and `status` = 1 GROUP  BY `email` ORDER BY `create_date` DESC LIMIT 500;";'. "\n";
	$return .= '$result = mysql_query($sql,$conexao) or die(mysql_error());'." \n";
	$return .= '$i = 0; '." \n";
	$return .= '$i = mysql_num_rows($result); # Conta registros '." \n";
	$return .= 'if ($i > 0){ '." \n";
	$return .= 'while ($linha = mysql_fetch_array($result)) { '." \n";
	$return .= '$name = $linha["name"]; '." \n";
	$return .= '$comment  = $linha["comment"]; '." \n";
	$return .= '$data = $linha["create_date"];'." \n";
	$return .= '$month = substr($data,5,2); '." \n";
	$return .= '$day = substr($data,8,2); '." \n";
	$return .= '$year = substr($data,0,4); '." \n";
	$return .= '$hour = substr($data,11,2); '." \n";
	$return .= '$minutes = substr($data,14,2); '." \n";
	$return .= '$data_br = $day."/".$month."/".$year . " " . $hour.":".$minutes; '." \n";
	$return .= 'echo "<div style=\'width:650px;min-height:100px;margin-top:15px;display:table;text-align:justify;\'>";'." \n";
	$return .= 'echo "<b>" . trim(ucwords(strtolower($name))) . "</b> ". $data_br ."<br>" ; '." \n";
	$return .= 'echo "<p>" . trim(ucfirst(strtolower($comment))) . "</p>"; '." \n";
	$return .= 'echo "</div>"; '." \n";
	$return .= "}  \n";
	$return .= "}	 \n";
	$return .= "?> \n";	
	return $return;
}

function generate_files(&$argData){
	$content = prepare_index_file($argData);
	$directory = $argData->directory;
	
	$f = fopen($directory."index.php", "a");
	fwrite($f, "$content");
	fclose($f);
	
	$content = prepare_config_file();
	$f = fopen($directory."config.php", "a");
	fwrite($f, "$content");
	fclose($f);

	$content = prepare_recebe_post_file();
	$f = fopen($directory."recebe_post.php", "a");
	fwrite($f, "$content");
	fclose($f);

	$content = prepare_mostra_comentarios_file();
	$f = fopen($directory."mostra_comentarios.php", "a");
	fwrite($f, "$content");
	fclose($f);

}

function generate_htaccess_file(&$argData){
	$directory = $argData->directory;
	$arrDir = explode('/', $directory);
	$hosts = $arrDir[0];
	$domain = $arrDir[1];
	$subDomain = $arrDir[2];
	
	$htaccess = "";	
	if (!file_exists($hosts.'/'.$domain.'/.htaccess')){
		$htaccess .= "RewriteEngine On \n";
		$htaccess .= "RewriteBase /";
	}

	$htaccess .= "\n";
	$htaccess .= "RewriteCond %{HTTP_HOST} !^www\.".$domain."\.com\.br \n";
	$htaccess .= "RewriteCond %{HTTP_HOST}%{REQUEST_URI} ".$subDomain."\.".$domain."\.com\.br\/?$ \n";
	$htaccess .= "RewriteRule ^(.*)$ \/".$subDomain."\/index.php [L] \n";
	
	$f = fopen($hosts.'/'.$domain.'/.htaccess', "a");	
	fwrite($f, "$htaccess");
	fclose($f);
}

function update_content(&$argData){
	prepare_directory($argData); //se o diretorio existe, apaga os arquivos do diretorio senao cria o diretorio
	generate_files($argData); //gera todos os arquivos atualizados no diretorio
	
	if($argData->subdomain == 1 && $argData->updated == 0){//se for subdominio e nao foi atualizado, gera o arquivo .htaccess no diretorio
		generate_htaccess_file($argData);
	}
	
	return true;
}