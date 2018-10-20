function fadeOut(el){
	var elem = document.getElementById(el);
	elem.style.transition = "opacity 0.5s linear 0s";
	elem.style.opacity = 0;
}
function fadeIn(el){
	var elem = document.getElementById(el);
	elem.style.transition = "opacity 0.5s linear 0s";
	elem.style.opacity = 1;
}