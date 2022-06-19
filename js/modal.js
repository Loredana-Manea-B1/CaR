var modale = document.getElementsByClassName("modal-plata");
var butoane = document.getElementsByClassName("concurent");
var spanuri = document.getElementsByClassName("close");


for (i = 0; i < modale.length; i++) {

    var btn = butoane[i];
    var span = spanuri[i];
    var modal = modale[i];
    span.onclick = function() {
        this.parentElement.parentElement.style.display = "none";
    }
    btn.onclick = function() {
        var nume = this.childNodes[3].childNodes[1].childNodes[0].nodeValue;
        for (i = 0; i < modale.length; i++) {
            numem = modale[i].getAttribute("name");
            if (nume === numem) {
                modale[i].style.display = "flex";
                return;
            }
        };
    }


}