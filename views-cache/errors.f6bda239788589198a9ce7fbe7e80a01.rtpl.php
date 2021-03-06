<?php if(!class_exists('Rain\Tpl')){exit;}?><?php if( $error != '' ){ ?>


<?php if( $error == 'AUTOMACAO_EXIST' ){ ?>

<script>
	swal("A última data já foi gerada.", "", "info");
</script>
<?php } ?>


<?php if( $error == 'user_where' ){ ?>

<script>
	swal("Não digite WHERE.", "", "error");
</script>
<?php } ?>


<?php if( $error == 'PARAMETROS_ATT' ){ ?>

<script>
	swal("Parâmetros atualizados com sucesso.", "", "success");
</script>
<?php } ?>


<?php if( $error == 'sem_conexao' ){ ?>

<script>
	swal("Sem conexão com o banco de dados.", "", "error");
</script>
<?php } ?>


<?php if( $error == 'TABELA_JA_CADASTRADA' ){ ?>

<script>
	swal("Tabela já cadastrada para essa rotina.", "", "error");
</script>
<?php } ?>


<?php if( $error == 'ROTINA_NOTFOUND' ){ ?>

<script>
	swal("Rotina não encontrada na sua base.", "", "error");
</script>
<?php } ?>


<?php if( $error == 'EMPTY_POSTPRE QUERY/WHERE' ){ ?>

<script>
	swal("Preencha todos os WHERES da pré-condição.", "", "warning");
</script>
<?php } ?>


<?php if( $error == 'EMPTY_POSTRES QUERY/WHERE' ){ ?>

<script>
	swal("Preencha todos os WHERES do resultado esperado.", "", "warning");
</script>
<?php } ?>


<?php if( $error == 'EMPTY_QUERYS' ){ ?>

<script>
	swal("Preencha todos as QUERYS.", "", "warning");
</script>
<?php } ?>


<?php if( $error == 'page_undefined' ){ ?>

<script>
	swal({
			title: "Página não encontrada.",
			text: "Você foi redirecionado(a) para página inicial.",
			icon: "error"
		})
		.then((value) => {
			window.location.assign("/");
		});
</script>
<?php } ?>


<?php if( $error == 'database_undefined' ){ ?>

<script>
	swal("Seu banco de dados ainda não foi configurado.", "", "error");
	swal({
			title: "Banco de dados não conectado.",
			text: "Seu banco de dados ainda não foi configurado. Você foi redirecionado(a) para página de configuração.",
			icon: "error"
		})
		.then((value) => {
			window.location.assign("/");
		});
</script>
<?php } ?>


<?php } ?>