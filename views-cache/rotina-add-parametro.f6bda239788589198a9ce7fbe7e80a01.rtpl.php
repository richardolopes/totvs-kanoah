<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
	<section class="content-header">
		<h1>
			<small> Rotina </small> {}
		</h1>
	</section>

	<section class="content">
		<div class="row">
			<form action="/rotina/{}/add/tabela" method="POST">
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
											{}
											<div class="checkbox">
												<label>
													<input type="checkbox" name="tabsPre{}" value="{}" checked
														disabled>{}
												</label>
											</div>
											{}
										</td>
										<td>
											{}
											<div class="checkbox">
												<label>
													<input type="checkbox" name="tabsNPre{}" value="{}">{}
												</label>
											</div>
											{}
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