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
				<h1>Pagina usuario</h1>
				
				<h3>
				<?php
				
				session_start();

				if(!isset($_SESSION['usuarios_login']))	
				{
					header("location: ../index.php");
				}

				if(isset($_SESSION['admin_login']))	
				{
					header("location: view/admin_portada.php");
				}
				if(isset($_SESSION['user_login']))
				{
				?>
					Bienvenidos,
				<?php
						echo $_SESSION['usuarios_login'];
				}
				?>
				</h3>
				<tbody>
									<?php
									require_once '../control/DBconect.php';
									$select_stmt=$db->prepare("SELECT curso,fecha FROM cursos");
									$select_stmt->execute();
									
									while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))
									{
									?>
                                        <tr>
                                            
                                            <td><?php echo $row["curso"]; ?></td>
                                            <div>Inscribirse</div><td width="4%"><button class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></td>
                                            <td><?php echo $row["fecha"]; ?></td>
                                            
											
											<div>Salir del curso</div><td width="7%"><button class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>
                                        </tr>
									<?php 
									}
									?>
									
                                    </tbody>
			</center>
			
            <hr>
		</div>
		
	</div>
			
	</div>
	<a href="../modelo/cerrar_sesion.php"><button class="btn btn-danger text-left"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cerrar Sesion</button></a>								
	</body>
</html>