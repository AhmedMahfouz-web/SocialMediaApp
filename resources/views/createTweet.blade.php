<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>doc</title>
        <link rel="stylesheet" href="{{ asset('css/createTweet.css') }}">
        <link rel="stylesheet" href="{{ asset('css/smart/style.css') }}">
  </head>
  <body class="body">
    <section>
        <section class="create-post">
          <header>
            <button><i class="icon-arrow-right2"></i></button>
            <button><a href="#">التالي</a></button>
          </header>
          <article class="aria">
            <article id="modal">
              <button id="chooseImage">اختر من الصور</button>
              <button id="takeImage">الكاميرا</button>
            </article>
            <textarea
              placeholder="شارك افكارك وتجاربك مع من هم حولك."
              name=""
              id="writingArea"
            ></textarea>
            <footer>
              <article class="color-plate">
                <button
                  class="color-btn"
                  style="background-color: white"
                ></button>
                <button
                  class="color-btn"
                  style="background-color: black"
                ></button>
                <button class="color-btn" style="background-color: red"></button>
                <button
                  class="color-btn"
                  style="background-color: aquamarine"
                ></button>
                <button class="color-btn" style="background-color: aqua"></button>
                <button class="color-btn" style="background-color: blue"></button>
                <button
                  class="color-btn"
                  style="background-color: orange"
                ></button>
                <button
                  class="color-btn"
                  style="background-color: rgb(15, 153, 153)"
                ></button>
                <button
                  class="color-btn"
                  style="background-color: blueviolet"
                ></button>
                <button
                  class="color-btn"
                  style="background-color: green"
                ></button>
                <button
                  class="color-btn"
                  style="background-color: rgb(51, 49, 25)"
                ></button>
              </article>
              <article class="footer-btns">
                <article class="btns">
                  <input type="file" id="fileInput" style="display: none" />
                  <button id="handleModal">
                    <i class="icon-camera"></i>
                  </button>
                  <!-- <button id="uploadImageButton" style="display: none">
                    <i class="icon-camera"></i>
                  </button> -->
                  <button id="uploadVideoButton">
                    <i class="icon-film"></i>
                  </button>
                  <button id="uploadAudioButton"><i class="icon-mic"></i></button>
                  <button id="plateColorBtn">
                    <i class="icon-contrast"></i>
                  </button>
                </article>
                <button><i class="icon-rocket"></i></button>
              </article>
            </footer>
          </article>
          <article id="fileContainer" class="file-wrapper"></article>
        </section>
        <section id="cameraSection">
          <video id="cameraPreview" autoplay></video>
        </section>
      </section>
    <script src="{{ asset('js/createTweet.js') }}"></script>
  </body>
</html>
