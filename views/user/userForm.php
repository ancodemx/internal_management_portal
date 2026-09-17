<?php

use app\Helpers\HtmlBuilder;

// echo "<pre>";
// print_r($datos);
// echo "</pre>";
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
    define('DATATABLE', 0);
    define('SUMMERNOTE', 0);
    define('DATE_PICKER', 0);
    define('DATE_PICKER_CSS', 0);
    define('SELECT2', 1);
    define('LOADING', 0);
    include PROJECT_PATH . 'views/includes/script-css.php';
    ?>

    <script type="text/javascript">
        var URL_PATH = '<?php echo URL_PATH; ?>';
        var CONTROLADOR = '<?php echo $_SESSION['controlador']; ?>';
        var ACCION = '<?php echo $_SESSION['metodo']; ?>';
        var TOKEN = '<?php echo $_SESSION['token']; ?>';
    </script>

</head>

<body class="hold-transition layout-fixed sidebar-collapse">
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="height: auto;">
            <!-- Content Header (Page header) -->
            <?php
            echo HtmlBuilder::contentHeader( isset($datos['forms_data']['forms']['form1']['title']) ? $datos['forms_data']['forms']['form1']['title'] : '' );
            ?>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">

                    <form 
                    id="form_<?php echo isset($datos['forms_data']['forms']['form1']['logical_name']) ? $datos['forms_data']['forms']['form1']['logical_name'] : ''; ?>" 
                    action="<?php echo isset($datos['forms_data']['forms']['form1']['action']) ? $datos['forms_data']['forms']['form1']['action'] : ''; ?>" 
                    method="<?php echo (isset($datos['forms_data']['forms']['form1']['method'])) ? $datos['forms_data']['forms']['form1']['method'] : 'POST'; ?>">

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">
                                        Nombre <?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['first_name']['required']) && $datos['forms_data']['forms']['form1']['inputs_params']['first_name']['required'] ? '*' : ''; ?>
                                    </label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_first_name" name="first_name" 
                                        value="<?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['first_name']['value']) ? $datos['forms_data']['forms']['form1']['inputs_params']['first_name']['value'] : ''; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">
                                        Apellido paterno <?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['last_name']['required']) && $datos['forms_data']['forms']['form1']['inputs_params']['last_name']['required'] ? '*' : ''; ?>
                                    </label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_last_name" name="last_name" 
                                        value="<?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['last_name']['value']) ? $datos['forms_data']['forms']['form1']['inputs_params']['last_name']['value'] : ''; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">
                                        Apellido materno <?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['middle_name']['required']) && $datos['forms_data']['forms']['form1']['inputs_params']['middle_name']['required'] ? '*' : ''; ?>
                                    </label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_middle_name" name="middle_name" 
                                        value="<?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['middle_name']['value']) ? $datos['forms_data']['forms']['form1']['inputs_params']['middle_name']['value'] : ''; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">
                                        Email <?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['email']['required']) && $datos['forms_data']['forms']['form1']['inputs_params']['email']['required'] ? '*' : ''; ?>
                                    </label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_email" name="email" 
                                        value="<?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['email']['value']) ? $datos['forms_data']['forms']['form1']['inputs_params']['email']['value'] : ''; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">
                                        Usuario <?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['username']['required']) && $datos['forms_data']['forms']['form1']['inputs_params']['username']['required'] ? '*' : ''; ?>
                                    </label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_username" name="username" 
                                        value="<?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['username']['value']) ? $datos['forms_data']['forms']['form1']['inputs_params']['username']['value'] : ''; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">
                                        Contraseña <?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['password']['required']) && $datos['forms_data']['forms']['form1']['inputs_params']['password']['required'] ? '*' : ''; ?>
                                    </label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <input type="password" class="form-control form-control-sm rounded-0" id="txt_password" name="password" 
                                        value="<?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['password']['value']) ? $datos['forms_data']['forms']['form1']['inputs_params']['password']['value'] : ''; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-3">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">
                                        Confirmar contraseña <?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['confirm_password']['required']) && $datos['forms_data']['forms']['form1']['inputs_params']['confirm_password']['required'] ? '*' : ''; ?>
                                    </label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <input type="password" class="form-control form-control-sm rounded-0" id="txt_confirm_password" name="confirm_password" 
                                        value="<?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['confirm_password']['value']) ? $datos['forms_data']['forms']['form1']['inputs_params']['confirm_password']['value'] : ''; ?>"
                                        autocomplete="off">
                                        <small id="pwd-match" class="form-text"></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">
                                        Perfil <?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['profile_id']['required']) && $datos['forms_data']['forms']['form1']['inputs_params']['profile_id']['required'] ? '*' : ''; ?>
                                    </label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <select class="form-control form-control-sm rounded-0" id="cmb_profile" name="profile_id" style="width: 100%;">
                                            <option value="">- Seleccionar perfil -</option>
                                            <?php
                                            foreach ($datos['forms_data']['list']['profiles'] as $val){
                                                $selected_perfil = ($val['id'] == $datos['forms_data']['forms']['form1']['inputs_params']['profile_id']['value'] ) ? "selected" : "" ;
                                                echo "<option value='" . $val['id'] . "' ". $selected_perfil ." >" . $val['description'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">
                                        Categorías <?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['json_categories']['required']) && $datos['forms_data']['forms']['form1']['inputs_params']['json_categories']['required'] ? '*' : ''; ?>
                                    </label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <div class="select2-primary">
                                            <select class="select2" multiple="multiple" data-dropdown-css-class="select2-primary" id="cmb_categories" name="json_categories" style="width: 100%;">
                                            <?php
                                            foreach ($datos['forms_data']['list']['categories'] as $val){
                                                $selected_tipo = ($val['id'] == $datos['forms_data']['forms']['form1']['inputs_params']['json_categories']['value'] ) ? "selected" : "" ;
                                                echo "<option value='" . $val['id'] . "' ". $selected_tipo ." >" . $val['description'] . "</option>";
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="txt_user_id" name="user_id" value="<?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['user_id']['value']) ? $datos['forms_data']['forms']['form1']['inputs_params']['user_id']['value'] : ''; ?>">

                        <div class="row mt-4">
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-primary btn-sm btn-flat" id="btn_save"><?php echo isset($datos['forms_data']['forms']['form1']['button']) ? $datos['forms_data']['forms']['form1']['button'] : ''; ?></button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- REQUIRED SCRIPTS -->
    <?php
    define('BOOTBOX', 0);
    define('FILES', 0);
    define('DATE_PICKER_JS', 0);
    define('ADMINLTE', 0);
    define('INPUTMASK', 0);
    include PROJECT_PATH . 'views/includes/script-js.php';

        $(document).ready(function() {

            $('#cmb_categories').select2();

            var categorias = <?php echo (empty($datos['forms_data']['forms']['form1']['inputs_params']['json_categories']['value'])) ? "[]" : $datos['forms_data']['forms']['form1']['inputs_params']['json_categories']['value'] ; ?>;
            $('#cmb_categories').val(categorias).trigger('change');

        });


        $('#form_user').on('submit', function(e) {
            e.preventDefault();

            $("#btn_save").prop('disabled', true);

            // Convertir los valores en JSON
            let selectedValues = $('#cmb_categories').val();
            let json_categories = JSON.stringify(selectedValues);

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize() + "&json_categories="+ json_categories + "&token=" + TOKEN,
                type: "<?php echo (isset($datos['forms_data']['forms']['form1']['method'])) ? $datos['forms_data']['forms']['form1']['method'] : 'POST'; ?>",
            }).done( function(data) {

                // var json_response = JSON.parse(data);

                const opciones = {
                    'success': () => {
                        if ( data.is_error == false ) {

                            UI.create_tab('Usuarios', URL_PATH + CONTROLADOR);
                            const message = JSON.stringify({
                                status: data.meta_data.alert_type,
                                msg: data.message,
                                accion: ACCION
                            });
                            
                            setTimeout(function() {
                                var iframeDestino = window.parent.document.getElementById("usuarios");
                                iframeDestino.contentWindow.postMessage(message, URL_PATH + CONTROLADOR);
                                /* if ( ACCION != 'editar' ) {
                                    setTimeout(function() {
                                        reset_form();
                                        $("#btn_save").prop('disabled', false);
                                    }, 500);
                                } */

                            }, 1000);
                        }
                    },
                    'warning': () => {
                        toastr.warning(data.message);
                        $("#btn_save").prop('disabled', false);
                    },
                    'error': () => {
                        toastr.error(data.message);
                        $("#btn_save").prop('disabled', false);
                    }
                }
                const opcion_default = () => {
                    toastr.error("Se ha producido un error");
                };
                
                const estatus = opciones[data.meta_data.alert_type] ? opciones[data.meta_data.alert_type]() : opcion_default();
            
            }).fail(function(xhr, status, error) {

                var responseJSON = xhr.responseJSON;
                if (xhr.status == 404) {
                    toastr.error('Error 404: Recurso no encontrado');
                } else {
                    if (responseJSON && responseJSON.message) {
                        toastr.error(responseJSON.message);
                    }
                }

                setTimeout(function() {
                    $("#btn_save").prop('disabled', false);
                }, 300);

            }).always( function() {

                setTimeout(function() {
                    $("#btn_save").prop('disabled', false);
                }, 300);

            });

        });

        /* function reset_form() 
        {
            $("#txt_first_name").val("");
            $("#txt_last_name").val("");
            $("#txt_middle_name").val("");
            $("#txt_email").val("");
            $("#txt_username").val("");
            $("#txt_password").val("");
            $("#txt_confirm_password").val("");
            document.getElementById("cmb_profile").selectedIndex = "0";
            $('#cmb_categories').val(null).trigger('change');
        } */

    </script>

</body>

</html>