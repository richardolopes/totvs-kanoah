<?php if(!class_exists('Rain\Tpl')){exit;}?><?php if( $error != '' ){ ?>

  <?php if( $error == 'user_where' ){ ?>
    <script>
      swal("Não digite WHERE.", "", "error");
    </script>
  <?php } ?>

  <?php if( $error == 'wheres_undefined' ){ ?>
    <script>
      swal("Preencha todos os WHERES.", "", "warning");
    </script>
  <?php } ?>

  <?php if( $error == 'page_undefined' ){ ?>
    <script>
      swal({
        title: "Página não encontrada.",
        text: "Você foi redirecionado(a) para página inicial.",
        icon: "error"
      })
      .then((value) => {
        window.location.assign("/");
      });
    </script>
  <?php } ?>

  <?php if( $error == 'permission_denied' ){ ?>
    <script>
      swal({
        title: "Permissão negada.",
        text: "Você foi redirecionado(a) para página inicial.",
        icon: "error"
      });
    </script>
  <?php } ?>

<?php } ?>