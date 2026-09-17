<?php

namespace modules\User\UseCases;

use modules\User\Factories\DataTableFactory;
use app\utilities\Factory\DataTableResponseFactory;

use modules\User\UserService;

use app\Helpers\DataTableRowBuilder;

use app\Utils\AppResponse;

class DataTableUseCase
{
    private UserService $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function execute( array $data_post ) : array
    {
        try {

            $datatable_params = DataTableFactory::make($data_post);

            $data_table = $this->userService->searchDataTable( $datatable_params);

            // Formateamos la respuesta ya que cuando no se retornan datos en la base de datos, se debe retornar un array vacío
            $data_table['response'] = DataTableResponseFactory::make($data_table['response']);

            $datos = DataTableRowBuilder::buildRows(
                $data_post['draw'] ?? 1,
                $data_table['response'],
                function($value) {
                    
                    $status_color = match($value['status']){
                        0 => "secondary",
                        1 => "success",
                        default => "danger"
                    };
                    $description = $value['status_description'] ?? "Desconocido";
                    $badge_status = "<small class='badge bg-{$status_color}'>{$description}</small>";


                    $actions = "
                        <div class='margin'>
                            <div class='btn-group'>
                                <button type='button' class='btn btn-default btn-xs pt-0 pb-0' data-toggle='dropdown' aria-expanded='true' style='font-size: 9px;'>
                                    <span class='fa fa-ellipsis-h'></span>
                                </button>
                                <div class='dropdown-menu dropdown-menu-right' role='menu'>
                    ";

                    // Administrador principal no puede ser editado ni eliminado
                    if ($value['profile_id'] <> 1) {

                        $actions .= "
                                    <small>
                                        <a class='dropdown-item text-muted nav-link' href='#' name='edit' data-user_id='". intval($value['id']) ."'>Editar</a>
                                    </small>
                        ";

                        $actions .= "
                                    <small>
                                        <a class='dropdown-item text-muted nav-link' href='#' name='remove' data-user_id='". intval($value['id']) ."'>Baja</a>
                                    </small>
                        ";
                        
                    }

                    $actions .= "
                                </div>
                            </div>
                        </div>
                    ";

                    

                    return [
                        $value['fullname'],
                        $value['username'],
                        $value['profile'],
                        $badge_status,
                        $actions
                    ];
                }
            );
            // print_r($datos);

            return AppResponse::success(
                "DataTable retrieved successfully.",
                ["alert_type" => "success"],
                $datos,
                200,
                0
            );

            /* $badge_estatus = '';
            $acciones = '';

            $datos = array();
            foreach ($data_table['response']['data_list'] as $value) 
            {
                $subdatos[] = $value['fullname'];
                $subdatos[] = $value['username'];
                $subdatos[] = $value['profile'];
                $subdatos[] = $badge_estatus;
                $subdatos[] = $acciones;

                $datos[] = $subdatos;
            }

            if (empty($data_table['response']['data_list'])) {
                $json_data = [
                    "draw"            => $data['draw'],
                    "recordsTotal"    => 0,
                    "recordsFiltered" => 0,
                    "data"            => NULL
                ];
            } else {
                $json_data = [
                    "draw"            => $data['draw'],
                    "recordsTotal"    => $data_table['response']['total_data'],
                    "recordsFiltered" => $data_table['response']['total_filter'],
                    "data"            => $datos
                ];
            }

            // return $json_data;

            return AppResponse::success(
                "DataTable retrieved successfully.",
                ["alert_type" => "success"],
                $json_data,
                200
            ); */

        } catch (\Throwable $e) {

            throw $e; // <-- vuelve a lanzar la excepción
        }
    }

}