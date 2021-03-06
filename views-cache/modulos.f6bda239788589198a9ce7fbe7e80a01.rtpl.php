<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
	<section class="content-header">
		<h1>
			Módulos
		</h1>
		<br>
		<div class="box-tools">
			<a style="cursor: pointer" onclick="criarModulo()"><i class="fa fa-codepen"></i> <span>Adicionar
					Módulo</span></a>
		</div>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<?php $counter1=-1;  if( isset($modulos) && ( is_array($modulos) || $modulos instanceof Traversable ) && sizeof($modulos) ) foreach( $modulos as $key1 => $value1 ){ $counter1++; ?>

				<div class="col-md-2">
					<!-- Widget: user widget style 1 -->
					<div class="box box-widget widget-user-2">
						<!-- Add the bg color to the header using any of the bg-* classes -->
						<div class="widget-user-header label-primary">
							<div class="widget-user-image">
								<a href="/modulo/<?php echo htmlspecialchars( $value1["modulo"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
									<h3 style="color: white; font-family: monospace;"><?php echo htmlspecialchars( $value1["modulo"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <i class="fa fa-arrow-circle-right"></i>
									</h3>
								</a>
							</div>
						</div>
					</div>
					<!-- /.widget-user -->
				</div>
				<?php } ?>

				<!-- /.box-body -->
				<!-- /.box -->
			</div>
		</div>
	</section>
</div>

<script>
	function criarModulo() {
		swal({
			icon: "info",
			title: "Criar módulo",
			text: "Nome do módulo:",
			buttons: [
				"Cancelar",
				"Criar"
			],
			dangerMode: true,
			content: {
				element: "input",
				attributes: {
					type: "text",
				},
			},
		}).then((Criar) => {
			if (Criar) {
				console.log(Criar);
				$.post('/modulo/criar', {
					modulo: Criar
				}, function (data) {
					console.log(data)
					if (data) {
						swal("Módulo criado!", {
							icon: "success",
						}).then(() => {
							window.location.reload();
						});
					}
				}).fail(function () {
					swal({
						icon: "error",
						title: "Ooops!",
						text: "Não foi possível criar o módulo.",
					});
				});
			}
		});
	}
</script>