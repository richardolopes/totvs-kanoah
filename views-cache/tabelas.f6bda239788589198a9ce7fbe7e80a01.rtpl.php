<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
	<section class="content-header">
		<h1>
			Tabelas
		</h1>
		<br>
		<div class="box-tools">
			<a href="/tabela/add"><i class="fa fa-codepen"></i> <span>Adicionar Tabela</span></a>
		</div>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<?php $counter1=-1;  if( isset($tabelas) && ( is_array($tabelas) || $tabelas instanceof Traversable ) && sizeof($tabelas) ) foreach( $tabelas as $key1 => $value1 ){ $counter1++; ?>
				<?php $counter2=-1;  if( isset($value1) && ( is_array($value1) || $value1 instanceof Traversable ) && sizeof($value1) ) foreach( $value1 as $key2 => $value2 ){ $counter2++; ?>
				<div class="col-md-3">
					<div class="box box-widget widget-user-2">
						<div class="widget-user-header label-primary">
							<div class="widget-user-image">
								<a href="/tabela/<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
									<h3 style="color: white"><?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?> <i class="fa fa-arrow-circle-right"></i></h3>
								</a>
							</div>

						</div>
						<div class="box-footer no-padding">
							<ul class="nav nav-stacked">
								<li><a href="/tabela/<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?>">Rotinas <span class="pull-right badge bg-blue">31</span></a></li>

								<li><a href="/tabela/<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?>">Parâmetros <span class="pull-right badge bg-blue">5</span></a></li>
							</ul>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php } ?>
			</div>
		</div>
	</section>
</div>