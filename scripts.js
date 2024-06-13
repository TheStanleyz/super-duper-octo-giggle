document.addEventListener("DOMContentLoaded", function () {
    // Função para carregar mesas salvas no banco de dados
    function carregarMesas() {
      fetch("server.php?action=get_mesas")
        .then((response) => response.json())
        .then((data) => {
          const mesasList = document.getElementById("mesas-list");
          const noMesasMessage = document.getElementById("no-mesas");
          if (mesasList) {
            mesasList.innerHTML = "";
            if (data.length === 0) {
              noMesasMessage.style.display = "block";
            } else {
              noMesasMessage.style.display = "none";
              data.forEach((mesa) => {
                const li = document.createElement("li");
                li.textContent = `${mesa.nome} - ${mesa.tags}`;
                mesasList.appendChild(li);
              });
            }
          }
        });
    }
  
    // Função para pesquisar mesas
    function pesquisarMesas(event) {
      const query = event.target.value.toLowerCase();
      fetch(`server.php?action=search_mesas&query=${query}`)
        .then((response) => response.json())
        .then((data) => {
          const searchResults = document.getElementById("search-results");
          if (searchResults) {
            searchResults.innerHTML = "";
            data.forEach((mesa) => {
              const li = document.createElement("li");
              li.innerHTML = `
                              <img src="${mesa.imagem}" alt="${mesa.nome}">
                              <div>
                                  <h3>${mesa.nome}</h3>
                                  <p>Tags: ${mesa.tags}</p>
                                  <p>Horário: ${mesa.horario_jogo}</p>
                                  <p>Descrição: ${mesa.descricao}</p>
                              </div>
                          `;
              searchResults.appendChild(li);
            });
          }
        });
    }
  
    // Carregar mesas na página de "Minhas Mesas"
    if (document.getElementById("mesas-list")) {
      carregarMesas();
    }
  
    // Adicionar evento ao campo de pesquisa
    if (document.getElementById("search-input")) {
      document
        .getElementById("search-input")
        .addEventListener("input", pesquisarMesas);
    }
  });