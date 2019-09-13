<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
	<section class="content-header">
		<h1>
			<small> Rotina </small> <?php echo htmlspecialchars( $rotina, ENT_COMPAT, 'UTF-8', FALSE ); ?>
			<!-- <small> Tipo </small> <?php if( $tipo == 0 ){ ?>Pré-condição<?php } ?><?php if( $tipo == 1 ){ ?>Resultado esperado<?php } ?> -->
		</h1>
	</section>

	<section class="content">
		<div class="row">
			<form action="/rotina/<?php echo htmlspecialchars( $rotina, ENT_COMPAT, 'UTF-8', FALSE ); ?>/add/tabela" method="POST">
				<div class="col-xs-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"><small>Selecione as tabelas </small>Pré-condição:</h3>
						</div>
						<div class="box-body">
							<div class="box-body table-responsive no-padding">
								<table class="table table-hover">
									<tr>
										<th>Tabelas já adicionadas</th>
										<th>Tabelas ainda não adicionadas</th>
									</tr>
									<tr>
										<td>
											<?php $counter1=-1;  if( isset($tabsPre) && ( is_array($tabsPre) || $tabsPre instanceof Traversable ) && sizeof($tabsPre) ) foreach( $tabsPre as $key1 => $value1 ){ $counter1++; ?>
											<div class="checkbox">
												<label>
													<input type="checkbox" name="tabsPre<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>" value="<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>"
														checked disabled><?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>
												</label>
											</div>
											<?php } ?>
										</td>
										<td>
											<?php $counter1=-1;  if( isset($tabsNPre) && ( is_array($tabsNPre) || $tabsNPre instanceof Traversable ) && sizeof($tabsNPre) ) foreach( $tabsNPre as $key1 => $value1 ){ $counter1++; ?>
											<div class="checkbox">
												<label>
													<input type="checkbox" name="tabsNPre<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>"
														value="<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>
												</label>
											</div>
											<?php } ?>
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
							<h3 class="box-title"><small>Selecione as tabelas </small>Resultado Esperado:</h3>
						</div>
						<div class="box-body">
							<div class="box-body table-responsive no-padding">
								<table class="table table-hover">
									<tr>
										<th>Tabelas já adicionadas</th>
										<th>Tabelas ainda não adicionadas</th>
									</tr>
									<tr>
										<td>
											<?php $counter1=-1;  if( isset($tabsRes) && ( is_array($tabsRes) || $tabsRes instanceof Traversable ) && sizeof($tabsRes) ) foreach( $tabsRes as $key1 => $value1 ){ $counter1++; ?>
											<div class="checkbox">
												<label>
													<input type="checkbox" name="tabsRes<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>" value="<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>"
														checked disabled><?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>
												</label>
											</div>
											<?php } ?>
										</td>
										<td>
											<?php $counter1=-1;  if( isset($tabsNRes) && ( is_array($tabsNRes) || $tabsNRes instanceof Traversable ) && sizeof($tabsNRes) ) foreach( $tabsNRes as $key1 => $value1 ){ $counter1++; ?>
											<div class="checkbox">
												<label>
													<input type="checkbox" name="tabsNRes<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>"
														value="<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>
												</label>
											</div>
											<?php } ?>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="box-body">
					<button type="submit" class="btn btn-success">Enviar</button>
				</div>
			</form>
		</div>
	</section>
</div>