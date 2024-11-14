<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<title>Cursos</title>
	<!-- adriano chan homa -->		
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="js/jquery-1.12.4-jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<style type="text/css">
	.login-form {
		width: 340px;
    	margin: 20px auto;
	}
    .login-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
    }
</style>
</head>
	<body>
<?php
require_once 'control/DBconect.php';
session_start();
if(isset($_SESSION["admin_login"]))	//Condicion admin
{
	header("location: view/admin_portada.php");	
}

if(isset($_SESSION["usuarios_login"]))	//Condicion Usuarios
{
	header("location: view/usuarios_portada.php");
}

if(isset($_REQUEST['btn_login']))	
{
	$matricula		=$_REQUEST["txt_matricula"];	//textbox nombre "txt_matricula"
	
	$password	=$_REQUEST["txt_password"];	//textbox nombre "txt_password"
	$rol		=$_REQUEST["txt_rol"];		//select opcion nombre "txt_role"
		
	if(empty($matricula)){						
		$errorMsg[]="Por favor ingrese la Matricula";	//Revisar matricula
	}
	else if(empty($password)){
		$errorMsg[]="Por favor ingrese Password";	//Revisar password vacio
	}
	else if(empty($rol)){
		$errorMsg[]="Por favor seleccione rol ";	//Revisar rol vacio
	}
	else if($matricula AND $password AND $rol)
	{
		try
		{
			$select_stmt=$db->prepare("SELECT matricula,password,rol FROM login
										WHERE
										matricula=:umatricula AND password=:upassword AND rol=:urol"); 
			$select_stmt->bindParam(":umatricula",$matricula);
			$select_stmt->bindParam(":upassword",$password);
			$select_stmt->bindParam(":urol",$rol);
			$select_stmt->execute();	//execute query
					
			while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))	
			{
				$dbmatricula=$row["matricula"];
				$dbpassword=$row["password"];
				$dbrol=$row["rol"];
				
			}
			if($matricula!=null AND $password!=null AND $rol!=null)	
			{
				
				if($select_stmt->rowCount()>0)
				{
					if($matricula==$dbmatricula and $password==$dbpassword and $rol==$dbrol)
					{
						switch($dbrol)		//inicio de sesión de usuario base de roles
						{
							case "1":
								$_SESSION["admin_login"]=$matricula;			
								$loginMsg="Admin: Inicio sesión con éxito";	
								header("refresh:3;view/admin_portada.php");	
								break;
								
							
								
							case "2":
								$_SESSION["usuarios_login"]=$matricula;				
								$loginMsg="Usuario: Inicio sesión con éxito";	
								header("refresh:3;view/usuarios_portada.php");		
								break;
								
							default:
								$errorMsg[]="matricula o contraseña o rol incorrectos (1)";
						}
					}
					else
					{
						$errorMsg[]="matricula o contraseña o rol incorrectos (2)";
					}
				}
				else
				{
					$errorMsg[]="matricula o contraseña o rol incorrectos (3)";
				}
			}
			else
			{
				$errorMsg[]="No esta registrado";
			}
		}
		catch(PDOException $e)
		{
			$e->getMessage();
		}		
	}
	else
	{
		$errorMsg[]="matricula o contraseña o rol incorrectos 5";
	}
}

?>

	
	<div class="wrapper">
	
	<div class="container">
			
		<div class="col-lg-12">
		
		<?php
		if(isset($errorMsg))
		{
			foreach($errorMsg as $error)
			{
			?>
				<div class="alert alert-danger">
					<strong><?php echo $error; ?></strong>
				</div>
            <?php
			}
		}
		if(isset($loginMsg))
		{
		?>
			<div class="alert alert-success">
				<strong>ÉXITO ! <?php echo $loginMsg; ?></strong>
			</div>
        <?php
		}
		?> 


<div class="login-form">
<center><h2>Iniciar sesión</h2></center>
<form method="post" class="form-horizontal">
  <div class="form-group">
  <label class="col-sm-6 text-left">Matricula</label>
  <div class="col-sm-12">
  <input type="number" name="txt_matricula" class="form-control" placeholder="Ingrese matricula" />
  </div>
  </div>
  
  <div class="form-group">
  <label class="col-sm-6 text-left">Nombre Completo</label>
  <div class="col-sm-12">
  <input type="text" name="txt_username" class="form-control" placeholder="Ingrese nombre completo" />
  </div>
  </div>

  <div class="form-group">
  <label class="col-sm-6 text-left">Password</label>
  <div class="col-sm-12">
  <input type="password" name="txt_password" class="form-control" placeholder="Ingrese passowrd" />
  </div>
  </div>
      
  <div class="form-group">
      <label class="col-sm-6 text-left">Seleccionar rol:</label></br>
	  </br>
	  <label class="col-sm-6 text-left">1-Administrador</label></br>
	  </br>
	  <label class="col-sm-6 text-left">2-Usuario</label></br>
	  </br>
      <div class="col-sm-12">
      <select class="form-control" name="txt_rol">
          <option value="" selected="selected"> - selecccionar rol - </option>
          <option value="1">1</option>
          <option value="2">2</option>
      </select>
      </div>
  </div>
  
  <div class="form-group">
  <div class="col-sm-12">
  <input type="submit" name="btn_login" class="btn btn-success btn-block" value="Iniciar Sesion">
  </div>
  </div>
  
  <div class="form-group">
  <div class="col-sm-12">
  ¿No tienes una cuenta? <a href="modelo/registro.php"><p class="text-info">Registrar Cuenta</p></a>		
  </div>
  </div>
      
</form>
</div>
<!--Cierra div login-->
		</div>
		
	</div>
			
	</div>
										
	</body>
</html>