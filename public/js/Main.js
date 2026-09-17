const utilities = new Utilities();

const logOutSession = document.querySelector("#LogOutSession");

logOutSession?.addEventListener('click', (e) => {
    // let tipo = logOutSession.dataset.tipo;
    utilities.closeSession();
});


/* function loading(message)
{   
    message = (typeof message === 'undefined') ? "Cargando..." : message ;
    $("body").loading({
        stoppable: false,
        message: message,
        theme: "dark",
        zIndex: 9999
    });
} */
