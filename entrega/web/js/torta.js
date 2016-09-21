	function plotear(){	
	/*
	 *	MIT License
	 *
	 *	Copyright (c) 2014-2016 Cristian O. Giambruni, Ezequiel F. Gómez
	 *
	 *	Permission is hereby granted, free of charge, to any person obtaining a copy
	 *	of this software and associated documentation files (the "Software"), to deal
	 *	in the Software without restriction, including without limitation the rights
	 *	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	 *	copies of the Software, and to permit persons to whom the Software is
	 *	furnished to do so, subject to the following conditions:
	 *
	 *	The above copyright notice and this permission notice shall be included in all
	 *	copies or substantial portions of the Software.
	 *
	 *	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	 *	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	 *	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	 *	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	 *	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	 *	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
	 *	SOFTWARE.
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
