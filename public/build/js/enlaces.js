document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('#navmenu a');

    links.forEach(link => {
        link.addEventListener('click', function(event) {
            const target = link.getAttribute('data-target');
            const externalHref = link.getAttribute('data-external');
            const internalHref = link.getAttribute('href');
            
            if (target === 'internal') {
                event.preventDefault();
                const element = document.querySelector(internalHref);
                if (element) {
                    const offsetTop = element.offsetTop;

                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                } else {
                    window.location.href = externalHref;
                }
            } else {
                // Enlace externo: permitir la navegación predeterminada
                window.location.href = externalHref;
            }
        });
    });
});