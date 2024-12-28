@section('page-script')
<script src="//code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
<script src="{{ asset('assets/plugins/datatable/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/bundles/nestable.bundle.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

<script src="{{ asset('assets/js/core.js') }}"></script>

<script type="text/javascript">
    //my custom script
    var peranan_config = {
        routes: {
            user_datatable_url: "{{ route('pengguna.index') }}",
            user_action_url: "/pengurusan/peranan/pengguna/",
            user_store_url: "{{ route('pengguna.store') }}",
            menu_nestable_url: "{{ route('menu.index') }}",
            menu_action_url: "/pengurusan/peranan/menu/",
            menu_store_url: "{{ route('menu.store') }}"
        }
    };

    $(document).ready( function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        @php
            $return1 = array();
            foreach( Route::getRoutes() as $key => $route){
                $action =  $route->getActionName();
                $prefix = $route->getPrefix();
                $data = $route->uri();                
                
                if($action !== 'Closure' && $prefix == '') {
                    array_push($return1, array('url' => $data));
                }
            }
            echo "var listall = '".json_encode($return1)."'";
        @endphp

        $.ajax({
            type: "GET",
            url: peranan_config.routes.menu_nestable_url,
            success: function (data) {
                route_list = JSON.parse(listall);
                var list_dah_set = [];
                var list_belum_set = [];
                for (var rl in route_list) {
                    var value_rl = route_list[rl].url;
                    var value_rl_nama;

                    ok = false;
                    for (var key in data) {
                        var value_db = data[key].url;
                        var value_db_nama = data[key].nama;
                        if (value_db == value_rl) {                            
                            ok = true;
                            value_rl_nama = value_db_nama;
                        } 
                    }

                    if (ok == true) {
                        list_dah_set.push(value_rl_nama);
                    } else if (ok == false) {
                        list_belum_set.push(value_rl);
                    }
                }

                if (list_dah_set.length > 0) {
                    for (var key in list_dah_set) {
                        var list_value = list_dah_set[key];
                        $("#list_done_route").append('<li class="dd-item dd3-item" data-id="13">' +
                                                    '   <div class="dd-handle dd3-handle">Drag</div>' +
                                                    '   <div class="dd3-content">'+list_value+'</div>' +
                                                    '</li>');
                    }                    
                }

                if (list_belum_set.length > 0) {
                    for (var key in list_belum_set) {
                        var list_value = list_belum_set[key];
                        $("#list_all_available_route").append('<li class="dd-item dd3-item" data-id="13">' +
                                                    '   <div class="dd-handle dd3-handle">Drag</div>' +
                                                    '   <div class="dd3-content">' + list_value + '<div style="float:right">' +
                                                    '       <a href="javascript:void(0);" title="" data-toggle="modal" data-target="#ModalMenuEdit" data-url="' + list_value + '"><i class="fe fe-edit"></i></a></div>' +
                                                    '   </div>' +
                                                    '</li>');
                    }
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

        $('#nestable3').nestable({
            group: 1,
            maxDepth: 1
        });
        $('#nestable4').nestable({
            group: 1,
            maxDepth: 2,
            contentCallback: function(item) {
                var content = item.content || '' ? item.content : item.id;
                content += ' <i>(id = ' + item.id + ')</i>';

                return content;
            }
        }).on('change', updateOutput);

        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if(window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            }
            else {
                output.val('JSON browser support required for this demo.');
            }
        };

        updateOutput($('#nestable4').data('output', $('#nestable-output')));
    });
</script>
<script src="{{ asset('js/ref_roles_user.js') }}"></script>
<script src="{{ asset('js/ref_roles_menu.js') }}"></script>
@stop