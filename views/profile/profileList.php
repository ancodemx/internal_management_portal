<?php
// session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo PROJECT_NAME; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- REQUIRED SCRIPTS -->
    <?php 
    define('TOASTR', 1);
    define('DATATABLE', 1);
    define('SUMMERNOTE', 0);
    define('DATE_PICKER', 0);
    define('DATE_PICKER_CSS', 0);
    define('SELECT2', 0);
    define('LOADING', 0);
    include PROJECT_PATH . 'views/includes/script-css.php';
    ?>

    <style type="text/css">
        .dataTables_filter {
            display: none;
        }

        .dataTables_length {
            display: none;
        }

        .badge {
            font-size: 11px;
            border-radius: 9px;
            font-weight: 400;
            padding: 0.25em 0.6em;
        }

        table.dataTable td{
            /*height: 100px;*/ /* Ajusta según sea necesario */
            /*text-align: center;*/ /* Centrar horizontalmente */
            vertical-align: middle; /* Centrar verticalmente */
        }

        .floating-menu {
            font-family: sans-serif;
            background: yellowgreen;
            padding: 5px;
            width: fit-content;
            right: 15px;
            top: 23px;
            z-index: 1050;
            position: fixed;

            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 0.25rem;
        }

        .floating-menu a,
        .floating-menu h3 {
            font-size: 0.9em;
            display: block;
            /*margin: 0 0.5em;*/
            color: white;
        }
    </style>

    <script type="text/javascript">
        let URL_PATH    = '<?php echo URL_PATH; ?>';
        let CONTROLADOR = '<?php echo $_SESSION['controlador'];?>';
        let TOKEN       = '<?php echo $_SESSION['token']; ?>';
    </script>

</head>
<body class="hold-transition layout-fixed sidebar-collapse">
    <div class="wrapper">

        <?php 
        //include APP_PATH . 'views/includes/header.php';
        //include APP_PATH . 'views/includes/left_sidebar_menu.php'; 
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="height: auto;">
            <!-- Content Header (Page header) -->
            <div class="content-header pb-2">
                <div class="container-fluid">
                    
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content pb-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="form-group col-12">
                            <button type="button" class="btn btn-default btn-sm btn-flat"
                            data-toggle="modal" data-target="#modal_form_profile"
                            data-bs-toggle="modal" data-bs-target="#modal_form_profile"
                            id="btn_nuevo">Nuevo</button>
                            <button type="button" class="btn btn-default btn-sm btn-flat float-right" 
                            id="btn_actualizar">
                                <i class="fa-solid fa-arrows-rotate" style="font-size: 14px;"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="search" class="form-control rounded-0" id="searchbox" placeholder="Buscar">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 table-responsive">
                            <table id="gridProfiles" class="table table-hover" role="grid" style="font-size: 14px; width: 100%; margin-top: 0px !important;">
                                <thead>
                                    <tr>
                                        <th>Perfil</th>
                                        <th>Descripcion</th>
                                        <th>Estatus</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php 
        //include APP_PATH . 'views/includes/control_sidebar_right.php';
        //include APP_PATH . 'views/includes/footer.php';
        ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <?php 
    define('BOOTBOX', 1);
    define('FILES', 0);
    define('DATE_PICKER_JS', 0);
    define('ADMINLTE', 0);
    define('INPUTMASK', 0);
    include PROJECT_PATH . 'views/includes/script-js.php';
    ?>

    <script type="text/javascript">
        
        let tableProfiles;

        $(document).ready(function () {

            window.addEventListener('message', function(event) {

                let data = event.data;

                // Si es string, intenta parsear como JSON
                if (typeof data === "string") {
                    try {
                        data = JSON.parse(data);
                    } catch (e) {
                        // No es JSON válido, puedes ignorar o mostrar un mensaje
                        console.warn("Mensaje recibido no es JSON válido:", data);
                        return;
                    }
                }

                // Si no hay datos, salimos
                if (!data) return;

                const option = {
                    'success': (data) => {

                        // configurar toastr
                        toastr.success(data.msg);
                        tableProfiles.clear().draw();
                        tableProfiles.state.save();

                        // Acceder al iframe hijo por su nombre o ID
                        let iframeHijo = window.parent.document.getElementById('perfil');
                        iframeHijo.parentNode.remove(iframeHijo);

                        // Supongamos que iframeHijo.src contiene la URL completa
                        let url = iframeHijo.src;

                        // Extraer controlador/accion, quitando el id si existe
                        let match = url.match(/\/profile\/(edit|create)/);
                        let baseUrl = '';
                        if (match) {
                            // Obtiene la base hasta controlador/accion
                            let base = url.split(match[0])[0];
                            baseUrl = base + match[0];
                        }

                        baseUrl = Utilities.convertURLtoID(baseUrl);

                        var iframeDestino = window.parent.document.getElementById("tab-" + baseUrl);
                        iframeDestino.parentNode.remove(iframeDestino);
                        
                    }
                };

                const opcion = option[data.status] ? option[data.status](data) : '' ;
            });


            // --- INICIALIZAMOS DATATABLES
            const tableProfilesParam = {
                length: 15,
                url: URL_PATH + CONTROLADOR + "/data_table_list",
                method: 'POST', // Tipo de petición
                data: {
                    "token": TOKEN
                },
                columns: [
                    {
                        "targets": [0]
                    },
                    {
                        "targets": [1]
                    },
                    {
                        "targets": [2]
                    },
                    {
                        "width": "6%",
                        "className": "text-center",
                        "targets": [3],
                        
                    }
                ],
            };
            tableProfiles = $('#gridProfiles').DataTable(
                UI.paramsDataTable( 
                    tableProfilesParam.length, 
                    tableProfilesParam.url, 
                    tableProfilesParam.method,
                    tableProfilesParam.data, 
                    tableProfilesParam.columns
                )
            );

            let tableProfiles_filter = $('#gridProfiles').dataTable();

            let timeoutId;
            // El manejador del evento de entrada
            function handleInput(event) {
                const query = event.target.value;

                // Limpiar el temporizador anterior
                clearTimeout(timeoutId);

                // Configurar un nuevo temporizador
                timeoutId = setTimeout(() => {
                    tableProfiles_filter.fnFilter(query);
                }, 1000); // 1 segundo de retraso
            }

            // Añadir el evento de entrada al input
            document.getElementById('searchbox').addEventListener('input', handleInput);

        });

        document.getElementById('btn_nuevo').addEventListener('click', function(e) {
            UI.create_tab('Perfil', URL_PATH + 'profile/create');
        });

        document.getElementById('btn_actualizar').addEventListener('click', function(e) {
            location.href = URL_PATH + CONTROLADOR;
        });


        // --- Opciones
        const opciones = {
            'info': (id) => {
                mostrar_info(id);
            },
            'edit': (id) => {
                setTimeout(function() {
                    UI.create_tab('Perfil', URL_PATH + 'profile/edit');
                    let iframeDestino = window.parent.document.getElementById("perfil");
                    let url = URL_PATH + CONTROLADOR + '/edit/' + id;
                    iframeDestino.src = url;
                }, 1000);

            },
            'remove': (id) => {

                bootbox.confirm({
                    message: "Estás seguro de dar de baja este registro?",
                    buttons: {
                        confirm: {
                            label: 'Si'
                        },
                        cancel: {
                            label: 'No'
                        }
                    },
                    callback: function (result) {
                        if (result == true) {
                            
                            $.ajax({
                                url: URL_PATH + CONTROLADOR + '/delete',
                                data: {
                                    "id": id,
                                    "token": TOKEN
                                },
                                type: "DELETE",
                            }).done( function(data) {

                                // var json_response = JSON.parse(data);

                                const opciones = {
                                    'success': () => {
                                        if ( data.is_error == false ){
                                            toastr.success(data.message)

                                            tableProfiles.clear().draw();
                                            tableProfiles.state.save();
                                        }
                                    },
                                    'warning': () => {
                                        toastr.warning(data.message);
                                    },
                                    'error': () => {
                                        toastr.error(data.message);
                                    }
                                }
                                const opcion_default = () => {
                                    toastr.error("Se ha producido un error");
                                };
                                
                                const estatus = opciones[data.meta_data.alert_type] ? opciones[data.meta_data.alert_type]() : opcion_default();

                            }).always( function() {
                                
                            });
                        }
                    }
                });
            },
        };
        document.getElementById('gridProfiles').addEventListener('click', function(e) {
            let id = e.target.getAttribute('data-id') ? e.target.getAttribute('data-id') : '';
            const opcion = opciones[e.target.name] ? opciones[e.target.name](id) : '';
        });

    </script>

</body>
</html>
