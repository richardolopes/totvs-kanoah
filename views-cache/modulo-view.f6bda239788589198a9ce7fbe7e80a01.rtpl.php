<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="content-wrapper">
  <section class="content-header">
    <h1>
      Módulo <small><?php echo htmlspecialchars( $modulo, ENT_COMPAT, 'UTF-8', FALSE ); ?></small>
    </h1>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Rotinas</h3>
          </div>
          <div class="box-body">

            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>#</th>
                  <th>Rotina</th>
                  <th>Ações</th>
                </tr>

                <?php $counter1=-1;  if( isset($rotinas) && ( is_array($rotinas) || $rotinas instanceof Traversable ) && sizeof($rotinas) ) foreach( $rotinas as $key1 => $value1 ){ $counter1++; ?>
                <tr>
                  <td><?php echo htmlspecialchars( $key1+1, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td><?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td>
                    <button class="btn btn-danger" onclick="deletar('/modulos/<?php echo htmlspecialchars( $modulo, ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete/rotina/<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>')"><i class="fa fa-close"></i><span> Excluir</span></button>
                    &nbsp;
                    <button class="btn btn-info" >
                        <!-- onclick="(/rotinas/<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>)" -->
                      <i class="fa fa-search"></i><span> Visualizar rotina</span>
                    </button>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Parâmetros</h3>
          </div>
          <div class="box-body">

            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>#</th>
                  <th>Parâmetros</th>
                  <th>Ações</th>
                </tr>

                <?php $counter1=-1;  if( isset($parametros) && ( is_array($parametros) || $parametros instanceof Traversable ) && sizeof($parametros) ) foreach( $parametros as $key1 => $value1 ){ $counter1++; ?>
                <tr>
                  <td><?php echo htmlspecialchars( $key1+1, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td><?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td>
                    <button class="btn btn-danger" onclick="deletar('/modulos/<?php echo htmlspecialchars( $modulo, ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete/parametro/<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>')"><i class="fa fa-close"></i><span> Excluir</span></button>
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