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
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Query</h3>
					</div>
					<div class="box-body">
						<label for="query"></label><br>
						<textarea class="form-control" name="query" id="query" rows="10"></textarea><br>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-body">
						<button class="btn btn-success" onclick="resultadoCongelada()">Enviar</button>
						<button class="btn btn-info" onclick="copiar('resultado')">Copiar</button>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Resultado</h3>
					</div>
					<div class="box-body">
						<label for="resultado"></label><br>
						<textarea class="form-control" name="resultado" id="resultado" rows="10"></textarea><br>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>