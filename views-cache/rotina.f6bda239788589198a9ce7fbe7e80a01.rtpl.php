<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Módulo selecionado no index.hmtl -->
<label for="modulo">Módulo selecionado:
	<input type="text" value="<?php echo htmlspecialchars( $modulo, ENT_COMPAT, 'UTF-8', FALSE ); ?>" readonly>
</label>
<br><br>
<!-- Rotina selecionada no index.hmtl -->
<label for="rotina">Rotina selecionada:
	<input type="text" value="<?php echo htmlspecialchars( $rotina, ENT_COMPAT, 'UTF-8', FALSE ); ?>" readonly>
</label>
<br><br>
<!-- Cadastros obrigatórios -->
<label>Dependencias:</label>
<br><br>
<?php $counter1=-1;  if( isset($dependencias) && ( is_array($dependencias) || $dependencias instanceof Traversable ) && sizeof($dependencias) ) foreach( $dependencias as $key1 => $value1 ){ $counter1++; ?>
	<?php $counter2=-1;  if( isset($value1) && ( is_array($value1) || $value1 instanceof Traversable ) && sizeof($value1) ) foreach( $value1 as $key2 => $value2 ){ $counter2++; ?>
		<?php $tabela=$key2; ?>
		<label for="<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?></label><br>
		<label>
			<input type="radio" name="<?php echo htmlspecialchars( $tabela, ENT_COMPAT, 'UTF-8', FALSE ); ?>" id="query">Query
			<!-- <br> -->
			<textarea name="<?php echo htmlspecialchars( $tabela, ENT_COMPAT, 'UTF-8', FALSE ); ?>" id="query" cols="30" rows="2"></textarea>
		</label>
		<br>
		<?php $counter3=-1;  if( isset($value2) && ( is_array($value2) || $value2 instanceof Traversable ) && sizeof($value2) ) foreach( $value2 as $key3 => $value3 ){ $counter3++; ?>
		<label>
			<input type="radio" name="<?php echo htmlspecialchars( $tabela, ENT_COMPAT, 'UTF-8', FALSE ); ?>" id="<?php echo htmlspecialchars( $value3, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value3, ENT_COMPAT, 'UTF-8', FALSE ); ?>
		</label>
		<br>
		<?php } ?>
	<?php } ?>
<?php } ?>




<!-- Registros gerados -->
