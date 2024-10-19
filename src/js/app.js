document.addEventListener('DOMContentLoaded', function() {
    eventListeners();

    darkMode();
});

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponive);

    // Mostrar campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');
    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto));
};

function navegacionResponive() {
    const navegacion = document.querySelector('.navegacion');

    // if(navegacion.classList.contains('mostrar')) {
    //     navegacion.classList.remove('mostrar');
    // }
    // else {
    //     navegacion.classList.add('mostrar');
    // }

    navegacion.classList.toggle('mostrar');
}

function darkMode() {

    //variable con key-valor
    const darkLocal = window.localStorage;
    //preferencia del sistema
    const preferenciaDark = window.matchMedia('(prefers-color-scheme:dark)');
    
    //si no existe la key
    if(darkLocal.getItem('oscuro') == null) {
        if(preferenciaDark.matches) {
            darkLocal.setItem('oscuro', 'true');
            document.body.classList.add('dark-mode');
        }
        else {
            darkLocal.setItem('oscuro', 'false');
            document.body.classList.remove('dark-mode');
        }
    }

    //si existe
    else {
        if(darkLocal.getItem('oscuro') === 'true') {
            document.body.classList.add('dark-mode');
        }
        else {
            document.body.classList.remove('dark-mode');
        }
    }

    //escuchar cambios
    preferenciaDark.addEventListener('change', () => {
        if(preferenciaDark.matches) {
            darkLocal.setItem('oscuro', 'true');
            document.body.classList.add('dark-mode');
        }
        else {
            darkLocal.setItem('oscuro', 'false');
            document.body.classList.remove('dark-mode');
        }
    });

    const botonDarkMode = document.querySelector('.dark-mode-boton');

    //cambio con los botones
    botonDarkMode.addEventListener('click', () => {
        if(document.body.classList.contains('dark-mode')) {
            darkLocal.setItem('oscuro', 'false');
            document.body.classList.remove('dark-mode');
        }

        else {
            darkLocal.setItem('oscuro', 'true');
            document.body.classList.add('dark-mode');
        }
    });
};

function mostrarMetodosContacto(e) {
    console.log(e);
    const contactoDiv = document.querySelector('#contacto');

    if(e.target.value === 'telefono') {
        contactoDiv.innerHTML = `
            <label for="telefono">Número de Teléfono</label>
            <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]" required></input>

            <p>Elija la fecha y hora para la llamada</p>

            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]"></input>
        `;
    } else {
        contactoDiv.innerHTML = `
            <label for="email">E-mail</label>
            <input type="email" placeholder="Tu Correo" id="email" name="contacto[email]" required>
        `;
    }
}