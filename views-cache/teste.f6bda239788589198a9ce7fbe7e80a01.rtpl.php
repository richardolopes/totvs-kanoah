<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
	<section class="content-header">
		<h1>
			Módulos
		</h1>
	</section>
	<section class="content">

			<button onclick="criarModulo()">Button</button>
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
				"Criar!"
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
				$.post('/add/modulo', {modulo: Criar}, function(data) {
					console.log(data)
					if (data) {
						swal("Módulo criado!", {
							icon: "success",
						}).then(() => {
							// window.location.reload();
						});
					}
				}).fail(function() {
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