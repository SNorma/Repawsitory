window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}

/* REPAW Fly In */

$(function() {
    setTimeout(function() {
        $('.fly-in-text').removeClass('hidden');
    }, 200);
})();