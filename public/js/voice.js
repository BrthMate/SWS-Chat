const VoiceButton = document.querySelector("#voice-btn");
const textArea =  document.querySelector("#voiceArea");
const TextSendBtn = document.querySelector("#TextAreasendBtn");
const Status = document.querySelector(".voiceStatus");
let Isactive = false;

try {
    var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    var recognition = new SpeechRecognition();
}catch(e) {
    console.error(e);
}

let content = "";
recognition.continuous = true;

recognition.onstart = function(){
    Status.innerHTML ="voice on";
    document.querySelector("#voiceBtnSvg").setAttribute("style","fill: var(--SandyBrown)");
}
recognition.onspeechend = function(){
    Status.innerHTML ="no activity";
    TextSendBtn.click();
    textArea.value = "";
}
recognition.onerror = function(){
    Status.innerHTML ="Error";
    TextSendBtn.click();
    textArea.value = "";
}
recognition.onresult = function(event) {
    var current = event.resultIndex;
    var transcript =  event.results[current][0].transcript;
    content+= transcript;
    textArea.value = content;
    
}
function closeWindow(){
    sendInput.value = textArea.value;
    Isactive = false;
    recognition.stop();
    document.querySelector("#voiceBtnSvg").setAttribute("style","fill: var(--Black)");
    content = "";
}
VoiceButton.addEventListener("click", function(event){
    if(content.length){
        content+= ''
    }
    if(Isactive == false){
        Isactive = true;
        recognition.start();
    }
});

TextSendBtn.addEventListener("click", function(){
    closeWindow();
});