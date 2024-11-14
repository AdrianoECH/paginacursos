<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<title>Cursos</title>
		<!-- adriano chan homa -->	
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<script src="../js/jquery-1.12.4-jquery.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
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

require_once '../control/DBconect.php';

if(isset($_REQUEST['btn_register'])) //compruebe el nombre del botón 
{
	$username	= $_REQUEST['txt_username'];	//input nombre "txt_username"
	$matricula		= $_REQUEST['int_matricula'];	//input "matricula"
	$password	= $_REQUEST['txt_password'];	//input nombre "txt_password"
	$role		= $_REQUEST['int_rol'];	//seleccion nombre "txt_role"
		
	if(empty($username)){
		$errorMsg[]="Ingrese nombre de Nombre";	//Compruebe input nombre de Nombre no vacío
	}
	else if(empty($matricula)){
		$errorMsg[]="Ingrese matricula";	//Revisar matricula input no vacio
	}
	else if(!filter_var($matricula)){
		$errorMsg[]="Ingrese matricula valido";	//Verificar formato de matricula
	}
	else if(empty($password)){
		$errorMsg[]="Ingrese password";	//Revisar password vacio o nulo
	}
	else if(strlen($password) < 6){
		$errorMsg[] = "Password minimo 6 caracteres";	//Revisar password 6 caracteres
	}
	else if(empty($rol)){
		$errorMsg[]="Seleccione rol";	//Revisar etiqueta select vacio
	}
	else
	{	
		try
		{	
			$select_stmt=$db->prepare("SELECT username, matricula FROM datos_curso 
										WHERE username=:uname OR matricula=:umatricula"); // consulta sql
			$select_stmt->bindParam(":uname",$username);   
			$select_stmt->bindParam(":umatricula",$matricula);      //parámetros de enlace
			$select_stmt->execute();
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);	
			if($row["username"]==$username){
				$errorMsg[]="Nombre ya existe";	//Verificar Nombre existente
			}
			else if($row["matricula"]==$matricula){
				$errorMsg[]="Matricula ya existe";	//Verificar matricula existente
			}
			
			else if(!isset($errorMsg))
			{
				$insert_stmt=$db->prepare("INSERT INTO datos_curso(username,matricula,password,role) VALUES(:uname,:umatricula,:upassword,:urole)"); //Consulta sql de insertar			
				$insert_stmt->bindParam(":uname",$username);	
				$insert_stmt->bindParam(":umatricula",$matricula);	  		//parámetros de enlace 
				$insert_stmt->bindParam(":upassword",$password);
				$insert_stmt->bindParam(":urole",$rol);
				
				if($insert_stmt->execute())
				{
					$registerMsg="Registro exitoso: Esperar página de inicio de sesión"; //Ejecuta consultas 
					header("refresh:2;../index.php"); //Actualizar despues de 2 segundo a la portada
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
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
					<strong>INCORRECTO ! <?php echo $error; ?></strong>
				</div>
            <?php
			}
		}
		if(isset($registerMsg))
		{
		?>
			<div class="alert alert-success">
				<strong>EXITO ! <?php echo $registerMsg; ?></strong>
			</div>
        <?php
		}
		?> 
<div class="login-form">  
<center><h2>Registrar</h2></center>
<form method="post" class="form-horizontal">
    
<div class="form-group">
<label class="col-sm-9 text-left">Nombre</label>
<div class="col-sm-12">
<input type="text" name="txt_username" class="form-control" placeholder="Ingrese Nombre" />
</div>
</div>

<div class="form-group">
<label class="col-sm-9 text-left">Matricula</label>
<div class="col-sm-12">
<input type="text" name="txt_email" class="form-control" placeholder="Ingrese matricula" />
</div>
</div>
    
<div class="form-group">
<label class="col-sm-9 text-left">Password</label>
<div class="col-sm-12">
<input type="password" name="txt_password" class="form-control" placeholder="Ingrese password" />
</div>
</div>
    
<div class="form-group">
      <label class="col-sm-6 text-left">Seleccionar rol:</label></br>
	  </br>
	  <label class="col-sm-6 text-left">1-Administrador</label></br>
	  </br>
	  <label class="col-sm-6 text-left">2-usuario</label></br>
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
<input type="submit" name="btn_register" class="btn btn-primary btn-block" value="Registro">
<!--<a href="index.php" class="btn btn-danger">Cancel</a>-->
</div>
</div>

<div class="form-group">
<div class="col-sm-12">
¿Tienes una cuenta? <a href="../index.php"><p class="text-info">Inicio de sesión</p></a>		
</div>
</div>
    
</form>
</div><!--Cierra div login-->
		</div>
		
	</div>
			
	</div>
										
	</body>
</html>