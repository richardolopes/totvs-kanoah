<?php if(!class_exists('Rain\Tpl')){exit;}?><?php require $this->checkTemplate("errors");?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			<?php echo htmlspecialchars( $nome, ENT_COMPAT, 'UTF-8', FALSE ); ?> - <a style="cursor: alias" target="_blank"
				href="https://github.com/richardolopes/totvs-kanoah">GitHub <i class="fa fa-github"></i></a>
		</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Atualizações:</h3>
					</div>
					<div class="box-body">

						<div class="callout callout-danger">
							<h4>Banco de dados.</h4>
							<p>
								Foi implementado no <?php echo htmlspecialchars( $nome, ENT_COMPAT, 'UTF-8', FALSE ); ?> a configuração da conexão com o banco de dados. Acesse as
								configurações da conexão com o banco de dados no menu ou <a href="/banco/inf">clique
									aqui.</a>
							</p>
						</div>

						<!-- <div class="callout callout-danger">
							<h4>TITULO</h4>
							<p>
								TEXTO
							</p>
						</div> -->


					</div>
				</div>
			</div>
		</div>
	</section>
</div>