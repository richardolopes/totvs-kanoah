<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
	<section class="content-header">
		<h1>
			Adicionar Rotina
		</h1>
		<br>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h3 class="box-title">Informações da rotina</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<form role="form" action="/rotina/add" method="POST">
							<!-- text input -->
							<div class="form-group">
								<label>Rotina:</label>
								<input type="text" id="rotina" name="rotina" class="form-control"
									placeholder="Ex: FINA070">
							</div>
							<div class="form-group">
								<label>Nome da Rotina:</label>
								<input type="text" id="nome" name="nome" class="form-control" maxlength="50"
									placeholder="Ex: Baixas a Receber">
							</div>
							<div class="box-footer">
								<button type="submit" class="btn btn-success">Enviar</button>
							</div>
						</form>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
	</section>
</div>