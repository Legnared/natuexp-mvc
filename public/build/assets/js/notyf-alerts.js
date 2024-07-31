// Inicializar Notyf
const notyf = new Notyf({
    duration: 3000, // Duración de las alertas (opcional)
    ripple: true,   // Efecto ripple en las alertas (opcional)
    position: {
        x: 'right',
        y: 'top',
    }
});

// Función para mostrar las alertas desde PHP
function mostrarAlertas(alertas) {
    alertas.forEach(alerta => {
        const tipo = alerta.getAttribute('data-type');
        const mensaje = alerta.textContent.trim();
        notyf.open({
            type: tipo,
            message: mensaje
        });
    });
}

// Llamar a la función para mostrar las alertas cuando la página cargue
document.addEventListener('DOMContentLoaded', () => {
    const alertas = document.querySelectorAll('.notyf-alert');
    mostrarAlertas(alertas);
});
