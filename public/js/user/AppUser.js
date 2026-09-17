import { User } from "./User.js";
import { UIUser } from "./UIUser.js";

let tableUsers;

$(document).ready(function () {

    /* window.addEventListener('message', function(event) {

        var data = JSON.parse(event.data);

        const option = {
            'success': (data) => {
                // configurar toastr
                
                toastr.success(data.msg);
                tableUsers.clear().draw();
                tableUsers.state.save();

                // Cerramos el tab editar
                if ( data.accion == 'editar' ){
                    
                    // Acceder al iframe hijo por su nombre o ID
                    let iframeHijo = window.parent.document.getElementById('editar-publicador');
                    iframeHijo.parentNode.remove(iframeHijo);

                    // Supongamos que iframeHijo.src contiene la URL completa
                    let url = iframeHijo.src;

                    // Encontrar la última ocurrencia del carácter '/'
                    let lastSlashIndex = url.lastIndexOf('/');

                    // Cortar la URL hasta la última ocurrencia del carácter '/'
                    let baseUrl = url.substring(0, lastSlashIndex);
                    
                    baseUrl = Utilerias.convertirURLaID(baseUrl);
                    
                    var iframeDestino = window.parent.document.getElementById("tab-" + baseUrl);
                    iframeDestino.parentNode.remove(iframeDestino);
                }
            }
        };

        const opcion = option[data.status] ? option[data.status](data) : '' ;
    }); */


    // --- INICIALIZAMOS DATATABLES
    const tableUsersParam = {
        length: 15,
        url: URL_PATH + CONTROLADOR + "/data_table_list",
        method: 'POST', // Tipo de petición
        data: {
            "token": TOKEN
        },
        columns: [
            {
                "targets": [0]
            },
            {
                "targets": [1]
            },
            {
                "targets": [2]
            },
            {
                "targets": [3]
            },
            {
                "width": "6%",
                "className": "text-center",
                "targets": [4],
                
            }
        ],
    };
    tableUsers = $('#gridUsers').DataTable(
        UI.paramsDataTable( 
            tableUsersParam.length, 
            tableUsersParam.url, 
            tableUsersParam.method,
            tableUsersParam.data, 
            tableUsersParam.columns
        )
    );

    let tableUsers_filter = $('#gridUsers').dataTable();

    let timeoutId;
    // El manejador del evento de entrada
    function handleInput(event) {
        const query = event.target.value;

        // Limpiar el temporizador anterior
        clearTimeout(timeoutId);

        // Configurar un nuevo temporizador
        timeoutId = setTimeout(() => {
            tableUsers_filter.fnFilter(query);
        }, 1000); // 1 segundo de retraso
    }

    // Añadir el evento de entrada al input
    document.getElementById('searchbox').addEventListener('input', handleInput);

});

document.getElementById('btn_nuevo').addEventListener('click', function(e) {
    UI.create_tab('Usuario', URL_PATH + 'user/create');
    // modal_form_user.show();
});

/* let modal_form_user = new bootstrap.Modal(document.getElementById("modal_form_user"), {
    backdrop: 'static',
    keyboard: false
}); */

document.getElementById('btn_actualizar').addEventListener('click', function(e) {
    location.href = URL_PATH + CONTROLADOR;
});


// --- Opciones
const opciones = {
    'info': (user_id) => {
        mostrar_info(user_id);
    },
    'editar': (user_id) => {
        
        setTimeout(function() {
            UI.create_tab('Editar Publicador', URL_PATH + 'publicador/editar');
            let iframeDestino = window.parent.document.getElementById("editar-publicador");
            let url = URL_PATH + CONTROLADOR + '/editar/' + user_id;
            // console.log(iframeDestino);
            iframeDestino.src = url;
        }, 1000);

    },
    'borrar': (user_id) => {

        bootbox.confirm({
            message: "Estás seguro de borrar este registro?",
            buttons: {
                confirm: {
                    label: 'Si'
                },
                cancel: {
                    label: 'No'
                }
            },
            callback: function (result) {
                if (result == true) {
                    
                    $.ajax({
                        url: URL_PATH + CONTROLADOR + '/borrar',
                        data: {
                            "id": user_id,
                            "TOKEN": TOKEN
                        },
                        type: "POST",
                    }).done( function(data) {

                        // var json_response = JSON.parse(data);

                        const opciones = {
                            'success': () => {
                                if ( data.error == false ){
                                    toastr.success(data.message)

                                    tableUsers.clear().draw();
                                    tableUsers.state.save();
                                }
                            },
                            'warning': () => {
                                toastr.warning(data.message);
                            },
                            'error': () => {
                                toastr.error(data.message);
                            }
                        }
                        const opcion_default = () => {
                            toastr.error("Se ha producido un error");
                        };
                        
                        const estatus = opciones[data.meta_data.alert_type] ? opciones[data.meta_data.alert_type]() : opcion_default();

                    }).always( function() {
                        
                    });
                }
            }
        });
    },
};
document.getElementById('gridUsers').addEventListener('click', function(e) {
    let user_id = e.target.getAttribute('data-user_id') ? e.target.getAttribute('data-user_id') : '';
    const opcion = opciones[e.target.name] ? opciones[e.target.name](user_id) : '';
});


/* let modal_info = new bootstrap.Modal(document.getElementById("modal_info"), {
    backdrop: 'static',
    keyboard: false
}); */


