<?php if(!class_exists('Rain\Tpl')){exit;}?><script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load("jquery", "1.4.2");
</script>

<script>
	$(function () {
		$('#modulo').change(function () {
			if ($(this).val()) {
				$.getJSON("/modulos/rotinas/" + $("#modulo").val(), function (j) {
					var rotinas = "<option value=''>Selecione uma rotina</option>'";

					$.each(j, function (key, value) {
						rotinas += '<option value="' + value + '">' + value + '</option>';
					});
					
					$("#rotina").html(rotinas);
					$('#rotina').click();
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
			$.post("/kanoah/query", {query: $("#query").val()}, function (data) {
				var resultado = $("#resultado").val() + data; 
				$("#resultado").html(resultado);
			});
		}
	}
</script>

<script>
	function copiarQuery(idquery) {
		var copyText = document.getElementById(idquery);
		copyText.select();
		document.execCommand("copy");
	}
</script>