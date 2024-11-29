<!DOCTYPE html>
<html lang="es">
	
	<?php 
		if (!isset($isPDF)) {
			# code...
			echo view('Layouts/head'); 
		}
	?>
	

	<?php if(isset($isPDF)): ?>
	<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1, h2 {
            color: #007bff;
        }


        .card {
            border: 1px solid #ddd;
            border-radius: 0px;
            padding: 0px;
            margin: 0px;
            background-color: #f8f9fa;
        }

        .card-body {
            padding: 10px;
        }

        .text-muted {
            color: #6c757d;
        }

		h1, h2, h3 {
			color: black; /* Cambia el color a negro */
		}


        .text-md-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        strong {
            font-weight: bold;
        }

        

        .mb-3 {
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        table th, table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
			
        }



        table th {
            background-color: #fff;
            color: black;
        }
        table td {
            background-color: #fff;
            color: black;
        }

		table thead {
			background-color: #f0f0f0 !important; /* Color gris claro */
			color: black; /* Texto en negro */
		}


        table .text-end {
            text-align: right;
        }

        hr {
            margin: 20px 0;
            border: 0;
            border-top: 1px solid #ccc;
        }

		

		
		

		.row {
			display: table; /* Usar tabla */
			width: 100%; /* Asegura que el contenedor ocupe todo el ancho */
		}

		.row > div {
			display: table-cell; /* Cada columna es una celda de tabla */
			width: 33%; /* Cada celda ocupa un tercio del ancho */
			padding: 10px; /* Espaciado interno */
			box-sizing: border-box; /* Incluye padding en el ancho total */
		}


        /* Estilos específicos para impresión y PDF */
        @media print {
            .row {
                flex-wrap: nowrap; /* Asegura que no se envuelvan */
                width: 100%; /* Asegura que ocupe todo el ancho de la página */
            }

            .row > div {
                flex: 1; /* Hace que cada columna ocupe igual espacio */
                min-width: auto; /* Quita el ancho mínimo para impresión */
            }
        }



		

		

    </style>


	<?php endif?>	

<body>
    <div class="wrapper">
	<?php if (!isset($isPDF) || !$isPDF): ?>	
        <?php echo view('Layouts/sidebar'); ?>
        <div class="main">
            <?php echo view('Layouts/navbar'); ?>
			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Vista de Nomina</h1>

					<div class="row">
						<div class="col-12">
	<?php endif ?>						
							<div class="card" id="contenido-factura">
								<div class="card-body m-sm-3 m-md-5">
									<h2>Comprobante De Nomina</h2>
									<div class="mb-4">
										Nomina del Empleado <strong><?= $empleado['nombre'] ?></strong>,
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="text-muted">Nomina N°.</div>
											<strong><?= $nomina['id_nomina'] ?>-NEM</strong>
										</div>
										<div class="col-md-6 text-md-end">
											<div class="text-muted">Fecha Actual</div>
											<strong>
												<?php
													date_default_timezone_set('America/Bogota');
													
													$fechaHoraActual = date('j \d\e F \d\e\l Y - H:i:s');
													echo $fechaHoraActual; 
												?>
											</strong>
										</div>
									</div>

									<hr class="my-4">

									<div class="row mb-4" id="info-container">
										<div class="col-md-6" id="cliente-info">
											<div class="text-muted">Empleado</div>
											<strong>
												<?= $empleado['nombre'] ?>
											</strong>
											<p>
											CC: <?= $empleado['identificacion'] ?><br>
											Contrato: <?= $empleado['tipo_contrato'] ?> <br>
											Departamento: <?php 
																foreach ($empleados as  $personal) {
																	
																	if ($personal['id_empleado'] == $empleado['id_empleado']) {
																		echo $personal['nombre_departamento'];
																	}
																}
														
														 	?> <br>
												COLOMBIA <br>
												<a href="">
												<?= $empleado['contacto'] ?>
												</a>
											</p>
										</div>
										<div class="col-md-6 text-md-end" id="empresa-info">
											<div class="text-muted">Empresa empleadora</div>
											<strong>
												HrmNity S.A.S
											</strong>
											<p>
												Nit: 901.126.715-7<br>
												
												
												COLOMBIA<br>
												<a href="">
													hrmnytysas@gmail.com
												</a>
											</p>
										</div>
									</div>

									<table class="table table-sm">
										<thead>
											<tr>
												<th>Descripcion</th>
												<th>Cantidad</th>
												<th class="text-end">Monto</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Salario Base</td>
												<td>1</td>
												<td class="text-end">$<?= $salario['salario_base'] ?></td>
											</tr>
											<tr>
												<td>Bonificaciones </td>
												<td>1</td>
												<td class="text-end">$<?= $salario['bonificacion'] ?></td>
											</tr>
											<tr>
												<td>Auxilio Transporte</td>
												<td>1</td>
												<td class="text-end">$<?= $salario['aux_transporte'] ?></td>
											</tr>
											
											<tr>
												<th>&nbsp;</th>
												<th>Salud </th>
												<th class="text-end">4%</th>
											</tr>
											<tr>
												<th>&nbsp;</th>
												<th>Pension </th>
												<th class="text-end">4%</th>
											</tr>
											<tr>
												<th>&nbsp;</th>
												<th>Subtotal </th>
												<th class="text-end">$<?= $salario['salario_total'] ?></th>
											</tr>
											<tr>
												<th>&nbsp;</th>
												<th>H. Extras </th>
												<th class="text-end">$<?= $nomina['horas_extras_total'] ?></th>
											</tr>
											<tr>
												<th>&nbsp;</th>
												<th>Ausencia </th>
												<th class="text-end">$<?= $nomina['deduccion_ausencia'] ?></th>
											</tr>
											<tr>
												<th>&nbsp;</th>
												<th>Total </th>
												<th class="text-end">$<?= $nomina['nomina_total'] ?></th>
											</tr>
										</tbody>
									</table>

									<div class="text-center">
										<p class="text-sm">
											<strong>Extra note:</strong>
											Certificado de recibo de nomina de parte de HRMnity S.A.S (901.126.715-7) al empleado. Con entera satisfacción del saldo indicado en el
											presente Comprobante en donde no existe cargo ni cobro posterior que hacer.
										</p>
										
									</div>
									<?php if (!isset($isPDF) || !$isPDF): ?>
									<div class="row text-center">
										
										<form action="<?= base_url('public/nomina/update') ?>" method="post" class="ajax-form" >
											<input type="hidden" name="pagar" value="pagar">
											<input type="hidden" name="_method" value="PUT">
											<input type="hidden" name="id" value="<?php if(isset($nomina['id_nomina'])){ echo $nomina['id_nomina']; } ?>">
	
											<button class="btn btn-primary" type="submit">Pagar</button>
											<a href="<?= base_url('public/nomina/generar-pdf/' . $nomina['id_nomina']) ?>" class="btn btn-outline-secondary" target="_blank">Descargar<i class="align-middle" data-feather="download"></i></a>
										</form>
									</div>								
									<?php endif ?>	
								</div>
							</div>
							
	<?php if (!isset($isPDF) || !$isPDF): ?>						
						</div>
					</div>

				</div>
			</main>
			<?php echo view('Layouts/footer'); ?>
        </div>
    </div>
    </div>
    <?php echo view('Layouts/script-js'); ?>
	<?php endif?>

</body>

</html>