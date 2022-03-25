'use strict';
// php -S localhost:8000 ne 8080 megt összezararodik
const callBox = document.querySelector(".calling-box");
const acceptCallBtn = document.querySelector(".acceptCallBtn");
const declineCallBtn = document.querySelector(".declineCallBtn");
const declineCall = document.querySelector(".decline-call");
const hangupBtn = document.querySelector(".call-ending");

const mic =document.querySelector(".mic");
const cam =document.querySelector(".cam");

let micClick=false;
let camClick=false;

const mediaConst = {
    audio: true,
    video: true
}
const options ={
    offerToReceiveVideo:1
}
let pc;
let localStream;
function getConn(){
    if(!pc){
        pc = new RTCPeerConnection();
    }
}
async function getCam(){
    let MediaStream;

    try{
        if(!pc){
            await getConn();
        }
        MediaStream = await navigator.mediaDevices.getUserMedia(mediaConst);
        localVideoCam.srcObject= MediaStream;
        localStream = MediaStream;
        localStream.getTracks().forEach(element => pc.addTrack(element, localStream));      
    }catch(error){
        console.log(error)
    }  
}
const messages = document.querySelector(".messages");
let token = document.querySelector("#token");
var conn = new WebSocket('ws://localhost:8080/?token='+token.value);

conn.onopen = function(e) {
    console.log("Connection established!");
};
conn.onmessage = async e => {
    let message = JSON.parse(e.data);
    let messageSendTo = message.sendTo;
    let by = message.by;
    let data = message.data;
    let type = message.type;
    let profileImage = message.profileImage;
    let username =message.username;

    callBox.children[1].children[0].children[0].setAttribute("src",profileImage);
    callBox.children[1].children[0].children[1].children[0].innerHTML=username;
    callBox.children[1].children[1].children[0].setAttribute("data-user",by);

    if(sendTo  === undefined || sendTo == ""){
        sendTo=by;
    }
    console.log(sendTo)
    switch(type){
        case 'client-candidate':
            if(pc.localDescription){
                await pc.addIceCandidate( new RTCIceCandidate(data));
            }
        break;
        case 'is-client-ready':
            if(!pc){
                await getConn();
            }
            if(pc.iceConnectionState == "connected"){
                send('client-already-oncall');
            }else{
                messages.style.webkitFilter = "blur(4px)";
                callBox.classList.add("d-flex");
                callBox.classList.remove("d-none");
                declineCallBtn.addEventListener("click", () => {
                    send('client-rejected',null,by);
                    location.reload(true);
                    messages.style.webkitFilter = "blur(0px)";
                });
                acceptCallBtn.addEventListener("click",() => {
                    callBox.classList.add("d-none");
                    callBox.classList.remove("d-flex");
                    send('client-is-ready',null,by);
                    messages.style.webkitFilter = "blur(0px)";
                });
            }
        break;
        case 'client-answer':
            if(pc.localDescription){
                await pc.setRemoteDescription(data);
            }
        break;
        case 'client-offer':
            createAnswer(by,data);
        break;
        case 'client-is-ready':
            createOffer(by);
        break;
        case 'client-already-oncall':
            setTimeout('window.location.reload(true)',2000)
        break;
        case 'hang-up':
            setTimeout('window.location.reload(true)',2000)
        break;
        case 'client-rejected':
            messages.style.webkitFilter = "blur(4px)";
                callBox.classList.add("d-flex");
                callBox.classList.remove("d-none");
                acceptCallBtn.style.display = "none";
                declineCall.classList.remove("d-none");
                declineCallBtn.addEventListener("click", () => {
                    messages.style.webkitFilter = "blur(0px)";
                    acceptCallBtn.style.display = "block";
                    callBox.classList.add("d-none");
                    declineCall.classList.add("d-none");
                });
        break;
        
    }
};
function send(type,data,sendTo){
    conn.send(JSON.stringify({
        sendTo:sendTo,
        type:type,
        data:data
    }))
}
 async function createOffer(sendTo){
    await sendIceCandidate(sendTo);
    await pc.createOffer(options);
    await pc.setLocalDescription(pc.localDescription);
    send('client-offer',pc.localDescription,sendTo);
 }
 async function createAnswer(sendTo,data){
    if(!pc){
        getConn();
    } 
    if(!localStream){
        await getCam();
    }
    await sendIceCandidate(sendTo);
    await pc.setRemoteDescription(data);
    await pc.createAnswer();
    await pc.setLocalDescription(pc.localDescription);
    send('client-answer', pc.localDescription,sendTo)
 }
 function sendIceCandidate(sendTo){
    pc.onicecandidate = function(event) {
        if(event.candidate !== null ){
            send("client-candidate",event.candidate,sendTo);
        }
    }
    pc.ontrack = function(event){
        const VideoCallSection = document.querySelector(".videoCall");
        VideoCallSection.classList.remove("d-none");
        remoteVideoCam.srcObject = event.streams[0];
    }
}
function hangup(){
    send('client-hangup',null,sendTo);
    pc.close();
    pc=null;
}
hangupBtn.addEventListener("click", function(){
    hangup();
    location.reload(true);
});

mic.addEventListener("click", function(){
    if(micClick==false){
        mic.children[0].classList.add("d-none");
        mic.children[1].classList.remove("d-none");
        micClick=true;        
    }else{
        mic.children[0].classList.remove("d-none");
        mic.children[1].classList.add("d-none");

        micClick=false;
    }
});

cam.addEventListener("click", function(){
    if(camClick==false){
        cam.children[0].classList.add("d-none");
        cam.children[1].classList.remove("d-none");

        camClick=true;
    }else{
        cam.children[0].classList.remove("d-none");
        cam.children[1].classList.add("d-none");

        camClick=false;
    }
});