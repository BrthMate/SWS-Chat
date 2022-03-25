<?php
use app\core\Application;
if(Application::isGuest()){
  header ("location: /");
}
?>
  <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/message.css">
    <title>SwS</title>
  </head>
  <body>
    <div class="container min-vw-100 max-vw-100" id="container">
        <nav class="navbar navbar-light bg-light-m fixed-top">
            <div class="container-fluid">
              <a class="text-light navbar-brand" href="#">SwS</a>
              <button class=" navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon "></span>
              </button>
              <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <div class="bar d-flex justify-content-end">
                        <span data-bs-toggle="modal" data-bs-target="#settings"><svg class="setting" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: var(--Black);"><path d="M12 16c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.084 0 2 .916 2 2s-.916 2-2 2-2-.916-2-2 .916-2 2-2z"></path><path d="m2.845 16.136 1 1.73c.531.917 1.809 1.261 2.73.73l.529-.306A8.1 8.1 0 0 0 9 19.402V20c0 1.103.897 2 2 2h2c1.103 0 2-.897 2-2v-.598a8.132 8.132 0 0 0 1.896-1.111l.529.306c.923.53 2.198.188 2.731-.731l.999-1.729a2.001 2.001 0 0 0-.731-2.732l-.505-.292a7.718 7.718 0 0 0 0-2.224l.505-.292a2.002 2.002 0 0 0 .731-2.732l-.999-1.729c-.531-.92-1.808-1.265-2.731-.732l-.529.306A8.1 8.1 0 0 0 15 4.598V4c0-1.103-.897-2-2-2h-2c-1.103 0-2 .897-2 2v.598a8.132 8.132 0 0 0-1.896 1.111l-.529-.306c-.924-.531-2.2-.187-2.731.732l-.999 1.729a2.001 2.001 0 0 0 .731 2.732l.505.292a7.683 7.683 0 0 0 0 2.223l-.505.292a2.003 2.003 0 0 0-.731 2.733zm3.326-2.758A5.703 5.703 0 0 1 6 12c0-.462.058-.926.17-1.378a.999.999 0 0 0-.47-1.108l-1.123-.65.998-1.729 1.145.662a.997.997 0 0 0 1.188-.142 6.071 6.071 0 0 1 2.384-1.399A1 1 0 0 0 11 5.3V4h2v1.3a1 1 0 0 0 .708.956 6.083 6.083 0 0 1 2.384 1.399.999.999 0 0 0 1.188.142l1.144-.661 1 1.729-1.124.649a1 1 0 0 0-.47 1.108c.112.452.17.916.17 1.378 0 .461-.058.925-.171 1.378a1 1 0 0 0 .471 1.108l1.123.649-.998 1.729-1.145-.661a.996.996 0 0 0-1.188.142 6.071 6.071 0 0 1-2.384 1.399A1 1 0 0 0 13 18.7l.002 1.3H11v-1.3a1 1 0 0 0-.708-.956 6.083 6.083 0 0 1-2.384-1.399.992.992 0 0 0-1.188-.141l-1.144.662-1-1.729 1.124-.651a1 1 0 0 0 .471-1.108z"></path></svg></span>
                        <span><svg class="changeMode" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: var(--Black);"><path d="M19.071 19.071c3.833-3.833 3.833-10.31 0-14.143s-10.31-3.833-14.143 0-3.833 10.31 0 14.143 10.31 3.833 14.143 0zM7.051 7.051c2.706-2.707 7.191-2.708 9.898 0l-9.898 9.898c-2.708-2.707-2.71-7.19 0-9.898z"></path></svg></span>
                        <span><a href="/logout"><svg class="logOut" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: var(--Black);"><path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path><path d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z"></path></svg></a></span>
                    </div>
                    <button type="button" style="margin: 1px;" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                  </div>
                <div class="offcanvas-body py-0">
                  <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                  </ul>
                </div>
              </div>
            </div>
          </nav>
          <section class="messages">
            <div class="contact">
              <div class="row mt-5 pt-3">
                <div class="col-xl-3 col-md-4 col-sm-5 col-12 overflow-scroll mt-2 vh-100">        
                    <input class="form-control mt-2 me-2" id ="search-input" placeholder="Search" aria-label="Search">
                  <div class="users-box-list"></div>
                </div>
                <div class="col-xl-9 col-md-8 col-sm-7 col-12 vh-100">
                  <div class="mt-3">
                    <div class="w-100 card-body-conatiner">
                        <div class="card-body d-flex  justify-content-between">
                        </div>
                    </div>
                    <div class=" w-100 mt-3 messeger d-flex flex-column align-items-stretch">
                        <div class="message-box">
                        </div>
                        <div class="mt-2" id="send-text-container">
                          <input class="form-control me-2" type="search" id ="send-input" placeholder="Search">
                          <form method="post" class="m-1" id="sendForm" enctype="multipart/form-data">
                            <div class="functions d-flex flex-row align-items-stretch">
                              <input class="form-control me-2" name="sendText" value="" id ="send-input-hidden" hidden>
                              <input class="form-control me-2" name="userId" value="" id ="userId-input-hidden" hidden>
                              <button class="btn" type="file" id="buttonid" >
                                <svg xmlns="http://www.w3.org/2000/svg" id="uploadFileSvg" width="24" height="24" viewBox="0 0 24 24" style="fill: var(--Black);"><path d="m9 13 3-4 3 4.5V12h4V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h8v-4H5l3-4 1 2z"></path><path d="M19 14h-2v3h-3v2h3v3h2v-3h3v-2h-3z"></path></svg>
                              </button>
                              <input id='fileid' type='file' name="img" accept="image/*" hidden/>
                              <button class="btn" type="button" id="voice-btn" data-bs-toggle="modal" data-bs-target="#voiceModel">
                                <svg xmlns="http://www.w3.org/2000/svg" id="voiceBtnSvg" width="24" height="24" viewBox="0 0 24 24" style="fill: var(--Black);"><path d="M12 16c2.206 0 4-1.794 4-4V6c0-2.217-1.785-4.021-3.979-4.021a.933.933 0 0 0-.209.025A4.006 4.006 0 0 0 8 6v6c0 2.206 1.794 4 4 4z"></path><path d="M11 19.931V22h2v-2.069c3.939-.495 7-3.858 7-7.931h-2c0 3.309-2.691 6-6 6s-6-2.691-6-6H4c0 4.072 3.061 7.436 7 7.931z"></path></svg>
                              </button>
                            </div>
                            <button class="btn" type="button" id="send-btn" >
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: var(--Black);"><path d="m21.426 11.095-17-8A1 1 0 0 0 3.03 4.242l1.212 4.849L12 12l-7.758 2.909-1.212 4.849a.998.998 0 0 0 1.396 1.147l17-8a1 1 0 0 0 0-1.81z"></path></svg>
                            </button>
                          </form>
                          <button class="btn d-none" type="button" id="show-buttons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: var(--Black);"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path></svg>
                          </button>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section class="settings">
            <div class="modal fade" id="settings">
              <div class="modal-dialog">
                <div class="modal-content">
            
                  <div class="modal-header">
                    <h4 class="modal-title">Settings</h4>
                    <button class="btn-close text-reset" type="button" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <form >
                      <div class="form-group mb-3 overflow-hidden">
                        <input type="file" class="form-control-file" id="exampleFormControlFile1">
                      </div>
                      <div class="form-group mb-3">
                        <input type="text" class="form-control" placeholder="Enter name">
                      </div>
                      <div class="form-group mb-3">
                        <input type="email" class="form-control" placeholder="Enter email">
                      </div>
                      <div class="form-group mb-3">
                        <input type="password" class="form-control" placeholder="Enter password">
                      </div>
                      <div class="form-group mb-3">
                        <input type="password" class="form-control" placeholder="Enter comfirm password">
                      </div>
                        <input type="password" class="form-control" id="token" value="<?php echo( Application::UserData());?>" placeholder="Id" hidden>
                      <button class="modal-btn" type="button">Change</button>
                    </form>
                  </div>
            
                </div>
              </div>
            </div>
          </section>
          <section class="videoCall d-none">
            <div class="video h-100 w-100">
              <video id="remoteVideo" class="w-100 h-100 positon-relative object cover" autoplay></video>
              <video id="localVideo" class="position-absolute bottom-0 end-0" autoplay></video>
            </div>
            <div class="resize">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: white;"><path d="m13.061 4.939-2.122 2.122L15.879 12l-4.94 4.939 2.122 2.122L20.121 12z"></path><path d="M6.061 19.061 13.121 12l-7.06-7.061-2.122 2.122L8.879 12l-4.94 4.939z"></path></svg>
            </div>
            <div class="video-options">
              <div class="mic">
                <svg class="mic-active" xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: white"><path d="M12 16c2.206 0 4-1.794 4-4V6c0-2.217-1.785-4.021-3.979-4.021a.933.933 0 0 0-.209.025A4.006 4.006 0 0 0 8 6v6c0 2.206 1.794 4 4 4z"></path><path d="M11 19.931V22h2v-2.069c3.939-.495 7-3.858 7-7.931h-2c0 3.309-2.691 6-6 6s-6-2.691-6-6H4c0 4.072 3.061 7.436 7 7.931z"></path></svg>
                <svg class="mic-inactive d-none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill:var(--JungleGreen)"><path d="m21.707 20.293-3.4-3.4A7.93 7.93 0 0 0 20 12h-2a5.945 5.945 0 0 1-1.119 3.467l-1.449-1.45A3.926 3.926 0 0 0 16 12V6c0-2.217-1.785-4.021-3.979-4.021-.07 0-.14.009-.209.025A4.006 4.006 0 0 0 8 6v.586L3.707 2.293 2.293 3.707l18 18 1.414-1.414zM6 12H4c0 4.072 3.06 7.436 7 7.931V22h2v-2.069a7.935 7.935 0 0 0 2.241-.63l-1.549-1.548A5.983 5.983 0 0 1 12 18c-3.309 0-6-2.691-6-6z"></path><path d="M8.007 12.067a3.996 3.996 0 0 0 3.926 3.926l-3.926-3.926z"></path></svg>
              </div>
              <div class="call-ending">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: var(--bs-danger)"><path d="M9.17 13.42a5.24 5.24 0 0 1-.93-2.06L10.7 9a1 1 0 0 0 0-1.39l-3.65-4.1a1 1 0 0 0-1.4-.08L3.48 5.29a1 1 0 0 0-.29.65 15.25 15.25 0 0 0 3.54 9.92l-4.44 4.43 1.42 1.42 18-18-1.42-1.42zm7.44.02a1 1 0 0 0-1.39.05L12.82 16a4.07 4.07 0 0 1-.51-.14l-2.66 2.61A15.46 15.46 0 0 0 17.89 21h.36a1 1 0 0 0 .65-.29l1.86-2.17a1 1 0 0 0-.09-1.39z"></path></svg>
              </div>
              <div class="cam">
                <svg class="cam-active" xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill: white"><path d="M12 9c-1.626 0-3 1.374-3 3s1.374 3 3 3 3-1.374 3-3-1.374-3-3-3z"></path><path d="M20 5h-2.586l-2.707-2.707A.996.996 0 0 0 14 2h-4a.996.996 0 0 0-.707.293L6.586 5H4c-1.103 0-2 .897-2 2v11c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V7c0-1.103-.897-2-2-2zm-8 12c-2.71 0-5-2.29-5-5s2.29-5 5-5 5 2.29 5 5-2.29 5-5 5z"></path></svg>
                <svg class="cam-inactive d-none" xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="fill:var(--JungleGreen)"><path d="M4 20h11.879l-3.083-3.083A4.774 4.774 0 0 1 12 17c-2.71 0-5-2.29-5-5 0-.271.039-.535.083-.796L2.144 6.265C2.054 6.493 2 6.74 2 7v11c0 1.103.897 2 2 2zM20 5h-2.586l-2.707-2.707A.996.996 0 0 0 14 2h-4a.996.996 0 0 0-.707.293L6.586 5h-.172L3.707 2.293 2.293 3.707l18 18 1.414-1.414-.626-.626A1.98 1.98 0 0 0 22 18V7c0-1.103-.897-2-2-2zm-5.312 8.274A2.86 2.86 0 0 0 15 12c0-1.626-1.374-3-3-3-.456 0-.884.12-1.274.312l-1.46-1.46A4.88 4.88 0 0 1 12 7c2.71 0 5 2.29 5 5a4.88 4.88 0 0 1-.852 2.734l-1.46-1.46z"></path></svg>
              </div>
            </div>
          </section>
          <section class="calling-box d-none">
            <div class="calling">
            </div>
            <div class="incoming-call">
              <div class="personal-detail d-flex align-items-center postion-absolute ">
                <img  class ="profile-image box-content litle img-calling" src="" alt="">
                <div class="profile-details m-auto">
                    <h5 class="card-title" style="max-width: 130px; text-overflow: ellipsis; color: var(--white)"><strong></strong></h5>
                    <h6 class="decline-call d-none" style="max-width: 130px; text-overflow: ellipsis; text-align: center; color: var(--white)"><strong>Hivását elutasította</strong></h6>
                  </div>
                </div>
                <div class="option  d-flex my-auto">
                    <button class="btn acceptCallBtn">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: var(--white)"><path d="M20 10.999h2C22 5.869 18.127 2 12.99 2v2C17.052 4 20 6.943 20 10.999z"></path><path d="M13 8c2.103 0 3 .897 3 3h2c0-3.225-1.775-5-5-5v2zm3.422 5.443a1.001 1.001 0 0 0-1.391.043l-2.393 2.461c-.576-.11-1.734-.471-2.926-1.66-1.192-1.193-1.553-2.354-1.66-2.926l2.459-2.394a1 1 0 0 0 .043-1.391L6.859 3.513a1 1 0 0 0-1.391-.087l-2.17 1.861a1 1 0 0 0-.29.649c-.015.25-.301 6.172 4.291 10.766C11.305 20.707 16.323 21 17.705 21c.202 0 .326-.006.359-.008a.992.992 0 0 0 .648-.291l1.86-2.171a1 1 0 0 0-.086-1.391l-4.064-3.696z"></path></svg></span>
                    </button>
                    <button class=" btn declineCallBtn">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: var(--white)"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm4.207 12.793-1.414 1.414L12 13.414l-2.793 2.793-1.414-1.414L10.586 12 7.793 9.207l1.414-1.414L12 10.586l2.793-2.793 1.414 1.414L13.414 12l2.793 2.793z"></path></svg></span>
                    </button>
              </div>
            </div>
          </section>
          <section class="speech">
            <div class="modal fade" id="voiceModel" tabindex="-1" aria-labelledby="voiceModelLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="voiceModelLabel">Voice recognition</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <textarea id="voiceArea" rows="10"></textarea>
                    <button type="button" id ="TextAreasendBtn" data-bs-dismiss="modal" class="modal-btn">Send</button>
                    <span class="voiceStatus">
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </section>
    </div>
    <script src="js/video.js"></script>
    <script src="js/adapter.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/message.js"></script>
    <script src="js/webRTC.js"></script>
    <script src="js/voice.js"></script>
