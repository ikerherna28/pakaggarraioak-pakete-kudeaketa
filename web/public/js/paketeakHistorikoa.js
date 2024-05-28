        // Adibide bezala datuak simulatu
        const packagesWithIncidence = [
            { id: '001', description: 'Elektrodomestikoa', dimensions: '50x40x30 cm', incidenceId: 'INC001', incidence: 'Babeslea suntsituta', incidenceDate: '2024-05-01', solved: false },
            { id: '002', description: 'Liburuak', dimensions: '30x20x20 cm', incidenceId: 'INC002', incidence: 'Entregatze atzerakada', incidenceDate: '2024-05-05', solved: true },
            { id: '003', description: 'Arropa', dimensions: '20x15x10 cm', incidenceId: 'INC003', incidence: 'Produktua suntsituta', incidenceDate: '2024-05-10', solved: false }
        ];

        const packagesWithoutIncidence = [
            { id: '004', description: 'Elektronika', dimensions: '40x30x20 cm' },
            { id: '005', description: 'Jostailuak', dimensions: '25x20x15 cm' },
            { id: '006', description: 'Tresnak', dimensions: '35x25x15 cm' }
        ];

        // Intzidentziadun paketeak kargatzeko funtzioa
        function loadPackagesWithIncidence() {
            const tableBody = document.getElementById('incidence-packages').querySelector('tbody');

            packagesWithIncidence.forEach(package => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${package.id}</td>
                    <td>${package.description}</td>
                    <td>${package.dimensions}</td>
                    <td>${package.incidenceId}</td>
                    <td>${package.incidence}</td>
                    <td>${package.incidenceDate}</td>
                    <td>${package.solved ? 'Bai' : '<span class="incomplete">Ez</span>'}</td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Intzidentziarik gabeko paketeak kargatzeko funtzioa
        function loadPackagesWithoutIncidence() {
            const tableBody = document.getElementById('no-incidence-packages').querySelector('tbody');

            packagesWithoutIncidence.forEach(package => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${package.id}</td>
                    <td>${package.description}</td>
                    <td>${package.dimensions}</td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Paketeak intzidentziarekin eta intzidentziarik gabe kargatzeko orrialdea kargatzerakoan
        window.onload = function() {
            loadPackagesWithIncidence();
            loadPackagesWithoutIncidence();
        };