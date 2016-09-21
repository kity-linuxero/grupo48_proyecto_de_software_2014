	function plotear(){	
/*
 *	This software is MIT Licensed (see LICENSE)
 *	Copyright (c) 2014-2016 Cristian O. Giambruni, Ezequiel F. Gómez
 */
		$(document).ready(function() {
			
			var f1=document.getElementById("from").value;
			var f2=document.getElementById("to").value;
			
			if ( f1.length != 0 && f2.length != 0) {
				var subtitulo="Entre las fechas ";
				subtitulo+=f1;
				subtitulo+=" y ";
				subtitulo+=f2;
				
				var options = {
					chart: {
						renderTo: 'container',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false,
					},
					title: {
						text: 'Informes por entidades'
					},
					subtitle: {
						text: subtitulo
					},
					exporting: {
						enabled: true
					},
					
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
						}
					},
					
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								format: '<b>{point.name}</b>: {point.percentage:.1f} %',
								
								
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
								}
							}
						}
					},
					series: [{
						type: 'pie',
						name: 'Browser share',
						data: []
					}],
					credits: {
						enabled: false
					},
					 navigation: {
						buttonOptions: {
							enabled: true
					}
					
				}
				}

					//prepara la url para mandar

					var url= "../app/informe.php?informe=torta&f1=";
					//url+="backend.php?accion=informePorERJSON&f1=";
					url+=f1;
					url+="&f2="
					url+=f2;
					$.getJSON(url, function(json) {
					options.series[0].data = json;
					chart = new Highcharts.Chart(options);
				});
      	}}) }
