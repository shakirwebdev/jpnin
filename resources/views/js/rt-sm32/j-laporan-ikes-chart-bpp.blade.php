@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<style>
	.highcharts-figure,
	.highcharts-data-table table {
	min-width: 1320px;
	max-width: 2660px;
	margin: 1em auto;
	}

	.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #ebebeb;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
	}

	.highcharts-data-table caption {
	padding: 1em 0;
	font-size: 1.2em;
	color: #555;
	}

	.highcharts-data-table th {
	font-weight: 600;
	padding: 0.5em;
	}

	.highcharts-data-table td,
	.highcharts-data-table th,
	.highcharts-data-table caption {
	padding: 0.5em;
	}

	.highcharts-data-table thead tr,
	.highcharts-data-table tr:nth-child(even) {
	background: #f8f8f8;
	}

	.highcharts-data-table tr:hover {
	background: #f1f7ff;
	}
</style>

<script type="text/javascript"> 

	$(document).ready( function () {
		var currentYear = (new Date).getFullYear();
		$("#btn_search").on( 'click', function () {
			// var years = $(lksrs_year).find('option:selected').val();
			var months = $(lksrs_month).find('option:selected').val();
			
			var newurl = "{{ route('rt-sm32.laporan_ikes_chart_bpp_filter','') }}"+"/"+months
			var response = '';
			
			if (months == 1){
				month = "Januari";
			}else if (months == 2) {
				month = "Febuari";
			}else if (months == 3) {
				month = "Mac";
			}else if (months == 4) {
				month = "April";
			}else if (months == 5) {
				month = "Mei";
			}else if (months == 6) {
				month = "Jun";
			}else if (months == 7) {
				month = "Julai";
			}else if (months == 8) {
				month = "Ogos";
			}else if (months == 9) {
				month = "September";
			}else if (months == 10) {
				month = "Oktober";
			}else if (months == 11) {
				month = "November";
			}else {
				month = "Disember";
			}
			
			$.ajax({
				url:newurl,
				type: "GET",
				dataType: "json",
				success:function(data){
					 response = data;
					 console.log(response.data);
					 Highcharts.setOptions({
						colors: Highcharts.map(['#7367f0','#28c76f','#ea5455','#ff9f43','#0083d9'], function (color) {
							return {
							radialGradient: {
								cx: 0.5,
								cy: 0.3,
								r: 0.7
							},
							stops: [
								[0, color],
								[1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
							]
							};
						})
					});
					 Highcharts.chart('container', {
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false,
							type: 'pie'
						},
						title: {
							text: 'Laporan Taburan Isu mengikut Kluser '+ month +" , " + currentYear,
							align: 'left'
						},
						tooltip: {
							pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
						},
						accessibility: {
							point: {
							valueSuffix: '%'
							}
						},
						plotOptions: {
							pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: false
							},
							showInLegend: true
							}
						},
						series: [{
							name: 'Jumlah',
							colorByPoint: true,
							data: response.data
						}]
					});
				}
				
			});
			
		});
		
	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop