
    // Populate the year dropdown dynamically
    const startYear = 2000;
    const endYear = new Date().getFullYear();
    const yearSelect = document.getElementById("yearSelect");

    for (let year = endYear; year >= startYear; year--) {
        let option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }
