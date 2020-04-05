<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
	<section class="content-header">
		<h1>
			Gerar Kanoah
		</h1>
	</section>

	<section class="content">
		<div class="row">
			<form action="/kanoah/rotina/pre" method="POST">
				<div class="col-md-6">
					<div class="box box-primary">
						<div class="box-body">
							<div class="form-group">
								<label>&nbsp; Módulos:</label>
								<select class="form-control" id="modulo" name="modulo">
									<option value="">Selecione um módulo</option>
									<?php $counter1=-1;  if( isset($modulos) && ( is_array($modulos) || $modulos instanceof Traversable ) && sizeof($modulos) ) foreach( $modulos as $key1 => $value1 ){ $counter1++; ?>

									<option value="<?php echo htmlspecialchars( $value1["modulo"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["modulo"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
									<?php } ?>

								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="box box-primary">
						<div class="box-body">
							<div class="form-group">
								<label>&nbsp; Rotinas:</label>
								<select class="form-control" id="rotina" name="rotina">
									<option value="">Selecione uma rotina</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-body">
							<button type="submit" class="btn btn-success">Enviar</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
</div>