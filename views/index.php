<?php 
  use app\core\form\Form;
  use app\core\Application;
  if(!Application::isGuest()){
    header ("location: /message");
  }
  $Form = new Form();
?> 
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/index.css">
    <title>SwS</title>
  </head>
  <body>
    <div class="container" id="container">
      <div class="form-container sign-up-container">
        <?php  $Form = Form::begin('',"post")?>
          <h1>SwS Chat</h1>
          <?php if(!empty($model->error()[0] || count($model->error())>1)) {?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php
              foreach ($model->error() as $key => $value) {
                echo $value. " ";
              }           
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php }?>
          <div class="mb-3 mt-3 ">
            <!--
              <input type="email" class="form-control" id="sign-up-email" placeholder="Enter email" name="email">
            -->
            <?php echo $Form->field($model,'email',"form-control","sign-up-email","Enter email","email")?>
          </div>
          <div class="mb-3">
            <!--
              <input type="text" class="form-control" id="sign-up-name" placeholder="Enter name" name="name">
            -->
            <?php echo $Form->field($model,'name',"form-control","sign-up-name","Enter name","text")?>
          </div>
          <div class="mb-3 eyes-sign-up">
            <!--
              <input type="password" class="form-control" id="sign-up-password" placeholder="Enter password" name="password">
            -->
            <?php echo $Form->field($model,'password',"form-control","sign-up-password","Enter password","password")?>
            <span id = show>
              <svg class ="show-eye-sign-up" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #264653;"><path d="M14 12c-1.095 0-2-.905-2-2 0-.354.103-.683.268-.973C12.178 9.02 12.092 9 12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-.092-.02-.178-.027-.268-.29.165-.619.268-.973.268z"></path><path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path></svg>
              <svg  class ="hide-eye-sign-up"xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #264653"><path d="M12 19c.946 0 1.81-.103 2.598-.281l-1.757-1.757c-.273.021-.55.038-.841.038-5.351 0-7.424-3.846-7.926-5a8.642 8.642 0 0 1 1.508-2.297L4.184 8.305c-1.538 1.667-2.121 3.346-2.132 3.379a.994.994 0 0 0 0 .633C2.073 12.383 4.367 19 12 19zm0-14c-1.837 0-3.346.396-4.604.981L3.707 2.293 2.293 3.707l18 18 1.414-1.414-3.319-3.319c2.614-1.951 3.547-4.615 3.561-4.657a.994.994 0 0 0 0-.633C21.927 11.617 19.633 5 12 5zm4.972 10.558-2.28-2.28c.19-.39.308-.819.308-1.278 0-1.641-1.359-3-3-3-.459 0-.888.118-1.277.309L8.915 7.501A9.26 9.26 0 0 1 12 7c5.351 0 7.424 3.846 7.926 5-.302.692-1.166 2.342-2.954 3.558z"></path></svg>
            </span>
          </div>
          <button class="" name="signUp">Sign Up</button>
        <?php  $Form = Form::end()?>
      </div>
      <div class="form-container sign-in-container">
        <?php  $Form = Form::begin('',"post")?>
          <h1>SwS Chat</h1>
          <?php if(Application::$app->session->getFlash('success')) :?>
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
              <?php echo Application::$app->session->getFlash('success')?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php endif;?>
          <?php if(!empty($model->error()[0] || count($model->error())>1)) {?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php
              foreach ($model->error() as $key => $value) {
                echo $value. " ";
              }           
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php }?>
          <div class="mb-3 mt-3 ">
            <!--<input type="email" class="form-control" id="sign-in-email" placeholder="Enter email" name="email">-->
            <?php echo $Form->field($model,'email',"form-control","sign-in-email","Enter email","email")?>
          </div>
          <div class="mb-3 eyes">
            <!--<input type="password" class="form-control" id="sign-in-password" placeholder="Enter password" name="password">-->
            <?php echo $Form->field($model,'password',"form-control","sign-in-password","Enter password","password")?>
            <span id = show>
              <svg class ="show-eye" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #264653;"><path d="M14 12c-1.095 0-2-.905-2-2 0-.354.103-.683.268-.973C12.178 9.02 12.092 9 12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-.092-.02-.178-.027-.268-.29.165-.619.268-.973.268z"></path><path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path></svg>
              <svg  class ="hide-eye"xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #264653"><path d="M12 19c.946 0 1.81-.103 2.598-.281l-1.757-1.757c-.273.021-.55.038-.841.038-5.351 0-7.424-3.846-7.926-5a8.642 8.642 0 0 1 1.508-2.297L4.184 8.305c-1.538 1.667-2.121 3.346-2.132 3.379a.994.994 0 0 0 0 .633C2.073 12.383 4.367 19 12 19zm0-14c-1.837 0-3.346.396-4.604.981L3.707 2.293 2.293 3.707l18 18 1.414-1.414-3.319-3.319c2.614-1.951 3.547-4.615 3.561-4.657a.994.994 0 0 0 0-.633C21.927 11.617 19.633 5 12 5zm4.972 10.558-2.28-2.28c.19-.39.308-.819.308-1.278 0-1.641-1.359-3-3-3-.459 0-.888.118-1.277.309L8.915 7.501A9.26 9.26 0 0 1 12 7c5.351 0 7.424 3.846 7.926 5-.302.692-1.166 2.342-2.954 3.558z"></path></svg>
            </span>
          </div>
          <a id="forget-password" class="btn_fpass" href="">Forgot your password?</a>
          <button name = "login" id ="sign-in-button" class="">Sign In</button>
        <?php  $Form = Form::end()?>
      </div>
      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h1>Welcome Back!</h1>
            <p>To keep connected with us please login with your personal info</p>
            <button class="ghost btn_login" id="signIn">
              <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #ffebd2;"><path d="m8.121 12 4.94-4.939-2.122-2.122L3.879 12l7.06 7.061 2.122-2.122z"></path><path d="M17.939 4.939 10.879 12l7.06 7.061 2.122-2.122L15.121 12l4.94-4.939z"></path></svg>
            </button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1>Hello, Friend!</h1>
            <p>Enter your personal details and start journey with us</p>
            <button class="ghost btn_regist" id="signUp">
              <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #ffebd2;"><path d="m13.061 4.939-2.122 2.122L15.879 12l-4.94 4.939 2.122 2.122L20.121 12z"></path><path d="M6.061 19.061 13.121 12l-7.06-7.061-2.122 2.122L8.879 12l-4.94 4.939z"></path></svg>
            </button>
          </div>
        </div>
      </div>
    </div>
    <script src="js/index.js"></script>
