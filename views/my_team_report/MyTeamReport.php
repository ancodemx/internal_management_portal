<!doctype html>
<html lang="es">
<head>
    <title><?php echo PROJECT_NAME; ?> | Reporte de mi equipo</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <?php
    define('DATE_PICKER_CSS', 1);
    include PROJECT_PATH . 'views/includes/script-css.php';
    ?>
    <link rel="stylesheet" href="<?php echo RESOURCES_PATH; ?>/adminlte320/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <div class="loader-bg"><div class="loader-track"><div class="loader-fill"></div></div></div>

    <?php
    include PROJECT_PATH . 'views/includes/left_sidebar_menu.php';
    include PROJECT_PATH . 'views/includes/header.php';
    ?>

    <div class="pc-container">
        <div class="pc-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="mb-0">Reporte de mi equipo</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="my_team_report_form">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="start_date">Seleccionar rango</label>
                                        <div class="input-daterange input-group" id="datepicker_range">
                                            <input type="text" class="form-control text-start" placeholder="Fecha inicial" name="start_date" id="start_date" autocomplete="off" />
                                            <input type="text" class="form-control text-end" placeholder="Fecha final" name="end_date" id="end_date" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="hotel_code">Hotel</label>
                                        <select class="form-select" id="hotel_code" name="hotel_code">
                                            <option value="ALL">Todos</option>
                                            <option value="NU">Sunset Palace</option>
                                            <option value="OP">Oceano Palace</option>
                                            <option value="PP">Pacific Palace</option>
                                            <option value="SP">Star Palace</option>
                                            <option value="LP">Luna Palace</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" id="btn_filtrar">Filtrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row d-none" id="report-table-section">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="my-team-report-table" class="table table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th>Num. de colaborador</th>
                                            <th>Nombre completo</th>
                                            <th>Departamento</th>
                                            <th>Cargo</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include PROJECT_PATH . 'views/includes/footer.php'; ?>

    <?php
    define('DATE_PICKER_JS', 1);
    define('ADMINLTE', 0);
    include PROJECT_PATH . 'views/includes/script-js.php';
    ?>
    <script src="<?php echo RESOURCES_PATH; ?>/adminlte320/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo RESOURCES_PATH; ?>/adminlte320/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        new DateRangePicker(document.querySelector('#datepicker_range'), {
            buttonClass: 'btn',
            format: 'dd/mm/yyyy'
        });
    });
    </script>

    <script>
    let myTeamReportTable;

    $('#my_team_report_form').on('submit', function (event) {
        event.preventDefault();

        const startDate = $('#start_date').val();
        const endDate = $('#end_date').val();

        if (!startDate || !endDate) {
            Swal.fire('Atencion', 'Selecciona un rango de fechas.', 'warning');
            return;
        }

        $('#report-table-section').removeClass('d-none');

        if (myTeamReportTable) {
            myTeamReportTable.ajax.reload();
            return;
        }

        // Petición AJAX para obtener el JSON de registros y construir el DataTable en cliente-side
        const postData = {
            start_date: $('#start_date').val(),
            end_date: $('#end_date').val(),
            hotel_code: $('#hotel_code').val(),
            token: '<?php echo $_SESSION['token'] ?? ''; ?>'
        };

        $.post('<?php echo URL_PATH; ?>myTeamReport/data_table_list', postData, function (response) {
            // Robust parsing: puede venir como {response: [...]}, como string JSON o como objeto con data
            let records = response;
            console.log('MyTeamReport: response crudo', response);
            if (response && response.response !== undefined) records = response.response;
            if (typeof records === 'string') {
                try { records = JSON.parse(records); } catch (e) {
                    // Intento de recuperación: si son objetos JSON concatenados sin []
                    const s = records.trim();
                    if (s.startsWith('{') && (s.indexOf('}{') !== -1 || s.indexOf('},{') !== -1)) {
                        try { records = JSON.parse('[' + s.replace(/}\s*{/g, '},{') + ']'); } catch (e2) { /* ignore */ }
                    }
                }
            }
            if (records && records.data !== undefined) records = records.data;

            // Manejar caso: [{ RESPONSE: '[...]' }]
            if (Array.isArray(records) && records.length === 1 && records[0] && records[0].RESPONSE !== undefined) {
                let inner = records[0].RESPONSE;
                if (typeof inner === 'string') {
                    try { inner = JSON.parse(inner); } catch (e) {
                        const s2 = inner.trim();
                        if (s2.startsWith('{') && (s2.indexOf('}{') !== -1 || s2.indexOf('},{') !== -1)) {
                            try { inner = JSON.parse('[' + s2.replace(/}\s*{/g, '},{') + ']'); } catch (e3) { /* ignore */ }
                        }
                    }
                }
                records = inner;
            }

            console.log('MyTeamReport: records recibidos', records);

            const dataArray = Array.isArray(records) ? records : [];

            // Inicializar DataTable con renderers que soporten múltiples nombres de campo
            myTeamReportTable = $('#my-team-report-table').DataTable({
                destroy: true,
                data: dataArray,
                pageLength: 15,
                columns: [
                    { data: null, render: function (d) { return d.collaborator_number || d.employee_number || d.num_colaborador || d.numero_colaborador || d.colaborador || ''; } },
                    { data: null, render: function (d) { return d.full_name || d.nombre_completo || d.fullname || d.nombre || ''; } },
                    { data: null, render: function (d) { return d.department || d.departamento || d.area || ''; } },
                    { data: null, render: function (d) { return d.position || d.cargo || d.puesto || ''; } }
                ],
                responsive: true,
                searching: true,
                ordering: true
            });

            if (dataArray.length === 0) {
                Swal.fire('Atención', 'No se encontraron registros para ese rango/hotel.', 'info');
            }

        }, 'json').fail(function () {
            Swal.fire('Error', 'No se pudo obtener los registros.', 'error');
        });
    });
    </script>
</body>
</html>