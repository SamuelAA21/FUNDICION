<?php

date_default_timezone_set("America/Bogota");
function redirect($url)
{
	echo "<script type='text/javascript'>"
		.	   "window.location.href='$url'"
		. "</script>";
}

function dd($var)
{
	echo '<pre>';
	die(print_r($var));
}

function getUrl($modulo,$controlador,$funcion,$parametros=false,$ajax=false){
   
    if($ajax){
        $pagina="ajax";
    }
    else{
        $pagina="index";
    }
   
    $url="$pagina.php?module=$modulo&controller=$controlador&function=$funcion";
   
    if($parametros){
        foreach($parametros as $indice=>$valor){
            $url.="&$indice=$valor";
        }
    }
   
    return $url;
}
 

function resolve($module = FALSE, $controller = FALSE, $function = FALSE)
{	
	if ($module == FALSE) {
		$module = ($_GET['module']);
		$controller = ($_GET['controller']);
		$function = $_GET['function'];
	}

	
	if (is_dir('../Controller/' . $module)) {
		if (file_exists('../Controller/' . $module . '/Ctrl' . $controller . '.php')) {
			include_once '../Controller/' . $module . '/Ctrl' . $controller . '.php';
			$nombreClase = 'Ctrl' . $controller;
			$objClase = new $nombreClase();
			if (method_exists($objClase, $function)) {
				$objClase->$function();
			} else {
				echo"No existe function";
				//redirect(getUrl('Page', 'Page', 'getError404'));
			}
		} else {
			echo"No existe controller";
			//redirect(getUrl('Page', 'Page', 'getError404'));
		}
	} else {
		echo"No existe carpeta";
		//redirect(getUrl('Page', 'Page', 'getError404'));
	}	
}

function fechaActual()
{
	date_default_timezone_set("America/Bogota");
	$fechaActual = getdate();
	($fechaActual['seconds'] < 10) ? $fechaActual['seconds'] = '0' . $fechaActual['seconds'] : '';
	($fechaActual['minutes'] < 10) ? $fechaActual['minutes'] = '0' . $fechaActual['minutes'] : '';
	$fechaActual = $fechaActual['mday'] . " " . monthToString($fechaActual['mon'] - 1) . " " .
		$fechaActual['year'] . " a las " . $fechaActual['hours'] . ":" .
		$fechaActual['minutes'] . ":"  . $fechaActual['seconds'];
	return $fechaActual;
}

function fechaCastellano($fecha)
{
	$fecha = substr($fecha, 0, 10);
	$numeroDia = date('d', strtotime($fecha));
	$dia = date('d', strtotime($fecha));
	$mes = date('F', strtotime($fecha));
	$anio = date('Y', strtotime($fecha));


	$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	$meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	$nombreMes = str_replace($meses_EN, $meses_ES, $mes);
	return $dia . " " . $nombreMes . " " . $anio;
}


function messageSweetAlert($title, $text, $type, $colorBtn, $url = null)
{	
		echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
			<script>
				swal({
					title: '".$title."',
					text: '".$text."',
					icon: '".$type."',
					button: 'Aceptar'
				}).then(() => {
  					window.location.href = '".$url."'; 
				});
			</script>";	
}