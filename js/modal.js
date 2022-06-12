var modal = document.getElementsByClassName("modal-plata")[0];

var btn = document.getElementsByClassName("concurent")[1];

var span = document.getElementsByClassName("close")[0];
span.onclick = function() {
    modal.style.display = "none";
}
btn.onclick = function() {
    modal.style.display = "flex";
    console.log("sal");
}