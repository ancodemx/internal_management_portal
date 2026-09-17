<link rel="shortcut icon" href="<?php echo URL_PATH; ?>public/img/logo.ico">

<script src="https://kit.fontawesome.com/dd0a778bca.js" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow&family=Barlow+Condensed&family=Gilda+Display&display=swap">

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>/plugins/fontawesome-free/css/all.min.css">

<?php if (TOASTR) { ?>
    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>/plugins/toastr/toastr.min.css">
<?php } ?>

<?php if (DATATABLE) { ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>/plugins/datatables-select/css/select.bootstrap4.css">
<?php } ?>

<!-- Theme style -->
<link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>/dist/css/adminlte.min.css">

<?php if (SUMMERNOTE) { ?>
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>/plugins/summernote/summernote-bs4.min.css">
<?php } ?>

<?php if (DATE_PICKER) { ?>
    <!-- date-picker -->
    <link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_PATH; ?>/plugins/jquery-ui/jquery-ui.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>/plugins/daterangepicker/daterangepicker.css">
<?php } ?>

<?php if (SELECT2) { ?>
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo TEMPLATE_PATH; ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<?php } ?>

<?php if (LOADING) { ?>
    <!-- Loading -->
    <link rel="stylesheet" type="text/css" href="<?php echo RESOURCES_PATH; ?>/loading/demo.css">
<?php } ?>

<link rel="stylesheet" href="<?php echo PUBLIC_URL_PATH; ?>/css/estilos.css">

<style>
    [class*=sidebar-dark-] .nav-header {
        color: #7e8187;
    }

    .nav-compact .nav-header:not(:first-of-type) {
        padding-top: 5px;
        padding-bottom: .25rem;
    }

</style>

<?php if (SELECT2) { ?>
<style type="text/css">
    /* Select2 */
    .select2-container--default .select2-selection--single {
        border: 1px solid #ced4da;
        border-radius: 0px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow, select.form-control-sm~.select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 3px;
    }

    select.form-control-sm ~ .select2-container--default {
        font-size: .875rem;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 0px
    }

    .select2-container--default .select2-results__option {
        padding: 2px 12px;
        font-size: 16px;
    }
    /* End Select2 */

    .select2-container .select2-selection {
        border-radius: 0; /* Quitar bordes redondeados */
        /* font-size: 0.875rem; */ /* Tamaño de texto pequeño */
        /*height: calc(1.8125rem + 2px); /* Ajustar la altura para combinar con form-control-sm */
    }

    .select2-container .select2-selection--multiple {
        border: 1px solid #ced4da; /* Asegura que el borde sea consistente */
    }

    .select2-dropdown {
        border-radius: 0; /* También quita bordes redondeados del dropdown */
    }
</style>
<?php } ?>