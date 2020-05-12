<?php if(!class_exists('Rain\Tpl')){exit;}?><script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load("jquery", "1.4.2");
</script>

<script>
	$(function () {
		$('#modulo').change(function () {
			if ($(this).val()) {
				$.getJSON("/modulo/" + $("#modulo").val() + "/rotinas", function (j) {
					var rotinas = '<option value="">Selecione uma rotina</option>';

					$.each(j, function (key, value) {
						rotinas += '<option value="' + value + '">' + value + '</option>';
					});

					$("#rotina").html(rotinas);
				});
			}
		});
	});
</script>

<script>
	function resultado() {
		if ($("#query").val() == null || $("#query").val() == "") {
			swal("Digite a query.", "", "error");
		} else {
			swal({
				title: "Carregando...",
				icon: "/res/loading.gif",
				onOpen: () => {
					swal.showLoading()
				}
			});

			$.post("/kanoah/query", {
				query: $("#query").val()
			}, function (data) {
				var resultado = $("#resultado").val() + data;
				$("#resultado").html(resultado + "<br>");

				setTimeout(function () {
					swal.close()
				}, 1000);

			});
		}
	}
</script>

<script>
	function resultadoCongelada() {
		if ($("#query").val() == null || $("#query").val() == "") {
			swal("Digite a query.", "", "error");
		} else {
			swal({
				title: "Carregando...",
				icon: "/res/loading.gif",
				onOpen: () => {
					swal.showLoading()
				}
			});

			$.post("/congelada/query", {
				query: $("#query").val()
			}, function (data) {
				var resultado = $("#resultado").val() + data;
				$("#resultado").html(resultado + "\n");

				setTimeout(function () {
					swal.close()
				}, 1000);

			});
		}
	}
</script>

<script>
	function copiar(idquery) {
		var copyText = document.getElementById(idquery).html();
		copyText.select();
		document.execCommand("copy");
	}
</script>

<script>
	function deletar(url) {
		swal({
			title: "Excluir",
			text: "Você tem certeza que deseja excluir este item?",
			icon: "warning",
			buttons: [
				"Cancelar",
				"Sim!"
			],
			dangerMode: true,
		}).then((willDelete) => {
			if (willDelete) {
				$.get(url, function () {
					swal("Excluído!", {
						icon: "success",
					}).then(() => {
						window.location.reload();
					});
				});
			}
		});
	}
</script>

<script>
	function aguardar() {
		swal({
			title: "Carregando...",
			icon: "/res/loading.gif",
			onOpen: () => {
				swal.showLoading()
			}
		});
	}
</script>