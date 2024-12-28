@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
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

</style>
<script type="text/javascript">    
    //my custom script
    var krt_config = {
        routes: {
            krt_action_url: "/rt/sm6/borang-laporan-aktiviti-perpaduan"
        }
    };

    $(document).ready( function () {
        
    	$('#summernote_1').summernote({
          height: 200
      });

      $('#summernote_1').summernote('disable');

      $('#summernote_2').summernote({
          height: 200
      });

      $('#summernote_2').summernote('disable');

      $('#summernote_3').summernote({
          height: 200
      });

      $('#summernote_3').summernote('disable');

      $('#summernote_4').summernote({
          height: 200
      });

      $('#summernote_4').summernote('disable');
        
    });

   

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop