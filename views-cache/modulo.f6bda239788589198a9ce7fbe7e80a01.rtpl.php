<?php if(!class_exists('Rain\Tpl')){exit;}?><label for="modulo">Módulo:
	<input type="text" value="<?php echo htmlspecialchars( $modulo, ENT_COMPAT, 'UTF-8', FALSE ); ?>" readonly>
</label>

<label for="rotina">Rotinas cadastradas:
	<select id="rotina" name="rotina">
		<option value="">Selecione uma rotina</option>
		<?php echo retornarRotinas($modulo); ?>
	</select>
</label>
