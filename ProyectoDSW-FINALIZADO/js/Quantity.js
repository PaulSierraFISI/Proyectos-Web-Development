const btnDecrease = document.querySelector(".decrease");
const btnIncrease = document.querySelector(".increase");
const quantity = document.getElementById("number");
let number = 1;
btnDecrease.addEventListener("click", () => {
	number--;
	console.log(number);
	if (number >= 1) {
		quantity.innerHTML = number;
	} else {
		quantity.innerHTML = "1";
		number = 1;
	}
});
btnIncrease.addEventListener("click", () => {
	number++;
	console.log(number);
	quantity.innerHTML = number;
});
