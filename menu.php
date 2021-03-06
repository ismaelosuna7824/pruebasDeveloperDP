<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
      </button>
     

    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <a href="https://facturas.grupodp.com.mx/dp33/"> <img src="img/Logo dp Azul REFLEX.png" align="left" width="84" style="margin-top: 2px;"> </a>
      <ul class="nav navbar-nav navbar-right">
                <?php if (isset($_SESSION["RFC"])){?>
                <li><a href="cliente_facturas.php"><h4><i class="fa fa-folder-open" aria-hidden="true"></i>
 Mis Facturas</h4></a></li>

                <li ><a href="factura.php"><h4><img src="img/factura.png" alt="Facturar"><i aria-hidden="true"></i>
 Facturar</h4></a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                      <h4><i class="fa fa-user-circle" aria-hidden="true"></i>
                      <?php echo $_SESSION["NOMBRE"]; ?><span class="caret"></span></h4>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="ContrasenaCambiar.php" > <i class="fa fa-key" aria-hidden="true"></i>
 Cambio de contraseña</a></li>
                        <li class="divider"></li>
                        <li><a href="./WS/Login/cerrarconexion.php" ><i class="fa fa-sign-out" aria-hidden="true"></i>
 Cerrar sesión</a></li>
                    </ul>
                </li>
                <?php } else {?>

            <form class="navbar-form navbar-left" onsubmit="login(event)" >
                                        <div class="input-group">
                    <a class="pull-right linkregistro" href="registro.php"><strong>¿No te has registrado?</strong></a>
                  </div>
                <div class="input-group">
                    <span class="input-group-addon primary"><i class="fa fa-user-o" aria-hidden="true"></i></span>                  
                    <input type="text" class="form-control" placeholder="email" name="email" id="email">
                </div>
                  <div class="input-group">
                      <span class="input-group-addon primary"><i class="fa fa-lock" aria-hidden="true"></i></span>   
                    <input type="password" class="form-control"  placeholder="Password" name="password" id="password">
                  </div>
                <button type="submit" class="btn btn-primary entrar" >Entrar</button>
                <!-- <button onclick="location.href='https://facturas.grupodp.com.mx'" type="button" class="btn btn-primary entrar">
        Salir</button> !-->
              </form>
        <?php } ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<script>

  async function  login(evt){
    const query =  ` query Login($email: String, $password: String ){
                            loginCliente(email: $email, password: $password){
                              status
                              message
                              token
                            }
                          }
                          `;
    evt.preventDefault();
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    const response = await fetch('https://dportenisback-e824u.ondigitalocean.app/graphql', {
                      method: 'POST',
                      headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                      },
                      body: JSON.stringify({
                        query,
                        variables: {
                          email: email.trim(),
                          password: password.trim()
                        },
                      }),
                    }) .then(r => r.json())
                    .then(data => {
                        //console.log(data.data)
                        if(data.data.loginCliente.status){
                            alert("bien")
                        }else{
                          const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                              toast.addEventListener('mouseenter', Swal.stopTimer)
                              toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                          })

                          Toast.fire({
                            icon: 'error',
                            title: 'El usuario o contraseña es incorrecto'
                          })
                        }
                    });
  }

</script>