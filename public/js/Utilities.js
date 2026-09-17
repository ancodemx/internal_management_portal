class Utilities {

    closeSession() 
    {
        Swal.fire({
            title: "Esta seguro de Cerrar Sesión?",
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonText: `Si`,
            customClass: {
                denyButton: 'mi-clase-denegar'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.clear();
                $.ajax({
                    url: URL_PATH + 'login/cerrar_sesion',
                    success: function(datos){
                        if ( datos.meta_data.session_on == false ) {
                            location.href = URL_PATH + 'login';
                        }
                    }
                });
            }
        });
    }


    static onlyNumbers(e)
    {
        var key = window.Event ? e.which : e.keyCode
        return (key >= 45 && key <= 57)
    }


    static number_format (number, decimals, dec_point, thousands_sep) 
    {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }


    // to call on javascript: const json = Utileria.convertFormToJSON(form_Client);
    static convertFormToJSON(form) 
    {
        const array = $(form).serializeArray(); // Encodes the set of form elements as an array of names and values.
        const json = {};
        
        $.each(array, function () {
            json[this.name] = this.value || "";
        });

        return json;
    }
    

    static convertURLtoID(url) 
    {
        // Reemplazar :// por -
        url = url.replace(/:\/\//g, '-');

        // Reemplazar / por -
        url = url.replace(/\//g, '-');

        // url = url.slice(0, -2);

        // Reemplazar los . por - ( por si la url tiene un punto o es una ip)
        url = url.replace(/\./g, '-');

        return url;
    }

}