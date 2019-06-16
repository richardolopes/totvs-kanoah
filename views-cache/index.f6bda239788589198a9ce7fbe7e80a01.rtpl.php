<?php if(!class_exists('Rain\Tpl')){exit;}?><form action="/rotina" method="GET">
	<select id="modulo" name="modulo">
		<option value="">Selecione um módulo</option>
		<?php $counter1=-1;  if( isset($modulos) && ( is_array($modulos) || $modulos instanceof Traversable ) && sizeof($modulos) ) foreach( $modulos as $key1 => $value1 ){ $counter1++; ?>
			<option value="<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
		<?php } ?>
	</select>

	<select id="rotina" name="rotina">
		<option value="">Selecione uma rotina</option>
	</select>

	<input type="submit" value="Enviar">
</form>

