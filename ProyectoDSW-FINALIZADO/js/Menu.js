const menuBtn = document.querySelector(".menuBtn");
const navigation = document.querySelector(".navigation");

menuBtn.addEventListener("click", () => {
	navigation.classList.toggle("show");
});
