<!-- jQuery -->
<script src="<?php echo TEMPLATE_PATH; ?>/plugins/jquery/jquery.min.js"></script>
<!-- TEMPLATE_PATH App -->
<script src="<?php echo TEMPLATE_PATH; ?>/dist/js/adminlte.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo TEMPLATE_PATH; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<?php if (TOASTR) { ?>
    <!-- Toastr -->
    <script src="<?php echo TEMPLATE_PATH; ?>/plugins/toastr/toastr.min.js"></script>
<?php } ?>

<?php if (DATATABLE) { ?>
    <!-- DataTables -->
    <script src="<?php echo TEMPLATE_PATH; ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo TEMPLATE_PATH; ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo TEMPLATE_PATH; ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo TEMPLATE_PATH; ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script src="<?php echo TEMPLATE_PATH; ?>/plugins/datatables-select/js/dataTables.select.js"></script>
<?php } ?>

<?php if (BOOTBOX) { ?>
    <!-- BootBox -->
    <script src="<?php echo RESOURCES_PATH; ?>/bootbox/bootbox.js"></script>
<?php } ?>

<?php if (FILES) { ?>
    <!-- bs-custom-file-input -->
    <script src="<?php echo TEMPLATE_PATH; ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<?php } ?>

<?php if (LOADING) { ?>
    <!-- Loading -->
    <script src="<?php echo RESOURCES_PATH; ?>/loading/jquery.loading.min.js"></script>
<?php } ?>

<?php if (SUMMERNOTE) { ?>
    <!-- Summernote -->
    <script src="<?php echo TEMPLATE_PATH; ?>/plugins/summernote/summernote-bs4.min.js"></script>
<?php } ?>

<?php if (INPUTMASK) { ?>
    <!-- InputMask -->
    <script src="<?php echo TEMPLATE_PATH; ?>/plugins/moment/moment.min.js"></script>
    <script src="<?php echo TEMPLATE_PATH; ?>/plugins/inputmask/jquery.inputmask.min.js"></script>
<?php } ?>

<?php if (SELECT2) { ?>
    <!-- Select2 -->
    <script src="<?php echo TEMPLATE_PATH; ?>/plugins/select2/js/select2.full.min.js"></script>
<?php } ?>

<?php if (DATE_PICKER) { ?>
    <!-- date-range-picker -->
    <script src="<?php echo TEMPLATE_PATH; ?>/plugins/moment/moment.min.js"></script>
    <script src="<?php echo TEMPLATE_PATH; ?>/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- date-picker -->
    <script src="<?php echo TEMPLATE_PATH; ?>/plugins/jquery-ui/jquery-ui.js"></script>
<?php } ?>

<!-- Main -->
<script src="<?php echo URL_PATH; ?>public/js/Utilities.js"></script>
<script src="<?php echo URL_PATH; ?>public/js/UI.js"></script>
<script src="<?php echo URL_PATH; ?>public/js/Main.js"></script>
