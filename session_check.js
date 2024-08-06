window.addEventListener('beforeunload', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'logout.php', false); // Solicitud sincrónica para cerrar sesión
    xhr.send();
});
