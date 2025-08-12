Loggedin = false;
if (!Loggedin) {
  document.getElementById("navProfilePic").innerHTML =
    '<a href="login.html">Login</a>';
}
document.getElementById("logo").addEventListener("click", () => {
  window.location.href = "index.html";
});
