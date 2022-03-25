const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');
const forgetPassword = document.getElementById('forget-password');
const button = document.getElementById('sign-in-button');
const passwordField =  document.getElementById('sign-in-password');
const passwordFieldSignUp =  document.getElementById('sign-up-password');
const showSignIn = document.querySelector(".show-eye");
const showSignUp = document.querySelector(".show-eye-sign-up");
const hideSignIn = document.querySelector(".hide-eye"); 
const hideSignUp = document.querySelector(".hide-eye-sign-up"); 
const passwordFieldContainer = document.querySelector(".eyes"); 
let Mode = localStorage.getItem("registMode");

let forget = false;
  
function getURL() {
	let = url = window.location.href.replace("http://","");
	return (url.substring(url.indexOf('/')));

}
const enableRegistMode = () =>{
	container.classList.add("right-panel-active");
    localStorage.setItem('registMode',"enabled");
};
const enabledForgetMode = () =>{
    localStorage.setItem('registMode',"forgetMode");
	forgetPasswordActive();
};
const disabledForgetMode = () =>{
    localStorage.setItem('registMode',"forgetModeDisabled");
	forgetPasswordDeactive();
};
const disenableRegistMode = () =>{
	container.classList.remove("right-panel-active");
    localStorage.setItem('registMode',null);
};

if(getURL() == "/"){
	Mode = null;
}else if(getURL()=="/regist"){
	Mode = "enabled";
}else{
	Mode = "forgetMode";
}

if(Mode =="enabled"){
    enableRegistMode();
}else if(Mode =="forgetMode"){
    enabledForgetMode();
}else if(Mode =="forgetModeDisabled"){
    disabledForgetMode();
}
else{
    disenableRegistMode();
}

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
	enableRegistMode();
});
signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
	disenableRegistMode();
});
function forgetPasswordActive(){
	passwordFieldContainer.style.display = "none";
	forget = true;
	button.setAttribute("name","forgetEmail");
	button.innerHTML = "Send";
	forgetPassword.innerHTML = "Back to sign in";
	forgetPassword.classList.add("btn_fpass");
	forgetPassword.classList.remove("btn_login");
};
function forgetPasswordDeactive(){
	passwordFieldContainer.style.display = "flex";
	forget = false;
	button.setAttribute("name","login");
	button.innerHTML = "Sign in";
	forgetPassword.innerHTML = "Forgot your password?";
	forgetPassword.classList.remove("btn_fpass");
	forgetPassword.classList.add("btn_login");
}
forgetPassword.addEventListener("click",() => {
    if(!forget){
        forgetPasswordActive();
		enabledForgetMode();
    }else{
		forgetPasswordDeactive() 
		disabledForgetMode();
    }
});
showSignIn.addEventListener("click",() => {
	passwordField.type = "text";
	hideSignIn.style.display = "flex";
	showSignIn.style.display = "none";	
});
hideSignIn.addEventListener("click",() => {
	passwordField.type = "password";
	hideSignIn.style.display = "none";
	showSignIn.style.display = "flex";
});
showSignUp.addEventListener("click",() => {
	passwordFieldSignUp.type = "text";
	hideSignUp.style.display = "flex";
	showSignUp.style.display = "none";	
});
hideSignUp.addEventListener("click",() => {
	passwordFieldSignUp.type = "password";
	hideSignUp.style.display = "none";
	showSignUp.style.display = "flex";
});

$(document).ready(function($)
{
	var page_url = '';

	$(document).on('click', '.btn_regist', function(event)
	{
		event.preventDefault();
		page_url="/regist";
		window.history.pushState("", "", page_url);
		window.history.pushState("", "", page_url);
	});

	$(document).on('click', '.btn_login', function(event)
	{
		event.preventDefault();
		page_url="/";
		forgetPasswordDeactive();
		window.history.pushState("", "", page_url);
	});
	$(document).on('click', '.btn_fpass', function(event)
	{
		event.preventDefault();
		page_url="/forget";
		window.history.pushState("", "", page_url);
	});

});

