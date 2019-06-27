<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
		<section class="content-header">
			<h1>
				Gerar Kanoah
				<small><?php echo htmlspecialchars( $modulo, ENT_COMPAT, 'UTF-8', FALSE ); ?> &nbsp; <?php echo htmlspecialchars( $rotina, ENT_COMPAT, 'UTF-8', FALSE ); ?></small>
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
				<form action="/admin/gerarkanoah" method="POST">
					<div class="col-md-6">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Pré-condições</h3>
							</div>
							<div class="box-body">
								<?php $counter1=-1;  if( isset($precondicoes) && ( is_array($precondicoes) || $precondicoes instanceof Traversable ) && sizeof($precondicoes) ) foreach( $precondicoes as $key1 => $value1 ){ $counter1++; ?>
								<?php $counter2=-1;  if( isset($value1) && ( is_array($value1) || $value1 instanceof Traversable ) && sizeof($value1) ) foreach( $value1 as $key2 => $value2 ){ $counter2++; ?>
								<label for="<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>QUERY"><?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?></label><br>
								<textarea class="form-control" name="<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>QUERY" id="<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>QUERY" cols="50"
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
								<?php $counter1=-1;  if( isset($precondicoes) && ( is_array($precondicoes) || $precondicoes instanceof Traversable ) && sizeof($precondicoes) ) foreach( $precondicoes as $key1 => $value1 ){ $counter1++; ?>
								<?php $counter2=-1;  if( isset($value1) && ( is_array($value1) || $value1 instanceof Traversable ) && sizeof($value1) ) foreach( $value1 as $key2 => $value2 ){ $counter2++; ?>
								<label for="<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>WHERE"><?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?></label><br>
								<textarea class="form-control" name="<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>WHERE" id="<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>WHERE" cols="50"
									rows="3"></textarea><br>
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
								<?php $counter1=-1;  if( isset($resultado) && ( is_array($resultado) || $resultado instanceof Traversable ) && sizeof($resultado) ) foreach( $resultado as $key1 => $value1 ){ $counter1++; ?>
								<?php $counter2=-1;  if( isset($value1) && ( is_array($value1) || $value1 instanceof Traversable ) && sizeof($value1) ) foreach( $value1 as $key2 => $value2 ){ $counter2++; ?>
								<label for="<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>QUERY"><?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?></label><br>
								<textarea class="form-control" name="<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>QUERY" id="<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>QUERY" cols="50"
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
								<?php $counter1=-1;  if( isset($resultado) && ( is_array($resultado) || $resultado instanceof Traversable ) && sizeof($resultado) ) foreach( $resultado as $key1 => $value1 ){ $counter1++; ?>
								<?php $counter2=-1;  if( isset($value1) && ( is_array($value1) || $value1 instanceof Traversable ) && sizeof($value1) ) foreach( $value1 as $key2 => $value2 ){ $counter2++; ?>
								<label for="<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>WHERE"><?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?></label><br>
								<textarea class="form-control" name="<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>WHERE" id="<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>WHERE" cols="50"
									rows="3"></textarea><br>
								<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
	
					<button type="submit">Enviar</button>
				</form>
			</div>
		</section>
	</div>