let Partitura = {
  Partituras: [], // Lista de partituras
};

const populateProducts = (Partitura) => {
  const productContainer = document.getElementById("productos");
  if (productContainer) {
    productContainer.innerHTML = ""; // Limpiar productos previos

    Partitura.Partituras.forEach((partitura) => {
      let card = `
      <div class="card">
          <figure>
              <img class="active" src="../IMG/sol.png" alt="sol" />
          </figure>
          <div class="descripcion">
              <h3>${partitura.Nombre}</h3>
              <p>${partitura.Usuario_idUsuario || 'Usuario no disponible'}</p>
              <p>${partitura.Descripcion}</p>
              <div>
                  <a href="../Partituras/${partitura.archivoPDF}" download="${partitura.archivoPDF}" class="btn-card">Descargar PDF</a>
              </div>
          </div>
      </div>`;

      productContainer.innerHTML += card;
    });
  }
};

// Suponiendo que tienes una lista de datos llamada `partituraData` que contiene las partituras.
Partitura.Partituras = partituraData; // Asignar las partituras al objeto

// Llamar a la función para poblar el contenedor
populateProducts(Partitura);

console.log(Partitura);
