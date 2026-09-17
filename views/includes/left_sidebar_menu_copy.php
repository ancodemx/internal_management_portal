<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo URL_PATH; ?>home" class="brand-link">
        <?php if (LOGO_MENU_LEFT): ?>
            <img src="<?php echo URL_PATH; ?>public/img/logo.png" width="50" height="50" class="brand-image elevation-0" style="opacity: .8; width: 44px; margin-top: 1px; margin-left: 5px;">
        <?php endif; ?>
        <span class="brand-text font-weight-light" style="font-size: 18px;"><?php echo APP_TITLE; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
        
        <?php

        $groupedMenuItems = [];

        // Agrupar los elementos del menú por group_id
        foreach ($_SESSION['profile_menu'] as $key => $menuItem) {
            $groupId = $menuItem['group_id'] ?? 0;
            if (!empty($groupId)) {
                if (!isset($groupedMenuItems[$groupId])) {
                    $groupedMenuItems[$groupId] = [];
                }
                $groupedMenuItems[$groupId]['group_id'] = $menuItem['group_id'];
                $groupedMenuItems[$groupId]['group_name'] = $menuItem['group_name'];
                $groupedMenuItems[$groupId]['menuItem'][$key] = $menuItem;
            } else {
                $groupedMenuItems[$groupId]['group_id'] = $menuItem['group_id'];
                $groupedMenuItems[$groupId]['group_name'] = $menuItem['group_name'];
                $groupedMenuItems[$groupId]['menuItem'][$key] = $menuItem;
            }
        }
        
        // print_r($groupedMenuItems);
        $profile_menu = $groupedMenuItems;

        function generarMenu($groupedMenuItems)
        {
            echo '<ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact" data-widget="treeview" role="menu" data-accordion="false">';
            
            foreach ($groupedMenuItems as $groupId => $menuItems) {

                // echo '<li class="nav-item">';

                if ( !empty($menuItems['group_id']) ) {
                    echo "
                        <li class='nav-header' style='font-size: 12px;'>{$menuItems['group_name']}</li>
                    ";
                }
                // print_r($menuItems['menuItem']);

                foreach ($menuItems['menuItem'] as $menuItem) {

                    if (!empty($menuItem['child'])) { // Submenú

                        // Extraer todos los valores del índice 'metodo'
                        $metodos = array_column($menuItem['child'], 'metodo');
                        // Verificar si el método está en el array
                        $expanded = (in_array($_SESSION['controlador'], $metodos)) ? 'true' : 'false';

                        $slug = \app\Utils\Utilities::slug($menuItem['name']);

                        echo '<li class="nav-item">';

                        echo "
                            <a href='#' class='nav-link' style='font-size: 12px;'>
                                <i class='nav-icon {$menuItem['icon']}' style='font-size: 16px;'></i>
                                <p>
                                    {$menuItem['name']}
                                    <i class='right fa-solid fa-chevron-right' style='font-size: 10px; right: 12px; top: 11px'></i>
                                </p>
                            </a>
                        ";

                        generarSubMenu($menuItem['child'], 1, $slug);

                        echo '</li>';

                    }else{
                        echo "
                            <li class='nav-item'>
                                <a href='" . URL_PATH . $menuItem['url'] . "' class='nav-link'>
                                    <i class='nav-icon {$menuItem['icon']}' style='font-size: 16px;'></i>
                                    <p>{$menuItem['name']}</p>
                                </a>
                            </li>
                        ";    
                    }

                    echo '</li>';
                }

            }
            
            echo '</ul>';
        }

        function generarSubMenu($subMenuItems, $submenu = 0, $slug = '')
        {
            echo "<ul class='nav nav-treeview' style='display: none;'>";
            
            foreach ($subMenuItems as $subMenuItem) {
                echo '<li class="nav-item">';

                $url = '#';
                if ( !empty($subMenuItem['url']) )
                    $url = URL_PATH . $subMenuItem['url'];

                echo "<a href='{$url}' class='nav-link' style='font-size: 12px;'>";

                echo "<p>";
                echo $subMenuItem['name'];

                if ( empty($subMenuItem['url']) )
                    echo "<i class='right fa-solid fa-chevron-left' style='font-size: 10px; right: 22px; top: 11px;'></i>";

                echo "</p>";
                echo "</a>";

                // Verificar si hay más niveles
                if ( !empty($subMenuItem['child']) ) {
                    generarSubMenu($subMenuItem['child'], 1);
                }

                echo '</li>';
            }
            
            echo '</ul>';
        }

        // Llamar a la función para generar el menú
        // generarMenu( $_SESSION['profile_menu'] );
        generarMenu( $profile_menu );

        ?>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>