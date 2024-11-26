document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.querySelectorAll("nav a");
    const formContainer = document.getElementById("form-container");
    const dataContainer = document.getElementById("data-container");

    
    navLinks.forEach(link => {
        link.addEventListener("click", async (e) => {
            e.preventDefault();
            const table = e.target.dataset.table;

            if (table) {
                try {
                    seleccionada
                    const response = await fetch(`getForm.php?table=${table}`);
                    if (!response.ok) {
                        throw new Error('No se pudo cargar el formulario');
                    }
                    const html = await response.text();
                    formContainer.innerHTML = html;
                    loadTableData(table); 
                } catch (error) {
                    console.error('Error al cargar el formulario:', error);
                    formContainer.innerHTML = "<p>Error al cargar el formulario. Intenta de nuevo.</p>";
                }
            }
        });
    });

    
    async function loadTableData(table) {
        try {
            const response = await fetch(`getData.php?table=${table}`);
            if (!response.ok) {
                throw new Error('No se pudieron cargar los datos');
            }
            const data = await response.json();
            let html = `<h2>Datos de ${table}</h2><table class="table"><thead><tr>`;

          
            if (data.length > 0) {
                Object.keys(data[0]).forEach(key => {
                    html += `<th>${key}</th>`;
                });
                html += "</tr></thead><tbody>";

             
                data.forEach(row => {
                    html += "<tr>";
                    Object.values(row).forEach(value => {
                        html += `<td>${value}</td>`;
                    });
                    html += "</tr>";
                });
                html += "</tbody></table>";
            } else {
                html += "<tr><td colspan='100%'>No hay datos disponibles.</td></tr></table>";
            }
            dataContainer.innerHTML = html;
        } catch (error) {
            console.error('Error al cargar los datos:', error);
            dataContainer.innerHTML = "<p>Error al cargar los datos. Intenta de nuevo.</p>";
        }
    }
});
