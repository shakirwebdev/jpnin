@section('page-script')
<style type="text/css">
	.series-frame {
	  /*max-width: 600px;*/
	  display: flex;
	  justify-content: space-between;
	  align-items: center;
	  box-sizing: border-box;
	  border: 2px solid #113f50;
	  /*margin: 30px;*/
	  padding: 10px;
	}
	.blink {
        animation: blinker 1.0s linear infinite;
        color: #1c87c9;
        font-weight: bold;
        font-family: sans-serif;
    }
    @keyframes blinker {
        50% {
          opacity: 0;
        }
      }

</style>
<script type="text/javascript">    
    //my custom script
    var krt_config = {
        routes: {
            krt_action_url: "/rt/sm1/permohonan-penubuhan-krt",
            krt_store_url: "{{ route('daerah.store') }}"
        }
    };

    $(document).ready( function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#select_negeri_krt").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_daerah_krt').find('option').remove();

            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: krt_config.routes.krt_action_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#select_daerah_krt').append($('<option>').text('- Pilih daerah').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_daerah_krt')
                            .append($('<option>')
                            .text(obj.daerah_description)
                            .attr('value', obj.daerah_id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        } );

        $('#krt_alamat_pemohon').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        $('#krt_catatan').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        @if ($applicant)
            $('#select_negeri_krt').val("{{$applicant->state_id}}").change();
            setTimeout(function(){                 
                $('#select_daerah_krt').val("{{$applicant->daerah_id}}");
            }, 1000);
        @else
            @if($errors->any())
                $('#select_negeri_krt').val("{{old('select_negeri_krt')}}").change();
                setTimeout(function(){                 
                    $('#select_daerah_krt').val("{{old('select_daerah_krt')}}");
                }, 1000);
                
            @endif
        @endif

        /* Maklumat Note Kemaskinis */
        @if ($applicant && $applicant->status==3)
			$('#krt_status_description').html("{{$applicant->status_description}}");
            $('#krt_disemak_note').html("{{$applicant->disemak_note}}");
        @endif
    });
</script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop