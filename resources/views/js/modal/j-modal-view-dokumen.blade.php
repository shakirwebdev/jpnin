<script type="text/javascript">
    
    function view_dokumen(jenis,fname) 
	{    
		if(jenis != "P")
		{
			$('#dok_jenis').val("");
			if(jenis == 1)
				$('#dok_jenis').val("Baucer");
			if(jenis == 2)
				$('#dok_jenis').val("Cek");
			if(jenis == 3)
				$('#dok_jenis').val("Resit");
			$('#dok_gambar').attr('src', "{{ asset('storage/dokumen_kewangan') }}"+"/"+ fname);
			$('#modal_view_dokumen').modal('show');
		}else
		{
			alert(fname);	
		}
	}
	
	function get_list_dokumen() {
	  	var table, rows, i, w, x, y, z ;
	  	table = document.getElementById("list_dokumen");
		var xx = document.getElementById("select_list_dokumen");
		xx.innerHTML = '';
	  	rows = table.rows;
		for (i = 1; i < (rows.length); i++) {
			w = rows[i].getElementsByTagName("TD")[0];
			x = rows[i].getElementsByTagName("TD")[1];
			y = rows[i].getElementsByTagName("TD")[2];
			z = rows[i].getElementsByTagName("TD")[3];
			if(w.innerHTML != "")
			{
				//alert(y.innerHTML);
  				var option = document.createElement("option");
  				option.text = y.innerHTML;
				option.value = z.innerHTML;
  				xx.add(option);
			}
		}
		$('#dok_jenis').val(y.innerHTML);
		$('#dok_gambar').attr('src', "{{ asset('storage/dokumen_kewangan') }}"+"/"+ z.innerHTML);
		$('#lab_senaraidok').show();
		$('#select_list_dokumen').show();
		$('#dok_gambar').show();
	}
	
	function view(var_file)
	{
		$('#dok_gambar').attr('src', "{{ asset('storage/dokumen_kewangan') }}"+"/"+ var_file);
	}
</script>