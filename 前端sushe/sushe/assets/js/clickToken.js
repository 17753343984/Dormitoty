window.onload=function (){

    var token = localStorage.getItem("token")
    var uid = localStorage.getItem("uid")
 
    if (token==null || uid==null)
    {
        alert("身份验证已过期，请重新登陆。")
        window.location.href="login.html";
    }
}