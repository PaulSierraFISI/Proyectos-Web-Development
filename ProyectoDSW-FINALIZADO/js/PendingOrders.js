const filas = document.querySelectorAll(".fila");

filas.forEach((element) => {
	const btn = element.cells[6].childNodes[0];
	btn.addEventListener("click", () => {
		if (element.cells[4].innerHTML == "No Entregado") {
			element.cells[4].innerHTML = "Entregado";
		} else {
			element.cells[4].innerHTML = "No Entregado";
		}
	});
});
