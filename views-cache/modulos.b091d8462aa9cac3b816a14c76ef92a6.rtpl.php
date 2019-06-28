<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Módulos cadastrados</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body table-responsive no-padding">
							<table class="table table-hover">
								<tr>
									<th>Módulo</th>
									<th>Nº Rotina</th>
									<th>Nº Parâmetros</th>
									<th>Adicionar</th>
								</tr>
								<?php $counter1=-1;  if( isset($modulos) && ( is_array($modulos) || $modulos instanceof Traversable ) && sizeof($modulos) ) foreach( $modulos as $key1 => $value1 ){ $counter1++; ?>
								<tr>
									<td><?php echo htmlspecialchars( $value1["MODULO"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
									<td><?php echo htmlspecialchars( $value1["ROTINAS"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
									<td><?php echo htmlspecialchars( $value1["PARAMETROS"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
								</tr>
								<?php } ?>
							</table>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
			</div>
		</section>
	</div>