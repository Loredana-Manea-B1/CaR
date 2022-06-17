window.onload() = function() {
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
};