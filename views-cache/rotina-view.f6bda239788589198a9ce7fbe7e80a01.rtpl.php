<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
	<section class="content-header">
		<h1>
			Rotina <small><?php echo htmlspecialchars( $rotina, ENT_COMPAT, 'UTF-8', FALSE ); ?></small>
		</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Informação da rotina</h3>
						<!-- <div class="pull-right">
								<a href="/modulo/{}/add/rotina"><i class="fa fa-edit"></i>
									<span>&nbsp;Editar</span></a>
							</div> -->
					</div>
					<div class="box-body">
						<div class="box-body table-responsive no-padding">
							<table class="table table-hover">
								<tr>
									<th>Rotina</th>
									<th>Nome</th>
									<th>Ações</th>
								</tr>
								<tr>
									<td><?php echo htmlspecialchars( $rotina, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
									<td><?php echo htmlspecialchars( $nome, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
									<td style="width: 150px">
										<a class="btn label-primary"><i class="fa fa-edit"></i><span> Editar</span></a>
										&nbsp;
									</td>
								</tr>
							</table>
						</div>

					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Tabelas de<br> Précondição</h3>
						<div class="pull-right">
							<a href="/rotina/<?php echo htmlspecialchars( $rotina, ENT_COMPAT, 'UTF-8', FALSE ); ?>/add/tabela"><i class="fa fa-plus"></i>
								<span>&nbsp;Adicionar Tabela</span></a>
						</div>
					</div>
					<div class="box-body">
						<div class="box-body table-responsive no-padding">
							<table class="table table-hover">
								<tr>
									<th>Tabelas</th>
									<th style="width: 150px">Ações</th>
								</tr>
								<?php $counter1=-1;  if( isset($precondicao) && ( is_array($precondicao) || $precondicao instanceof Traversable ) && sizeof($precondicao) ) foreach( $precondicao as $key1 => $value1 ){ $counter1++; ?>
								<?php $counter2=-1;  if( isset($value1) && ( is_array($value1) || $value1 instanceof Traversable ) && sizeof($value1) ) foreach( $value1 as $key2 => $value2 ){ $counter2++; ?>
								<tr>
									<td><a href="/tabela/<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></td>
									<td>
										<button class="btn btn-danger"
											onclick="deletar('/rotina/<?php echo htmlspecialchars( $rotina, ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete/tabela/pre/<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>')"><i
												class="fa fa-close"></i><span>
												Excluir</span></button>
										&nbsp;
									</td>
								</tr>
								<?php } ?>
								<?php } ?>
							</table>
						</div>

					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Tabelas de<br> Resultado Esperado</h3>
						<div class="pull-right">
							<a href="/rotina/<?php echo htmlspecialchars( $rotina, ENT_COMPAT, 'UTF-8', FALSE ); ?>/add/tabela"><i class="fa fa-plus"></i>
								<span>&nbsp;Adicionar Tabela</span></a>
						</div>
					</div>
					<div class="box-body">
						<div class="box-body table-responsive no-padding">
							<table class="table table-hover">
								<tr>
									<th>Tabelas</th>
									<th style="width: 150px">Ações</th>
								</tr>
								<?php $counter1=-1;  if( isset($resultado) && ( is_array($resultado) || $resultado instanceof Traversable ) && sizeof($resultado) ) foreach( $resultado as $key1 => $value1 ){ $counter1++; ?>
								<?php $counter2=-1;  if( isset($value1) && ( is_array($value1) || $value1 instanceof Traversable ) && sizeof($value1) ) foreach( $value1 as $key2 => $value2 ){ $counter2++; ?>
								<tr>
									<td><a href="/tabela/<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></td>
									<td>
										<button class="btn btn-danger"
											onclick="deletar('/rotina/<?php echo htmlspecialchars( $rotina, ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete/tabela/res/<?php echo htmlspecialchars( $key2, ENT_COMPAT, 'UTF-8', FALSE ); ?>')"><i
												class="fa fa-close"></i><span>
												Excluir</span></button>
										&nbsp;
									</td>
								</tr>
								<?php } ?>
								<?php } ?>
							</table>
						</div>

					</div>
				</div>
			</div>


			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Parâmetros<br> &nbsp;</h3>
						<div class="pull-right">
							<a href="/rotina/<?php echo htmlspecialchars( $rotina, ENT_COMPAT, 'UTF-8', FALSE ); ?>/add/parametro"><i class="fa fa-plus"></i>
								<span>&nbsp;Adicionar Parâmetro</span></a>
						</div>
						<br>
					</div>
					<div class="box-body">
						<div class="box-body table-responsive no-padding">
							<table class="table table-hover">
								<tr>
									<th>Parâmetros</th>
									<th style="width: 150px">Ações</th>
								</tr>
								<?php $counter1=-1;  if( isset($parametros) && ( is_array($parametros) || $parametros instanceof Traversable ) && sizeof($parametros) ) foreach( $parametros as $key1 => $value1 ){ $counter1++; ?>
								<tr>
									<td><a href="/parametro/<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?></a></td>
									<td>
										<button class="btn btn-danger" onclick=""><i class="fa fa-close"></i><span>
												Excluir</span></button>
										&nbsp;
									</td>
								</tr>
								<?php } ?>
							</table>
						</div>

					</div>
				</div>
			</div>


		</div>
	</section>
</div>