const writingArea = document.getElementById("writingArea");
const colorPlateBtns = document.querySelectorAll(".color-plate button");
const colorPlate = document.querySelector(".color-plate");
const colorPlateBtn = document.getElementById("plateColorBtn");
const aria = document.querySelector(".aria");

const fileInput = document.getElementById("fileInput");
const uploadImageButton = document.getElementById("uploadImageButton");
const uploadVideoButton = document.getElementById("uploadVideoButton");
const uploadAudioButton = document.getElementById("uploadAudioButton");

const fileContainer = document.getElementById("fileContainer");

colorPlateBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        let color = e.target.style.backgroundColor;
        if (color == "black" || color == "rgb(51, 49, 25)") {
            writingArea.style.color = "white";
        } else {
            writingArea.style.color = "black";
        }
        writingArea.style.backgroundColor = color;
        writingArea.focus();
    });
});

colorPlateBtn.addEventListener("click", () => {
    colorPlate.classList.toggle("active");
});

// control the uplaud files

uploadImageButton.addEventListener("click", () => {
    fileInput.setAttribute("accept", "image/*");
    fileInput.click();
});
uploadVideoButton.addEventListener("click", () => {
    fileInput.setAttribute("accept", "video/*");
    fileInput.click();
});
uploadAudioButton.addEventListener("click", () => {
    fileInput.setAttribute("accept", "audio/*");
    fileInput.click();
});

fileInput.addEventListener("change", (e) => {
    const file = e.target.files[0];
    const fileType = file.type.split("/")[0];

    if (fileType === "image" || fileType === "video" || fileType === "audio") {
        const reader = new FileReader();

        reader.onload = (e) => {
            let mediaElement;

            if (fileType === "image") {
                mediaElement = document.createElement("img");
            } else if (fileType === "video") {
                mediaElement = document.createElement("video");
                mediaElement.setAttribute("controls", true);
            } else if (fileType === "audio") {
                mediaElement = document.createElement("audio");
                mediaElement.setAttribute("controls", true);
            }

            mediaElement.src = e.target.result;
            fileContainer.innerHTML = "";
            fileContainer.appendChild(mediaElement);
            aria.style.height = "25%";
        };

        reader.readAsDataURL(file);
    }
});
