var modale = document.getElementsByClassName("modal-plata");

var i;


for (i = 0; i < modale.length; i++) {
    var modal = document.getElementsByClassName("modal-plata")[i];

    var btn = document.getElementsByClassName("concurent")[i];

    var span = document.getElementsByClassName("close")[i];
    span.onclick = function() {
        modal.style.display = "none";
    }
    btn.onclick = function() {
        modal.style.display = "flex";
        console.log("sal");
    }

}