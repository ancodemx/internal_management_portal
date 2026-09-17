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

        myTeamReportTable = $('#my-team-report-table').DataTable(
            UI.paramsDataTable(
                15,
                '<?php echo URL_PATH; ?>myTeamReport/data_table_list',
                'POST',
                function (data) {
                    data.start_date = $('#start_date').val();
                    data.end_date = $('#end_date').val();
                    data.hotel_code = $('#hotel_code').val();
                    data.token = '<?php echo $_SESSION['token'] ?? ''; ?>';
                },
                [
                    { targets: [0] },
                    { targets: [1] },
                    { targets: [2] },
                    { targets: [3] }
                ]
            )
        );
    });
    </script>
</body>
</html>