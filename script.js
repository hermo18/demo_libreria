
function ocultarResultadosAnteriores() {
    const resultadosDb = document.getElementById("resultados-db");
    const resultadosAlmacenados = document.getElementById("resultados-almacenados");
    resultadosDb.innerHTML = "";
    resultadosAlmacenados.innerHTML = "";
}


function buscarEnDB(query) {
    const resultados = document.getElementById("resultados-db");
    if (query.length > 0) {
        fetch(`buscar_db.php?query=${encodeURIComponent(query)}`)
            .then(response => response.text())
            .then(html => {
                resultados.innerHTML = html;
            })
            .catch(error => {
                console.error("Error al buscar en la base de datos:", error);
            });
    } else {
        resultados.innerHTML = "<p>Escribe para buscar en la base de datos.</p>";
    }
}


function ocultarLibrosAlmacenados() {
    const contenedor = document.getElementById("resultados-almacenados");
    contenedor.innerHTML = "";
}


function confirmarEliminacion(isbn) {
    return confirm(`¿Estás seguro de que quieres eliminar el libro con ISBN: ${isbn}?`);
}