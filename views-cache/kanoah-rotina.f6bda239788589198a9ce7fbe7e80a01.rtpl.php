<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
	<section class="content-header">
		<h1>
			Gerar Kanoah
		</h1>
	</section>
	<!-- <select class="form-control" id="modulo" name="modulo">
			<option value="">Selecione os parâmetros</option>
			<?php $counter1=-1;  if( isset($parametros) && ( is_array($parametros) || $parametros instanceof Traversable ) && sizeof($parametros) ) foreach( $parametros as $key1 => $value1 ){ $counter1++; ?>
			<option value="<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
			<?php } ?>
		</select> -->

	<section class="content">
		<div class="row">
			<form action="/kanoah/rotina/gerar" method="POST" enctype="multipart/form-data">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-body">
							<div class="col-md-6">
								<label for="modulo">Módulo: </label>
								<input type="text" class="form-control" name="modulo" id="modulo" readonly value=<?php echo htmlspecialchars( $modulo, ENT_COMPAT, 'UTF-8', FALSE ); ?>>
								<label for="rotina">Rotina: </label>
								<input type="text" class="form-control" name="rotina" id="rotina" readonly value=<?php echo htmlspecialchars( $rotina, ENT_COMPAT, 'UTF-8', FALSE ); ?>>
							</div>
							<div class="col-md-6">
								<label for="modulo">Grupo de empresa: </label>
								<input type="text" class="form-control" name="grupo" id="grupo" value="T1">
								<label for="modulo">Filial: </label>
								<input type="text" class="form-control" name="filial" id="filial" value="D MG 01 ">
								<label for="modulo">Data base: </label>
								<input type="date" class="form-control" name="database" id="database">
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Pré-condições</h3>
						</div>
						<div class="box-body">
							<?php $counter1=-1;  if( isset($tabelas["precondicao"]) && ( is_array($tabelas["precondicao"]) || $tabelas["precondicao"] instanceof Traversable ) && sizeof($tabelas["precondicao"]) ) foreach( $tabelas["precondicao"] as $key1 => $value1 ){ $counter1++; ?>
							<?php $counter2=-1;  if( isset($value1) && ( is_array($value1) || $value1 instanceof Traversable ) && sizeof($value1) ) foreach( $value1 as $key2 => $value2 ){ $counter2++; ?>
							<label for="PRE<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>QUERY" onclick="copiar('PRE<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>QUERY')"><?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?></label><br>
							<textarea class="form-control" name="PRE<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>QUERY" id="PRE<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>QUERY" cols="50"
								rows="3"><?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea><br>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Where</h3>
						</div>
						<div class="box-body">
							<?php $counter1=-1;  if( isset($tabelas["precondicao"]) && ( is_array($tabelas["precondicao"]) || $tabelas["precondicao"] instanceof Traversable ) && sizeof($tabelas["precondicao"]) ) foreach( $tabelas["precondicao"] as $key1 => $value1 ){ $counter1++; ?>
							<?php $aux=$key1+1; ?>
							<?php $counter2=-1;  if( isset($value1) && ( is_array($value1) || $value1 instanceof Traversable ) && sizeof($value1) ) foreach( $value1 as $key2 => $value2 ){ $counter2++; ?>
							<label for="PRE<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>WHERE" onclick="copiar('PRE<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>WHERE')"><?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?></label><br>
							<textarea class="form-control" name="PRE<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>WHERE" id="PRE<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>WHERE" cols="50" rows="3"
								tabindex=<?php echo htmlspecialchars( $aux, ENT_COMPAT, 'UTF-8', FALSE ); ?>>R_E_C_N_O_ </textarea><br>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Resultado esperado</h3>
						</div>
						<div class="box-body">
							<?php $counter1=-1;  if( isset($tabelas["resultado"]) && ( is_array($tabelas["resultado"]) || $tabelas["resultado"] instanceof Traversable ) && sizeof($tabelas["resultado"]) ) foreach( $tabelas["resultado"] as $key1 => $value1 ){ $counter1++; ?>
							<?php $counter2=-1;  if( isset($value1) && ( is_array($value1) || $value1 instanceof Traversable ) && sizeof($value1) ) foreach( $value1 as $key2 => $value2 ){ $counter2++; ?>
							<label for="RES<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>QUERY" onclick="copiar('RES<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>QUERY')"><?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?></label><br>
							<textarea class="form-control" name="RES<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>QUERY" id="RES<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>QUERY" cols="50"
								rows="3"><?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea><br>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Where</h3>
						</div>
						<div class="box-body">
							<?php $counter1=-1;  if( isset($tabelas["resultado"]) && ( is_array($tabelas["resultado"]) || $tabelas["resultado"] instanceof Traversable ) && sizeof($tabelas["resultado"]) ) foreach( $tabelas["resultado"] as $key1 => $value1 ){ $counter1++; ?>
							<?php $aux+=1; ?>
							<?php $counter2=-1;  if( isset($value1) && ( is_array($value1) || $value1 instanceof Traversable ) && sizeof($value1) ) foreach( $value1 as $key2 => $value2 ){ $counter2++; ?>
							<label for="RES<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>WHERE" onclick="copiar('RES<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>WHERE')"><?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?></label><br>
							<textarea class="form-control" name="RES<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>WHERE" id="RES<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>WHERE" cols="50" rows="3"
								tabindex="<?php echo htmlspecialchars( $aux, ENT_COMPAT, 'UTF-8', FALSE ); ?>">R_E_C_N_O_ </textarea><br>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
				</div>


				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-body">
							<button type="submit" tabindex="<?php echo htmlspecialchars( $aux+1, ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-success">Enviar</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
</div>