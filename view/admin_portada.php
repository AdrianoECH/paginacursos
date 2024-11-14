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

	
	<div class="wrapper">
	
	<div class="container">
			
		<div class="col-lg-12">
		 
			<center>
				<h1>Administrador</h1>
				
				<h3>
				<?php
				session_start();

				if(!isset($_SESSION['admin_login']))	
				{
					header("location: ../index.php");  
				}

				
				if(isset($_SESSION['usuarios_login']))	
				{
					header("location: view/usuarios/usuarios_portada.php");
				}
				
				if(isset($_SESSION['admin_login']))
				{
				?>
					Bienvenido,
				<?php
						echo $_SESSION['admin_login'];
				}
				?>
				</h3>
					
			</center>
			<a href="../modelo/cerrar_sesion.php"><button class="btn btn-danger text-left"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cerrar Sesion</button></a>
            <hr>
		</div>
		
		<br><br><br>
		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Panel Cursos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <div class="panel-heading">
                            Cursos
                        </div><div>Nuevo Curso</div><td width="4%"><button class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></td>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="4%">Nombre del curso</th>
                                            <th width="18%">Asistentes</th>
                                            <th width="24%">Fecha de creacion</th>
                                            
                                            <th width="24%">Editar Curso</th>
											<th colspan="2">Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									require_once '../control/DBconect.php';
									$select_stmt=$db->prepare("SELECT curso,asistentes,fecha FROM cursos");
									$select_stmt->execute();
									
									while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))
									{
									?>
                                        <tr>
                                            
                                            <td><?php echo $row["curso"]; ?></td>
                                            <td><?php echo $row["asistentes"]; ?><td width="7%"><button class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td></td>
                                            <td><?php echo $row["fecha"]; ?></td>
                                            
											<td width="4%"><button class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></td>
											<td width="7%"><button class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>
                                        </tr>
									<?php 
									}
									?>
                                    </tbody>
                                    <div>Crear Nuevo Curso</div>
                                    <div class="login-form">
<center><h2>Crear nuevo curso</h2></center>
<form method="post" class="form-horizontal">
  <div class="form-group">
  <label class="col-sm-6 text-left">Nombre del curso</label>
  <div class="col-sm-12">
  <input type="text" name="txt_name" class="form-control" placeholder="Ingrese el nombre del curso" />
  </div>
  </div>
  
  <div class="form-group">
  <label class="col-sm-6 text-left">Fecha</label>
  <div class="col-sm-12">
  <input type="date" name="txt_date" class="form-control" placeholder="Ingrese la fecha del curso" />
  
  
  <input type="submit" name="btn_crear" class="btn btn-success btn-block" value="Crear">
  
                                    <?php 
                                    if(isset($_REQUEST['btn_crear']))	
                                    {
                                        $name		=$_REQUEST["txt_name"];	
                                        
                                        $date	=$_REQUEST["txt_date"];	
                                       
                                            
                                    $insert_stmt=$db->prepare("INSERT INTO cursos(curso,fecha) VALUES(:uname,:udate)"); //Consulta sql de insertar			
                                    $insert_stmt->bindParam(":uname",$name);	
                                    $insert_stmt->bindParam(":umatricula",$date);	  		//parámetros de enlace 
                                    
                                    if($insert_stmt->execute())
                                    {
                                        $registerMsg="Curso creado"; //Ejecuta consultas 
                                        header("refresh:2;admin_portada.php"); //Actualizar despues de 2 segundo a la portada
                                    }
                                    ?>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
		
	</div>
			
	</div>
										
	</body>
</html>