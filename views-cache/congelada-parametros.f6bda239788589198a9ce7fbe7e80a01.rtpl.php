<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
	<!-- <section class="content-header">
		<h1>
			Kanoah
		</h1>
	</section> -->

	<section class="content">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Parâmetros alterados</h3>
					<div class="pull-right">
						<a href="#"><i class="fa fa-plus"></i>
							<span>&nbsp;Alterar parâmetro</span></a>
					</div>
				</div>
				<div class="box-body">
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tr>
								<th>Parâmetro</th>
								<th>Descrição</th>
								<th>Valor</th>
							</tr>
							<?php $counter1=-1;  if( isset($parametros) && ( is_array($parametros) || $parametros instanceof Traversable ) && sizeof($parametros) ) foreach( $parametros as $key1 => $value1 ){ $counter1++; ?>
							<tr>
								<td><?php echo htmlspecialchars( $key1, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
								<?php $counter2=-1;  if( isset($value1) && ( is_array($value1) || $value1 instanceof Traversable ) && sizeof($value1) ) foreach( $value1 as $key2 => $value2 ){ $counter2++; ?>
								<td><?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
								<td><?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
								<?php } ?>
							</tr>
							<?php } ?>
						</table>
					</div>

				</div>
			</div>
		</div>
	</section>
</div>