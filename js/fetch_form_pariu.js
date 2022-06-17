window.onload = function() {
    var form = document.querySelector("form");
    form.addEventListener("submit", sendData);


};

function sendData(e) {
    console.log("1");
    formulare = document.getElementsByClassName("formular");
    for (i = 0; i < formulare.length; i++) {
        var f = formulare[i];
        f.onclick = function() {
            console.log(this.childNodes);
        }
    }
    const fd = new FormData();
    e.preventDefault();
    sub = document.getElementById("submit").value;
    fd.append("id-pisica", document.getElementById("id-pisica").value);
    fd.append("id-cursa", document.getElementById("id-cursa").value);
    fd.append("suma", document.getElementById("suma").value)
    fd.append("submit", document.getElementById("submit").value);
    fetch("http://localhost/php/pariu_insert.php", {
            method: "POST",
            body: fd,
        })
        .then((response) => response.text())
        .then((data) => {
            console.log(data);
            var alerturi = document.getElementsByClassName("alert");
            for (let a of alerturi) {
                a.remove();
            }
            var alert = document.createElement("div");
            var tokens = data.split("|");
            alert.setAttribute("class", "alert " + tokens[1]);
            alert.innerHTML = tokens[0];
            var body = document.getElementsByTagName("body")[0];
            body.prepend(alert);
            window.scrollTo(0, 0);
        })
}