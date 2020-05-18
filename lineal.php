<div id="graficaLineal"></div>

				<script type="text/javascript">
					var datos_fecha=crearCadenaLineal('<?php echo $datos_fecha; ?>');
					var datos_fecha=crearCadenaLineal('<?php echo $datos_fecha; ?>');

					var trace1={
						x:datos_fecha,
						y:datos_cantidad,
						type: 'scatter'
					};

					var data = [trace1];

					Plotly.newPlot('graficaLineal', data);
				</script>