<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
	<section class="content-header">
		<h1>
			Rotinas
		</h1>
		<br>
		<div class="box-tools">
			<a style="cursor: pointer" onclick="adicionarRotina()"><i class="fa fa-codepen"></i> <span>Adicionar
					Rotina</span></a>
		</div>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<?php $counter1=-1;  if( isset($rotinas) && ( is_array($rotinas) || $rotinas instanceof Traversable ) && sizeof($rotinas) ) foreach( $rotinas as $key1 => $value1 ){ $counter1++; ?>

				<div class="col-md-2">
					<div class="box box-widget widget-user-2">
						<div class="widget-user-header label-primary">
							<div class="widget-user-image">
								<a href="/rotina/<?php echo htmlspecialchars( $value1["rotina"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
									<h3 style="color: white; font-family: monospace;"><?php echo htmlspecialchars( $value1["rotina"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <i class="fa fa-arrow-circle-right"></i>
									</h3>
								</a>
							</div>

						</div>
					</div>
				</div>
				<?php } ?>

			</div>
		</div>
	</section>
</div>
<script>
	function adicionarRotina() {
		swal({
			icon: "info",
			title: "Adicionar rotina",
			text: "Nome do rotina:",
			buttons: [
				"Cancelar",
				"Adicionar"
			],
			dangerMode: true,
			content: {
				element: "input",
				attributes: {
					type: "text",
				},
			},
		}).then((Adicionar) => {
			swal({
				title: "Carregando...",
				icon: "/res/loading.gif",
				onOpen: () => {
					swal.showLoading()
				}
			});

			if (Adicionar) {
				$.post('/rotina/add', {
					rotina: Adicionar
				}, function (data) {
					if (data) {
						swal("Rotina criada!", {
							icon: "success",
						}).then(() => {
							window.location.reload();
						});
					}
				}).fail(function () {
					swal({
						icon: "error",
						title: "Ooops!",
						text: "Não foi possível adicionar a rotina.",
					});
				});
			}
		});
	}
</script>