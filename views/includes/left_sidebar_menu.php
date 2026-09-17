    <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="<?php echo URL_PATH; ?>home" class="b-brand text-primary">
                    <span class="pc-toggle text-gray-100"><?php echo APP_TITLE; ?></span>
                </a>
                
            </div>
            <div class="navbar-content">

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
                echo '<ul class="pc-navbar">';
                
                foreach ($groupedMenuItems as $groupId => $menuItems) {

                    // echo '<li class="nav-item">';

                    if ( !empty($menuItems['group_id']) ) {
                        echo "
                            <li class='pc-item pc-caption'>
                                <label data-i18n='{$menuItems['group_name']}'>{$menuItems['group_name']}</label>
                            </li>
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

                            echo '<li class="pc-item pc-hasmenu">';

                            echo "
                                <a href='#!' class='pc-link'>
                                    <span class='pc-micon'>
                                        <i class='{$menuItem['icon']}'></i>
                                    </span>
                                    <span class='pc-mtext' data-i18n='{$menuItem['name']}'>{$menuItem['name']}</span>
                                    <span class='pc-arrow'><i class='ti ti-chevron-right'></i></span>
                                </a>
                            ";

                            generarSubMenu($menuItem['child'], 1, $slug);

                            echo '</li>';

                        }else{ 
                            echo "
                                <li class='pc-item'>
                                    <a href='" . URL_PATH . $menuItem['url'] . "' class='pc-link'>
                                        <span class='pc-micon'> 
                                            <i class='ph ph-vinyl-record'></i> 
                                        </span>
                                        <span class='pc-mtext' data-i18n='{$menuItem['name']}'>{$menuItem['name']}</span>
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
                // echo "<ul class='nav nav-treeview' style='display: none;'>";
                echo "<ul class='pc-submenu'>";
                
                foreach ($subMenuItems as $subMenuItem) {
                    echo '<li class="pc-item">';

                    $url = '#';
                    if ( !empty($subMenuItem['url']) )
                        $url = URL_PATH . $subMenuItem['url'];

                    // echo "<a href='{$url}' class='nav-link' style='font-size: 12px;'>";
                    echo "<a class='pc-link' href='{$url}' data-i18n='{$subMenuItem['name']}'>";

                    echo "<p>";
                    echo $subMenuItem['name'];

                    if ( empty($subMenuItem['url']) )
                        // echo "<i class='right fa-solid fa-chevron-left' style='font-size: 10px; right: 22px; top: 11px;'></i>";
                    echo "<i class='pc-arrow'><i class='ti ti-chevron-right'></i></span>";

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


        </div>
        <!-- /.navbar-content -->
    </nav>
    <!-- [ Sidebar Menu ] end -->