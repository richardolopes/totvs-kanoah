<?php if(!class_exists('Rain\Tpl')){exit;}?><style>
	textarea {
 		font-family: Courier New Black
	}
</style>

<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Kanoah
		</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Pré-condições</h3>
					</div>
					<div class="box-body">
						<label for="precondicoes"></label><br>
						<textarea class="form-control" name="precondicoes" id="precondicoes" rows="16"><?php echo htmlspecialchars( $precondicao, ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea><br>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Resultado esperado</h3>
					</div>
					<div class="box-body">
						<label for="resultado"></label><br>
						<textarea class="form-control" name="resultado" id="resultado" rows="16"><?php echo htmlspecialchars( $resultado, ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea><br>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>