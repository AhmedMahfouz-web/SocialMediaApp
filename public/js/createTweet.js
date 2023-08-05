const handleModal = document.getElementById("handleModal");

const chooseImage = document.getElementById("chooseImage");
const takeImage = document.getElementById("takeImage");
const cameraSection = document.getElementById("cameraSection");
const cameraPreview = document.getElementById("cameraPreview");

const writingArea = document.getElementById("writingArea");
const colorPlateBtns = document.querySelectorAll(".color-plate button");
const colorPlate = document.querySelector(".color-plate");
const colorPlateBtn = document.getElementById("plateColorBtn");
const aria = document.querySelector(".aria");

const modal = document.getElementById("modal");

const fileInput = document.getElementById("fileInput");
// const uploadImageButton = document.getElementById("uploadImageButton");
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

// uploadImageButton.addEventListener("click", () => {
//   fileInput.setAttribute("accept", "image/*");
//   fileInput.click();
// });
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
            modal.classList.remove("active");
        };

        reader.readAsDataURL(file);
    }
});

// handle modal

handleModal.addEventListener("click", () => {
    modal.classList.toggle("active");
});

chooseImage.addEventListener("click", () => {
    fileInput.setAttribute("accept", "image/*");
    fileInput.click();
});

//

let stream; // Variable to store the camera stream

takeImage.addEventListener("click", () => {
    document.querySelector(".create-post").style.display = "none";
    // Check if the browser supports the getUserMedia API
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Request access to the user's camera
        navigator.mediaDevices
            .getUserMedia({ video: true })
            .then((mediaStream) => {
                // Store the camera stream in the variable for later use
                stream = mediaStream;

                // Display the camera stream in the video element
                cameraPreview.srcObject = stream;
                cameraPreview.style.display = "block";

                // Show the capture button
                const captureButton = document.createElement("button");
                captureButton.innerText = "Capture";
                cameraSection.appendChild(captureButton);

                // Listen for a click event on the capture button
                captureButton.addEventListener("click", () => {
                    document.querySelector(".create-post").style.display =
                        "block";
                    // Create a canvas element to capture the image
                    const canvas = document.createElement("canvas");
                    const context = canvas.getContext("2d");
                    canvas.width = cameraPreview.videoWidth;
                    canvas.height = cameraPreview.videoHeight;

                    // Draw the current frame from the video element onto the canvas
                    context.drawImage(
                        cameraPreview,
                        0,
                        0,
                        canvas.width,
                        canvas.height
                    );

                    // Create an image element to display the captured image
                    const capturedImage = new Image();
                    capturedImage.src = canvas.toDataURL("image/png");

                    // Append the captured image to the image container
                    fileContainer.innerHTML = "";
                    fileContainer.appendChild(capturedImage);
                    aria.style.height = "25%";
                    stream.getTracks().forEach((track) => {
                        track.stop();
                    });

                    // Remove the capture button
                    captureButton.remove();
                    cameraPreview.style.display = "none";
                    modal.classList.remove("active");
                });
            })
            .catch((error) => {
                console.error("Error accessing camera:", error);
            });
    } else {
        console.error("getUserMedia is not supported by this browser.");
    }
});
