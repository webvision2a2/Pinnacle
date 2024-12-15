function startFaceRecognition() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    var faceIdInput = document.getElementById('face_id');
    console.log(faceIdInput);

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            video.srcObject = stream;
            setTimeout(() => {  // Give user a moment to adjust their position
                context.drawImage(video, 0, 0, 640, 480);
                video.hidden = true;
                const imageDataURL = canvas.toDataURL('image/png');
                canvas.hidden = false;
                console.log("hello js 1 :",imageDataURL);
                registerFace(imageDataURL)
                    .then(faceId => {
                        faceIdInput.value = faceId;  // Store the faceId in a hidden input to be sent with the form
                        stream.getTracks().forEach(track => track.stop());  // Stop the camera stream
                        alert("Visage enregistré avec succès!");
                        stopVideoStream(video);
                        //activate check mark and desactivate button
                    })
                    .catch(error => {
                        alert("Aucun visage détecté: " + error.message);
                        stopVideoStream(video);
                    });
            }, 2000);
        });
}

function registerFace(imageDataURL) {
    return fetch('capture_face.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `image_data=${encodeURIComponent(imageDataURL)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("date face id: ", data.face_id);
                return data.face_id;  // Return the faceId received from the server
            } else {
                console.log("hello js 2");
                console.log("error: ", data.message);
                throw new Error(data.message);
            }
        });
}

function stopVideoStream(video) {
    const stream = video.srcObject;
    if (stream) {
        const tracks = stream.getTracks();

        tracks.forEach(function (track) {
            track.stop();
        });

        video.srcObject = null; // Clear the source after stopping the track
    }
    video.hidden = true; // Optionally hide the video element
    canvas.hidden = true; // Optionally hide the canvas if you're using it
}