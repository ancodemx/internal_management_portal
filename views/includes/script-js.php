<!-- Required JS -->
<script src="<?php echo URL_PATH; ?>jquery/jquery.min.js"></script>
<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/plugins/popper.min.js"></script>
<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/plugins/simplebar.min.js"></script>
<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/plugins/bootstrap.min.js"></script>
<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/plugins/i18next.min.js"></script>
<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/plugins/i18nextHttpBackend.min.js"></script>
<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/script.js"></script>
<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/theme.js"></script>
<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/multi-lang.js"></script>

<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/plugins/sweetalert2.all.min.js"></script>

<?php if (defined('DATE_PICKER_JS') && DATE_PICKER_JS) { ?>
<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/plugins/datepicker-full.min.js"></script>
<?php } ?>

<!-- Main -->
<script src="<?php echo URL_PATH; ?>js/Utilities.js"></script>
<script src="<?php echo URL_PATH; ?>js/UI.js"></script>
<script src="<?php echo URL_PATH; ?>js/Main.js"></script>

<!-- [Page Specific JS] start -->
<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/plugins/apexcharts.min.js"></script>


<?php if (defined('ADMINLTE') && ADMINLTE) { ?>
<!-- Bootstrap 4 -->
<script src="<?php echo RESOURCES_PATH; ?>/adminlte320/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo RESOURCES_PATH; ?>/adminlte320/dist/js/adminlte.min.js"></script>
<?php } ?>

<!-- Theme Configuration Scripts (hardcoded based on vite.config.js values) -->
<script>
    layout_change('light');
</script>
<script>
    change_box_container('false');
</script>
<script>
    layout_caption_change('true');
</script>
<script>
    layout_rtl_change('false');
</script>
<script>
    preset_change('preset-1');
</script>
<script>
    layout_theme_sidebar_change('false');
</script>