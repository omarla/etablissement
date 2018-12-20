/*
    Fonction qui s'occupe de tous les resize
*/

$("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
    correctResize();
})

function correctResize() {
    console.log("My new Width is : " + window.innerWidth);


    if ($("#wrapper").hasClass("toggled")) {
        let width = window.innerWidth;
        $("#page-content-wrapper").css('max-width', (width - 250) + 'px');
    } else {
        $("#page-content-wrapper").css('max-width', '100%');
    }
}
window.onresize = correctResize;
window.onload = correctResize;

