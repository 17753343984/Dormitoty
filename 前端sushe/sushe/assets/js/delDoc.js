window.onload=function (){
    var doc = document.getElementsByClassName("DTTT")[0];
    console.log(doc);
    document.getElementsByClassName("DTTT")[0].style.display="none";
    document.getElementsByClassName("odd")[0].style.display="none";
}
function bedTransform(id) {
    var name;
    switch (id) {
        case 1:
            name = "A1"
            break;
        case 2:
            name = "A2"
            break;
        case 3:
            name = "B1"
            break;
        case 4:
            name = "B2"
            break;
        case 5:
            name = "C1"
            break;
        case 6:
            name = "C2"
            break;
        case 7:
            name = "D1"
            break;
        case 8:
            name = "D2"
            break;
        default:
            alert("床号异常")
    };
    return name;
}