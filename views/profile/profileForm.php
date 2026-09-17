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
            echo HtmlBuilder::contentHeader(isset($datos['forms_data']['forms']['form1']['title']) ? $datos['forms_data']['forms']['form1']['title'] : '');
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

                            <div class="form-group col-md-12 col-lg-3 mb-1">
                                <label class="form-label font-weight-normal text-sm mb-0">
                                    Perfil <?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['profile_name']['required']) && $datos['forms_data']['forms']['form1']['inputs_params']['profile_name']['required'] ? '*' : ''; ?>
                                </label>
                                <input type="text" class="form-control rounded-0" id="txt_profile_name" name="profile_name"
                                    value="<?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['profile_name']['value']) ? $datos['forms_data']['forms']['form1']['inputs_params']['profile_name']['value'] : ''; ?>"
                                    autocomplete="off">
                            </div>

                            <div class="form-group col-md-12 col-lg-6 mb-1">
                                <label class="form-label font-weight-normal text-sm mb-0">
                                    Descripción <?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['description']['required']) && $datos['forms_data']['forms']['form1']['inputs_params']['description']['required'] ? '*' : ''; ?>
                                </label>
                                <input type="text" class="form-control rounded-0" id="txt_description" name="description"
                                    value="<?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['description']['value']) ? $datos['forms_data']['forms']['form1']['inputs_params']['description']['value'] : ''; ?>"
                                    autocomplete="off">
                            </div>

                        </div>

                        <hr class="mt-4 mb-4">

                        <h5 class="mb-3">Permisos</h5>

                        <div class="row">

                            <div class="col-6">
                                <div class="card border shadow-none">
                                    <div class="card-header">
                                        <h6 class="card-title" style="font-weight: 600;">Perfiles</h6>
                                    </div>
                                    <div class="card-body p-3">

                                        <div class="row">

                                            <div class="form-group col-md-6 col-lg-3 mb-0">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="view_modules[]" id="view_module_profile" value="2"
                                                    <?php echo (isset($datos['forms_data']['forms']['form1']['inputs_params']['view_module_profile']['value']) && $datos['forms_data']['forms']['form1']['inputs_params']['view_module_profile']['value'] == '2') ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="view_module_profile">Ver módulo</label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6 col-lg-3 mb-0">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[2][]" id="create_profile" value="create_profile"
                                                    <?php echo (isset($datos['forms_data']['forms']['form1']['inputs_params']['create_profile']['value']) && $datos['forms_data']['forms']['form1']['inputs_params']['create_profile']['value'] == 'create_profile') ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="create_profile">Crear</label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6 col-lg-3 mb-0">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[2][]" id="edit_profile" value="edit_profile"
                                                    <?php echo (isset($datos['forms_data']['forms']['form1']['inputs_params']['edit_profile']['value']) && $datos['forms_data']['forms']['form1']['inputs_params']['edit_profile']['value'] == 'edit_profile') ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="edit_profile">Editar</label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6 col-lg-3 mb-0">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[2][]" id="delete_profile" value="delete_profile"
                                                    <?php echo (isset($datos['forms_data']['forms']['form1']['inputs_params']['delete_profile']['value']) && $datos['forms_data']['forms']['form1']['inputs_params']['delete_profile']['value'] == 'delete_profile') ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="delete_profile">Eliminar</label>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="card border shadow-none">
                                    <div class="card-header">
                                        <h6 class="card-title" style="font-weight: 600;">Usuarios</h6>
                                    </div>
                                    <div class="card-body p-3">

                                        <div class="row">

                                            <div class="form-group col-md-6 col-lg-3 mb-0">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="view_modules[]" id="view_module_user" value="3"
                                                    <?php echo (isset($datos['forms_data']['forms']['form1']['inputs_params']['view_module_user']['value']) && $datos['forms_data']['forms']['form1']['inputs_params']['view_module_user']['value'] == '3') ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="view_module_user">Ver módulo</label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6 col-lg-3 mb-0">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[3][]" id="create_user" value="create_user"
                                                    <?php echo (isset($datos['forms_data']['forms']['form1']['inputs_params']['create_user']['value']) && $datos['forms_data']['forms']['form1']['inputs_params']['create_user']['value'] == 'create_user') ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="create_user">Crear</label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6 col-lg-3 mb-0">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[3][]" id="edit_user" value="edit_user"
                                                    <?php echo (isset($datos['forms_data']['forms']['form1']['inputs_params']['edit_user']['value']) && $datos['forms_data']['forms']['form1']['inputs_params']['edit_user']['value'] == 'edit_user') ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="edit_user">Editar</label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6 col-lg-3 mb-0">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[3][]" id="delete_user" value="delete_user"
                                                    <?php echo (isset($datos['forms_data']['forms']['form1']['inputs_params']['delete_user']['value']) && $datos['forms_data']['forms']['form1']['inputs_params']['delete_user']['value'] == 'delete_user') ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="delete_user">Eliminar</label>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <input type="text" id="txt_profile_id" name="profile_id" value="<?php echo isset($datos['forms_data']['forms']['form1']['inputs_params']['profile_id']['value']) ? $datos['forms_data']['forms']['form1']['inputs_params']['profile_id']['value'] : ''; ?>">

                        <div class="row mt-4">
                            <div class="form-group col-12">
                                <a class="btn btn-secondary btn-flat" id="btnCerrar" href="#">Cerrar</a>
                                <button type="submit" class="btn btn-primary btn-flat" id="btn_save"><?php echo isset($datos['forms_data']['forms']['form1']['button']) ? $datos['forms_data']['forms']['form1']['button'] : ''; ?></button>
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
    ?>

    <script type="text/javascript">
        $(function() {
            // Cache de selectores
            const $form = $('#form_profile');
            const $btnSave = $('#btn_save');

            // Delegación por si el form se renderiza dinámicamente
            $(document).on('submit', '#form_profile', function(e) {
                e.preventDefault();

                // Evita doble submit
                // if ($btnSave.length) $btnSave.prop('disabled', true);

                // Prepara datos: usa FormData -> objeto plano
                const fd = new FormData(this);
                // Evita poner el token en la URL; mándalo en header o en el cuerpo
                // Si tu backend acepta header, es mejor seguridad:
                //   headers: { 'X-CSRF-Token': TOKEN }
                // Si no, lo agregamos al cuerpo:
                fd.append('token', TOKEN);

                $.ajax({
                        url: $form.attr('action'),
                        // Si tu backend recibe x-www-form-urlencoded:
                        // data: $.param(Array.from(fd.entries())),
                        // contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                        // processData: true,

                        // Mejor: si tu backend acepta JSON, envía JSON (recomendado)
                        // data: JSON.stringify(Object.fromEntries(fd.entries())),
                        // contentType: 'application/json; charset=UTF-8',
                        data: fd,
                        contentType: false,
                        processData: false,

                        type: "<?= isset($datos['forms_data']['forms']['form1']['method']) ? strtoupper($datos['forms_data']['forms']['form1']['method']) : 'POST'; ?>",
                        dataType: 'json', // ← evita tener que hacer JSON.parse
                        timeout: 15000, // ← evita requests colgados
                        // headers: { 'X-CSRF-Token': TOKEN }, // ← preferible si tu backend lo usa
                        beforeSend: function() {
                            if ($btnSave.length) $btnSave.prop('disabled', true);
                        }
                    })
                    .done(function(data) {
                        // Normaliza estructura esperada
                        const type = data?.meta_data?.alert_type || 'error';
                        const isOk = data?.is_error === false;

                        const acciones = {
                            success: function() {
                                if (!isOk) return acciones.error(); // coherencia con is_error
                                // Abre/recarga pestaña
                                UI.create_tab('Perfiles', URL_PATH + CONTROLADOR);

                                // Mensaje a iframe padre (mismo origen)
                                const payload = JSON.stringify({
                                    status: data.meta_data.alert_type,
                                    msg: data.message,
                                    accion: ACCION
                                });

                                // targetOrigin: usa EXACTAMENTE el origen (protocolo+host+puerto) por seguridad
                                const targetOrigin = location.origin;

                                setTimeout(function() {
                                    const iframe = window.parent?.document?.getElementById('perfiles');
                                    if (iframe?.contentWindow) {
                                        iframe.contentWindow.postMessage(payload, targetOrigin);
                                    }
                                }, 400);
                            },
                            warning: function() {
                                toastr.warning(data?.message || 'Advertencia');
                            },
                            error: function() {
                                toastr.error(data?.message || 'Se ha producido un error');
                            }
                        };

                        (acciones[type] || acciones.error)();
                    })
                    .fail(function(xhr) {
                        const res = xhr.responseJSON;
                        if (xhr.status === 404) {
                            toastr.error('Error 404: Recurso no encontrado');
                        } else if (res?.message) {
                            toastr.error(res.message);
                        } else {
                            toastr.error('Error de red o del servidor');
                        }
                    })
                    .always(function() {
                        // Rehabilita el botón con un pequeño delay
                        setTimeout(function() {
                            if ($btnSave.length) $btnSave.prop('disabled', false);
                        }, 250);
                    });
            });

            // Cerrar tab (usa jQuery por consistencia y delegación por si el botón no existe aún)
            $(document).on('click', '#btnCerrar', function() {
                if (window.top?.iFrameInstance?.removeActiveTab) {
                    window.top.iFrameInstance.removeActiveTab();
                }
            });
        });
    </script>

</body>

</html>