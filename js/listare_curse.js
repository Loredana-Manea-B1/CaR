function dialog() {
    if (confirm("Esti sigur ca vrei sa stergi cursa?")) {
        delete_data(this.parentElement.parentElement);
    }
}


function delete_data(p) {
    parinte = document.getElementById("sterge");
    fetch(
            "http://localhost/php/curse_delete.php?id=" +
            p.childNodes[1].innerHTML, {
                method: "GET",
            }
        )
        .then((response) => response.text())
        .then((data) => {
            var alerturi = document.getElementsByClassName("alert");
            for (let a of alerturi) {
                a.remove();
            }
            var alert = document.createElement("div");
            var tokens = data.split("|");
            if (tokens[1] === "success") {
                p.remove();
            }
            alert.setAttribute("class", "alert " + tokens[1]);
            alert.innerHTML = tokens[0];
            var h = document.getElementsByTagName("h1")[0];
            h.prepend(alert);
            window.scrollTo(0, 0);
        });
}



window.onload = function() {
    var container = document.getElementById("lista_curse");
    var s = document.querySelectorAll(".sterge");
    for (i = 0; i < s.length; i++) {
        s[i].onclick = dialog;
    }
};