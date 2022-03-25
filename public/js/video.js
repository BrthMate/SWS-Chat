const videoBox = document.querySelector(".videoCall")
const resize = document.querySelector(".resize")
const localVideo = document.querySelector("#localVideo");
const remoteVideo =  document.querySelector("#remoteVideo");

videoBox.addEventListener("mousedown", videoBoxmousedown);
resize.addEventListener("mousedown", resizemousedown);
 
let resizeing = false;

function videoBoxmousedown(e){

    window.addEventListener('mousemove',mousemove);
    window.addEventListener('mouseup',mouseup);

    let prevX = e.clientX;
    let prevY = e.clientY;

    function mousemove(e){
        if(!resizeing){
            let newX = prevX-e.clientX;
            let newY = prevY-e.clientY;

            const rect = videoBox.getBoundingClientRect();
            if(window.innerWidth-(rect.left - newX)-videoBox.offsetWidth < 10 ){
                videoBox.style.left = window.innerWidth-videoBox.offsetWidth - 10 + "px";          
            }
            else if (window.innerHeight-(rect.top - newY)-videoBox.offsetHeight < 10) {
                videoBox.style.top = window.innerHeight-videoBox.offsetHeight - 10 + "px"; 
            }
            else{
                if(rect.top - newY > 10){
                    videoBox.style.top = rect.top - newY + "px";
                }else{
                    videoBox.style.top = 10 + "px";
                }
                if(rect.left - newX > 10){
                    videoBox.style.left = rect.left - newX + "px";
                }else{
                    videoBox.style.left = 10 + "px";
                }
            }
            prevX = e.clientX;
            prevY = e.clientY;
        }
    }

    function mouseup(){
        window.removeEventListener('mousemove',mousemove);
        window.removeEventListener('mouseup', mouseup);
    }
}

function resizemousedown(e){
    let prevX = e.clientX;
    let prevY = e.clientY;    
    resizeing = true;
    window.addEventListener('mousemove',mousemove);
    window.addEventListener('mouseup',mouseup);

    function mousemove(e){
        const rect = videoBox.getBoundingClientRect();

        if(window.innerWidth-videoBox.offsetWidth-rect.left < 20 ){
            videoBox.style.width = window.innerWidth-rect.left-21 +"px"     
        }
        else if (window.innerHeight-videoBox.offsetHeight-rect.top < 20 ) {
            videoBox.style.height = window.innerHeight-rect.top-21 +"px" 
        }else{
            videoBox.style.height = rect.height -(prevY - e.clientY) +"px";
            videoBox.style.width = rect.width - (prevX - e.clientX) +"px";
        }
        prevX = e.clientX;
        prevY = e.clientY;

        if(videoBox.offsetWidth < 300 || videoBox.offsetHeight < 250 ){
            localVideo.classList.add("video-min-size");
        }else{
            localVideo.classList.remove("video-min-size");
        }

        if(videoBox.offsetHeight < 221){
            remoteVideo.classList.remove("w-100");
            localVideo.style.width="unset";
            localVideo.style.height="100%";
        }
        else{
            remoteVideo.classList.add("w-100");
            localVideo.style.width="100%";
            localVideo.style.height="unset";
        }
        if(videoBox.offsetWidth < 251){
            remoteVideo.classList.remove("h-100");
            localVideo.style.height="unset";
        }
        else{
            remoteVideo.classList.add("h-100");
        }
        if(videoBox.offsetHeight < 221 && videoBox.offsetWidth < 251){
            remoteVideo.classList.add("h-100");
            localVideo.style.width="100%";
            remoteVideo.classList.add("w-100");
            localVideo.style.height="100%";
        }
    }
    function mouseup(){
        resizeing = false;
        window.removeEventListener('mousemove',mousemove);
        window.removeEventListener('mouseup', mouseup);
    
    }
}
