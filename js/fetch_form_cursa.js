window.onload = function() {
    var form = document.querySelector("form");
    form.addEventListener("submit", sendData);
};

function sendData(e) {
    const fd = new FormData();
    e.preventDefault();
    sub = document.getElementById("submit").value;
    fd.append("pisica1", document.getElementById("pisica1").value);
    fd.append("pisica2", document.getElementById("pisica2").value);
    fd.append("dcursa", document.getElementById("dcursa").value);
    fd.append("dlimita", document.getElementById("dlimita").value);
    fd.append("castigator", document.getElementById("castigator").value);
    fd.append("id", document.getElementById("id-input").value);
    fd.append("submit", document.getElementById("submit").value);
    fetch("http://localhost/php/curse_insert.php", {
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