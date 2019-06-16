<?php if(!class_exists('Rain\Tpl')){exit;}?><form action="">
	<!-- Módulo selecionado no index.hmtl -->
	<label for="modulo">Módulo selecionado:
		<input type="text" value="<?php echo htmlspecialchars( $modulo, ENT_COMPAT, 'UTF-8', FALSE ); ?>" readonly>
	</label>
	<br><br>
	<!-- Rotina selecionada no index.hmtl -->
	<label for="rotina">Rotina selecionada:
		<input type="text" value="<?php echo htmlspecialchars( $rotina, ENT_COMPAT, 'UTF-8', FALSE ); ?>" readonly>
	</label>
	<br><br>
	<!-- Tabelas da rotina -->
	<?php $counter1=-1;  if( isset($tabelas) && ( is_array($tabelas) || $tabelas instanceof Traversable ) && sizeof($tabelas) ) foreach( $tabelas as $key1 => $value1 ){ $counter1++; ?>
	<label><?php echo htmlspecialchars( $value1["TABELA"], ENT_COMPAT, 'UTF-8', FALSE ); ?>
		<textarea name="<?php echo htmlspecialchars( $value1["TABELA"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" id="<?php echo htmlspecialchars( $value1["TABELA"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" cols="30" rows="3" readonly><?php echo htmlspecialchars( $value1["QUERY"], ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea>
	</label>
	<?php $campos = $value1["CAMPOS"]; ?>
	<textarea cols="20" rows="3" readonly>
		<?php $counter2=-1;  if( isset($campos) && ( is_array($campos) || $campos instanceof Traversable ) && sizeof($campos) ) foreach( $campos as $key2 => $value2 ){ $counter2++; ?>
			<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?>
		<?php } ?>
	</textarea>
	<label>Resultado Query:
		<textarea name="<?php echo htmlspecialchars( $value1["TABELA"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" cols="30" rows="3"></textarea>
	</label>
	<br>
	<?php } ?>

	<input type="submit" value="Enviar">
</form>