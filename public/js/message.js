let DarkMode = localStorage.getItem("darkMode");
const darkModeToggle = document.querySelector(".changeMode");
const bar = document.querySelector("#offcanvasNavbar");
const container = document.querySelector("#container");
const elements = document.getElementsByClassName("modal-content");
const modalbtn = document.getElementsByClassName("modal-btn");
const formcontrol = document.getElementsByClassName("form-control");
const sendFrom =  document.querySelector('#sendForm');
const row = document.querySelector('.row');
const calling = document.querySelector(".calling")

const searchInput = document.querySelector("#search-input");
const sendInput = document.querySelector("#send-input");
const sendBtn = document.querySelector("#send-btn");


const remoteVideoCam = document.querySelector("#remoteVideo");
const localVideoCam = document.querySelector("#localVideo");

let GetUserId = null;
let variable = null;
let scrollHeight;

function darkModel(){
    Array.from(elements).forEach(function(element) {
        element.classList.add('bg-dark');
    });
    Array.from(modalbtn).forEach(function(element) {
        element.classList.add('text-dark');
    });
    Array.from(formcontrol).forEach(function(element) {
        element.classList.add('bg-dark',"text-light");
    });
}
function lightModel(){
    Array.from(elements).forEach(function(element) {
        element.classList.remove('bg-dark');
    });
    Array.from(modalbtn).forEach(function(element) {
        element.classList.remove('text-dark');
    });
    Array.from(formcontrol).forEach(function(element) {
        element.classList.remove('bg-dark',"text-light");
    });
}
const enableDarkMode = () =>{
    document.body.classList.add('darkmode');
    bar.classList.add('bg-dark');
    container.classList.add('bg-dark','text-light');
    bar.classList.add('text-light');
    localStorage.setItem('darkMode',"enabled");
    calling.classList.add("darkmode");
};
const disenableDarkMode = () =>{
    document.body.classList.remove('darkmode');
    calling.classList.remove("darkmode");
    bar.classList.remove('bg-dark');
    container.classList.remove('bg-dark','text-light');
    bar.classList.remove('text-light');
    localStorage.setItem('darkMode',null);
};
darkModeToggle.addEventListener("click",()=>{
    DarkMode = localStorage.getItem("darkMode")
    if(DarkMode != "enabled"){
        enableDarkMode();
        darkModel();
    }else{
        disenableDarkMode();
        lightModel();
    }
});
if(DarkMode =="enabled"){
    enableDarkMode();
    darkModel();
}else{
    disenableDarkMode();
    lightModel();
}
function messageContent(){
    const messageContent = document.querySelector('.box-content');

    messageContent.addEventListener('click', () => {
        row.classList.remove("right-panel-active");
        scrollHeight = 0;
    });
}
function messageBoxs(element){
    element.path.forEach((element,index)=>{
        document.querySelector(".card-body-conatiner").classList.add("card");
        if( String(element).includes('a')){
            variable = element.getAttribute("href");
            if(variable != null){
                ajaxChat(variable);
            }
           
        }
    });
    let width = window.innerWidth;
    if(width < 575){
	    row.classList.add("right-panel-active");
    }
};
let UserId;

function userId(data){
    UserId=data;
}
$(document).ready(function($)
{
	var page_url = '';

	$(document).on('click', '.user-id', function(event)
	{
		event.preventDefault();
		page_url="message?usercode="+UserId;
		window.history.pushState("", "", page_url);
		window.history.pushState("", "", page_url);
	});
});

const usersList = document.querySelector(".users-box-list");

searchInput.addEventListener('keyup', () => {
    let search = searchInput.value;
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "../message-ajax-search?search=" + search, true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if (data==""){
                    usersList.innerHTML='<div class="mt-3"><div class="w-100">Nincs Találat!</div></div>';
                }else{
                    usersList.innerHTML = data;
                }

                const ContactUser = document.querySelectorAll(".contact-user");
                const SearchedUser = document.querySelectorAll(".searched-user");
                const messageBox = document.getElementsByClassName('box');
                
                Array.from(messageBox).forEach(function(element) {
                    element.addEventListener('click', messageBoxs);
                });

                if(search == ""){
                    ContactUser.forEach(element => {
                        element.classList.add("active");
                    });
                    SearchedUser.forEach(element => {
                        element.classList.remove("active");
                    });
                }
                else{
                    ContactUser.forEach(element => {
                        element.classList.remove("active");
                    });
                    SearchedUser.forEach(element => {
                        element.classList.add("active");
                    });
                }
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();
});

setInterval(()=>{
    let search = searchInput.value;
    if(search == ""){
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "../message-ajax-default", true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    if (data==""){
                        usersList.innerHTML='<div class="mt-3"><div class="w-100">Nincs Találat!</div></div>';
                    }else{
                        usersList.innerHTML = data;
                    }

                    const ContactUser = document.querySelectorAll(".contact-user");
                    const SearchedUser = document.querySelectorAll(".searched-user");
                    const messageBox = document.getElementsByClassName('box');
                    
                    Array.from(messageBox).forEach(function(element) {
                        element.addEventListener('click', messageBoxs);
                    });
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send();
    }
},1000);

const navBar = document.querySelector(".navbar-nav");

setInterval(()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "../message-ajax-unread", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if (data != ""){
                    navBar.innerHTML = data;
                }
                const ContactUser = document.querySelectorAll(".contact-user");
                const SearchedUser = document.querySelectorAll(".searched-user");
                const messageBox = document.getElementsByClassName('box');
                
                Array.from(messageBox).forEach(function(element) {
                    element.addEventListener('click', messageBoxs);
                });
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();

},1000);

const messageContentBox = document.querySelector(".message-box");

function SelectMessages(){
    if(GetUserId != null){
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "../message-ajax-chat?userId=" + GetUserId , true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    if (data != ""){
                        messageContentBox.innerHTML = data;
                        sendFrom.classList.add("d-flex");
                        document.querySelector("#send-text-container").classList.add("d-flex");
                        const messageContentDiv = document.querySelector(".message-content");
                        messageContentDiv.addEventListener("scroll", event => {
                            scrollHeight=messageContentDiv.scrollTop;                  
                        }, { passive: true });
                        messageContentDiv.scrollTo(0,scrollHeight);
                    }
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send();
    }
};
setInterval(SelectMessages,1000);

const cardBody = document.querySelector('.card-body');
let sendTo;
function ajaxChat(url){
    GetUserId=(url.substring(url.indexOf('=')+1));
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "../message-ajax-chatuser?userId=" + GetUserId , true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if (data != ""){
                    cardBody.innerHTML = data;
                    SelectMessages();
                    messageContent();
                    const videocall=document.querySelector("#videoCall");
                    sendTo = videocall.dataset.user;
                    if(videocall){
                        videocall.addEventListener("click",getCam);
                        videocall.addEventListener("click", () => {send("is-client-ready", null,sendTo)});
                    }
                }
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();
}
sendBtn.addEventListener("click",() => {
    if(variable != null){
        GetUserId=(variable.substring(variable.indexOf('=')+1));
    }
    if(sendInput.value != "" || upload.files.length != 0){

        document.getElementById('send-input-hidden').value = sendInput.value;
        document.getElementById('userId-input-hidden').value = GetUserId;
        const sendFromClick =  document.querySelector('#sendForm');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../message-ajax-sendmessage", true);
 
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    if (data != ""){
                        sendInput.value="";
                        upload.value="";
                    }
                }
            }
        }
        //xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        let formData = new FormData(sendFromClick);
        xhr.send(formData);
    }
});
document.getElementById('sendForm').addEventListener('submit', function(e) {
    e.preventDefault();
}, false);

sendInput.addEventListener("keyup",(event) => {
    if(variable != null){
        GetUserId=(variable.substring(variable.indexOf('=')+1));
    }
    if((event.keyCode === 13 && upload.files.length != 0)||(event.keyCode === 13 && sendInput.value != "")){
        document.getElementById('send-input-hidden').value = sendInput.value;
        document.getElementById('userId-input-hidden').value = GetUserId;
        const sendFromClick =  document.querySelector('#sendForm');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../message-ajax-sendmessage", true);
 
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    if (data != ""){
                        sendInput.value="";
                        upload.value="";
                    }
                }
            }
        }
        //xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        let formData = new FormData(sendFromClick);
        xhr.send(formData);
    }
});

const changeData =document.getElementById("changeData");

changeData.addEventListener("click",() => {

    const sendFromClick =  document.querySelector('.updateData');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../message-ajax-updatedata", true);
 
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    if (data != ""){
                        console.log(data);
                    }
                }
            }
        }
        let formData = new FormData(sendFromClick);
        xhr.send(formData);
});

const upload = document.getElementById('fileid');
document.getElementById('buttonid').addEventListener('click', openDialog);

function openDialog() {
    upload.click();
    if( upload.files.length == 0 ){
        document.getElementById('uploadFileSvg').setAttribute("style","fill: var(--Black)");
    }else{
        document.getElementById('uploadFileSvg').setAttribute("style","fill: var(--SandyBrown)");
    }
}

var $upload  = $("#fileid");
$upload.change(openDialog);

const btnShow = document.querySelector("#show-buttons");
let click = false;

sendInput.addEventListener("focusout", function(){
    sendInput.classList.remove("inFocus");
    sendFrom.classList.remove("d-none");
    btnShow.classList.add("d-none");
});
sendInput.addEventListener("focus", function(){
        sendInput.classList.add("inFocus");
        sendFrom.classList.add("d-none");
        btnShow.classList.remove("d-none");
});
btnShow.addEventListener("click", function(){
    if(click){
        sendInput.classList.remove("inFocus");
        sendFrom.classList.remove("d-none");
        btnShow.classList.add("d-none");
        click=false;
    }else{
        sendInput.classList.add("inFocus");
        sendFrom.classList.add("d-none");
        btnShow.classList.remove("d-none");
        click= true;
    }
});