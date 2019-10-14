<?php if(!class_exists('Rain\Tpl')){exit;}?><?php require $this->checkTemplate("errors");?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Configurar banco de dados
		</h1>
		<br>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h3 class="box-title">Informações do banco de dados:</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<form role="form" action="/banco" method="POST">
							<!-- text input -->
							<div class="form-group">
								<label>SERVER:</label>
								<input type="text" id="SERVER" name="SERVER" class="form-control"
									placeholder="Ex: SPON010104935">
							</div>
							<div class="form-group">
								<label>DATABASE:</label>
								<input type="text" id="DATABASE" name="DATABASE" class="form-control" maxlength="50"
									placeholder="Ex: P12123MNTDB">
							</div>
							<div class="form-group">
								<label>USER:</label>
								<input type="text" id="USER" name="USER" class="form-control" maxlength="50"
									placeholder="Ex: sa">
							</div>
							<div class="form-group">
								<label>PASSWORD:</label>
								<input type="password" id="PASSWORD" name="PASSWORD" class="form-control" maxlength="50"
									placeholder="Ex: 1234">
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