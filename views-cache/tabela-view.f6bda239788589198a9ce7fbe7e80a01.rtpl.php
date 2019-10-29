<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
	<section class="content-header">
		<h1>
			Tabela <small><?php echo htmlspecialchars( $tabela, ENT_COMPAT, 'UTF-8', FALSE ); ?></small>
		</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Informação da tabela</h3>
						<!-- <div class="pull-right">
							<a href="/modulo/{}/add/rotina"><i class="fa fa-edit"></i>
								<span>&nbsp;Editar</span></a>
						</div> -->
					</div>
					<div class="box-body">
						<div class="box-body table-responsive no-padding">
							<table class="table table-hover">
								<tr>
									<th>Tabela</th>
									<th>Nome</th>
									<th onclick="copiar('query')" style="cursor: pointer">Query</th>
									<th>Ações</th>
								</tr>
								<tr>
									<td><?php echo htmlspecialchars( $tabela, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
									<td style="width: 150px"><?php echo htmlspecialchars( $nome, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
									<td><textarea id="query" cols="100vh" rows="10vw"><?php echo htmlspecialchars( $query, ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea></td>
									<td style="width: 150px">
										<!-- <a class="btn label-primary"><i class="fa fa-edit"></i><span> Editar</span></a>
										&nbsp; -->
									</td>
								</tr>
							</table>
						</div>

					</div>
				</div>
			</div>

			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Relacionamento</h3>
						<div class="pull-right">
							<a href="#"><i class="fa fa-plus"></i>
								<span>&nbsp;Adicionar Relacionamento</span></a>
						</div>
					</div>
					<div class="box-body">
						<div class="box-body table-responsive no-padding">
							<table class="table table-hover">
								<tr>
									<th>Tabela</th>
									<th>Campo</th>
									<th>Relacionamento</th>
									<th>Ações</th>
								</tr>
								<?php $counter1=-1;  if( isset($relacao) && ( is_array($relacao) || $relacao instanceof Traversable ) && sizeof($relacao) ) foreach( $relacao as $key1 => $value1 ){ $counter1++; ?>
								<tr>
									<td><?php echo htmlspecialchars( $value1["tabela"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
									<td><?php echo htmlspecialchars( $value1["campo"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
									<td><?php echo htmlspecialchars( $value1["camporel"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
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