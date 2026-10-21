document.addEventListener('DOMContentLoaded', function(){
    //alert('dede buscador');
    iniciarApp();
});


function iniciarApp(){
    buscarPorFecha();
}

function buscarPorFecha(){
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', function(e){
        
        const fechaSeleccionada = e.target.value;
        console.log(fechaSeleccionada);
        window.location = `?fecha = ${fechaSeleccionada}`;
    });
}