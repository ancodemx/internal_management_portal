class UI {

    static paramsDataTable(length = 15, url = "", method = "POST", data = {}, columns = [], msgTablaVacia = "No hay registros agregados.")
    {
        const obj = {
            "dom"       : '<"pull-left"f><"pull-right"l>tip',
            "responsive": false,
            "searching" : true,
            "paging"    : true,
            "lengthMenu": [[length],[length]],
            "ordering"  : false,
            "info"      : true,
            "processing": true,
            "serverSide": true,
            "ajax"      : {
                "url" : url,
                "type": method,
                "data": data
            },
            "columnDefs": columns,
            "bJQueryUI" : true,
            "oLanguage" : {
                "sEmptyTable"    : msgTablaVacia,
                "sInfo"          : "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
                "sInfoEmpty"     : "Mostrando desde 0 hasta 0 de 0 registros",
                "sInfoFiltered"  : "(filtrado de _MAX_ registros en total)",
                "sInfoPostFix"   : "",
                "sInfoThousands" : ",",
                "sLengthMenu"    : "Mostrar _MENU_ registros",
                "sLoadingRecords": "Cargando...",
                "sProcessing"    : "Procesando...",
                "sSearch"        : "Buscar:",
                "sZeroRecords"   : "No se encontraron resultados",
                "oPaginate"      : {
                    "sFirst"   : "Primero",
                    "sLast"    : "Último",
                    "sNext"    : "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending" : ": activar para Ordenar Ascendentemente",
                    "sSortDescending": ": activar para Ordendar Descendentemente"
                }
            }
        };
        return obj;
    }


    static paramsDataTableSelect(length = 15, url = "", method = "POST", data = {}, columns = [], msgTablaVacia = "No hay registros agregados.")
    {
        const obj = {
            "dom"       : '<"pull-left"f><"pull-right"l>tip',
            "responsive": false,
            "searching" : true,
            "paging"    : true,
            "lengthMenu": [[length],[length]],
            "ordering"  : false,
            "info"      : true,
            "processing": true,
            "serverSide": true,
            "ajax"      : {
                "url" : url,
                "type": method,
                "data": data
            },
            "columnDefs": columns,

            "select": {
                // "style":    'os',
                "style":    'multi',
                "selector": 'td:first-child'
            },

            "order": [[ 1, 'asc' ]],
            
            "bJQueryUI" : true,
            "oLanguage" : {
                "sEmptyTable"    : msgTablaVacia,
                "sInfo"          : "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
                "sInfoEmpty"     : "Mostrando desde 0 hasta 0 de 0 registros",
                "sInfoFiltered"  : "(filtrado de _MAX_ registros en total)",
                "sInfoPostFix"   : "",
                "sInfoThousands" : ",",
                "sLengthMenu"    : "Mostrar _MENU_ registros",
                "sLoadingRecords": "Cargando...",
                "sProcessing"    : "Procesando...",
                "sSearch"        : "Buscar:",
                "sZeroRecords"   : "No se encontraron resultados",
                "oPaginate"      : {
                    "sFirst"   : "Primero",
                    "sLast"    : "Último",
                    "sNext"    : "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending" : ": activar para Ordenar Ascendentemente",
                    "sSortDescending": ": activar para Ordendar Descendentemente"
                }
            }
        };
        return obj;
    }


    static SpanishDataTable(msgTablaVacia = "No hay registros agregados.")
    {
        const obj = {
            "sEmptyTable": msgTablaVacia,
            "sInfo": "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando desde 0 hasta 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
            "sInfoPostFix": "",
            "sInfoThousands": ",",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sLoadingRecords": "Cargando...",
            "sProcessing": "Procesando...",
            "sSearch": "Buscar:",
            "sZeroRecords": "No se encontraron resultados",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": activar para Ordenar Ascendentemente",
                "sSortDescending": ": activar para Ordendar Descendentemente"
            }
        };
        return obj;
    }


    static create_tab(titulo, url)
    {
        let Jq;
        let existe;
        if(top.location!==self.location){
            Jq = window.top.$; 
        } else {
            Jq = $;
        }
        let id = url;
        id = id.replace('./', '').replace(/["&'./:=?[\]]/gi, '-').replace(/(--)/gi, '');

        if (existe = Jq('.iframe-mode .navbar-nav').find('#tab-' + id).length > 0) {
            window.top.iFrameInstance.switchTab('#tab-'+id);
        } else {
            window.top.iFrameInstance.createTab(titulo, url, id, true);
        }
    }


    static msgInfo({target, tipo = 'primary', mensaje = ''})
    {
        $('#'+target).css("display", "block");
        let $html = `<blockquote class="quote-${tipo}">
                    <p>${mensaje}</p>
                </blockquote>`;
        $('#'+target).html($html);
    }

    static loading(message)
    {   
        message = (typeof message === 'undefined') ? "Cargando..." : message ;
        $("body").loading({
            stoppable: false,
            message: message,
            theme: "dark",
            zIndex: 9999
        });
    }
}

