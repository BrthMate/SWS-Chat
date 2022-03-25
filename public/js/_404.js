let DarkMode = localStorage.getItem("darkMode");
const container = document.querySelector("#container");

const enableDarkMode = () =>{
    document.body.classList.add('darkmode');
    container.classList.add('bg-dark','text-light');
    localStorage.setItem('darkMode',"enabled");
};
const disenableDarkMode = () =>{
    document.body.classList.remove('darkmode');
    container.classList.remove('bg-dark','text-light');
    localStorage.setItem('darkMode',null);
};
if(DarkMode =="enabled"){
    enableDarkMode();
}else{
    disenableDarkMode();
}
document.body.onmousemove = function(e) {
  /* 15 = background-size/2 */
  container.style.setProperty('background-position',(e.clientX - 15)+'px '+(e.clientY - 15)+'px');
}