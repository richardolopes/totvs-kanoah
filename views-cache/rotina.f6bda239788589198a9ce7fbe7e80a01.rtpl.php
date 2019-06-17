<?php if(!class_exists('Rain\Tpl')){exit;}?><form action="/gerarkanoah" method="GET">
	<!-- Módulo selecionado no index.hmtl -->
	<label for="modulo">Módulo selecionado:
		<input type="text" name="modulo" value="<?php echo htmlspecialchars( $modulo, ENT_COMPAT, 'UTF-8', FALSE ); ?>" readonly>
	</label>
	<br><br>
	<!-- Rotina selecionada no index.hmtl -->
	<label for="rotina">Rotina selecionada:
		<input type="text" name="rotina" value="<?php echo htmlspecialchars( $rotina, ENT_COMPAT, 'UTF-8', FALSE ); ?>" readonly>
	</label>
	<br><br>
	<!-- Tabelas da rotina -->
	<label>Tabelas:</label>
	<br>
	<?php $counter1=-1;  if( isset($tabelas) && ( is_array($tabelas) || $tabelas instanceof Traversable ) && sizeof($tabelas) ) foreach( $tabelas as $key1 => $value1 ){ $counter1++; ?>
	<label><?php echo htmlspecialchars( $value1["TABELA"], ENT_COMPAT, 'UTF-8', FALSE ); ?><button type="button" onclick="copiarQuery('QUERY<?php echo htmlspecialchars( $value1["TABELA"], ENT_COMPAT, 'UTF-8', FALSE ); ?>')">Copiar Query</button>
		<textarea id="QUERY<?php echo htmlspecialchars( $value1["TABELA"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" cols="30" rows="3"
			readonly><?php echo htmlspecialchars( $value1["QUERY"], ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea>
	</label>
	<?php $campos = $value1["CAMPOS"]; ?>
	<textarea cols="20" rows="3" readonly>
		<?php $counter2=-1;  if( isset($campos) && ( is_array($campos) || $campos instanceof Traversable ) && sizeof($campos) ) foreach( $campos as $key2 => $value2 ){ $counter2++; ?>
			<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?>
		<?php } ?>
	</textarea>
	<br>
	<?php } ?>
	<br>
	<label>Dependencias:</label>
	<br>
	<?php $counter1=-1;  if( isset($dependencias) && ( is_array($dependencias) || $dependencias instanceof Traversable ) && sizeof($dependencias) ) foreach( $dependencias as $key1 => $value1 ){ $counter1++; ?>
	<label for=""><a href="/tabela/<?php echo htmlspecialchars( $value1["TABELA"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" target="_blank"><?php echo htmlspecialchars( $value1["TABELA"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
		<select name="<?php echo htmlspecialchars( $value1["TABELA"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" id="<?php echo htmlspecialchars( $value1["TABELA"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
			<option value="query">Query</option>
			<?php $counter2=-1;  if( isset($value1["REGISTROS"]) && ( is_array($value1["REGISTROS"]) || $value1["REGISTROS"] instanceof Traversable ) && sizeof($value1["REGISTROS"]) ) foreach( $value1["REGISTROS"] as $key2 => $value2 ){ $counter2++; ?>
			<option value="<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
			<?php } ?>
		</select>
		<button type="button" onclick="copiarQuery('QUERY<?php echo htmlspecialchars( $value1["TABELA"], ENT_COMPAT, 'UTF-8', FALSE ); ?>')">Copiar Query</button>
		<textarea id="QUERY<?php echo htmlspecialchars( $value1["TABELA"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" cols="30" rows="3" readonly><?php echo htmlspecialchars( $value1["QUERY"], ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea>
	</label>
	<br>
	<?php } ?>

	<label for="resultado">Querys aqui:
		<textarea name="resultado" id="resultado" cols="30" rows="10"></textarea>
	</label>
	<br>
	<input type="submit" value="Enviar">
</form>