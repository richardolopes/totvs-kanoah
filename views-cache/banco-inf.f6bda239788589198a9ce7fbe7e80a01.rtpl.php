<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
	<section class="content-header">
		<h1>
			Banco de dados
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
						<!-- text input -->
						<div class="form-group">
							<label>SERVER:</label>
							<input type="text" id="SERVER" name="SERVER" class="form-control" value="<?php echo htmlspecialchars( $server, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						</div>
						<div class="form-group">
							<label>DATABASE:</label>
							<input type="text" id="DATABASE" name="DATABASE" class="form-control" maxlength="50"
								value="<?php echo htmlspecialchars( $database, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						</div>
						<div class="form-group">
							<label>USER:</label>
							<input type="text" id="USER" name="USER" class="form-control" maxlength="50"
								value="<?php echo htmlspecialchars( $user, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						</div>
						<div class="form-group">
							<label>PASSWORD:</label>
							<input type="password" id="PASSWORD" name="PASSWORD" class="form-control" maxlength="50"
								value="<?php echo htmlspecialchars( $password, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						</div>
					</div>
					<div class="box-footer">
						<a href="/banco/reset" class="btn btn-danger">Resetar configurações</a>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
	</section>
</div>