<?php
namespace app\Helpers;

class HtmlBuilder
{
    public static function contentHeader($title = '')
    {
        /* return '
        <div class="content-header">
            <div class="container-fluid">
                <h4 class="mb-2">' . htmlspecialchars($title) . '</h4>
            </div>
        </div>
        '; */
        return '
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="mb-0">' . htmlspecialchars($title) . '</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';

    }

    // Puedes agregar más métodos para otros bloques HTML
}