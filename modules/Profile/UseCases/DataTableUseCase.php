<?php

namespace modules\Profile\UseCases;

use modules\Profile\Factories\DataTableFactory;
use app\utilities\Factory\DataTableResponseFactory;

use modules\Profile\ProfileService;

use app\Helpers\DataTableRowBuilder;

use app\Utils\AppResponse;

class DataTableUseCase
{
    private ProfileService $profileService;

    public function __construct() {
        $this->profileService = new ProfileService();
    }

    public function execute( array $data_post ) : array
    {
        try {

            $datatable_params = DataTableFactory::make($data_post);

            $data_table = $this->profileService->searchDataTable( $datatable_params);

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

                    $actions .= "
                                <small>
                                    <a class='dropdown-item text-muted nav-link' href='#' name='edit' data-id='". intval($value['id']) ."'>Editar</a>
                                </small>
                    ";

                    $actions .= "
                                <small>
                                    <a class='dropdown-item text-muted nav-link' href='#' name='remove' data-id='". intval($value['id']) ."'>Baja</a>
                                </small>
                    ";

                    $actions .= "
                                </div>
                            </div>
                        </div>
                    ";

                    

                    return [
                        $value['profile_name'],
                        $value['description'],
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

        } catch (\Throwable $e) {

            throw $e; // <-- vuelve a lanzar la excepción
        }
    }

}