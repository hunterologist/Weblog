// upload.js

// مطمئن شو که jQuery لود شده
if (typeof jQuery === 'undefined') {
    console.error("jQuery is not loaded. Please include jQuery before this script.");
} else {
    $(document).ready(function() {
        $("#image").change(function() {
            var formData = new FormData();
            var fileInput = document.getElementById("image");
            var file = fileInput.files[0];

            if (file) {
                formData.append("image", file);

                // نمایش پیشرفت آپلود
                var progressBar = document.createElement("progress");
                progressBar.id = "uploadProgress";
                progressBar.value = 0;
                progressBar.max = 100;
                fileInput.parentNode.appendChild(progressBar);

                $.ajax({
                    url: "upload.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percent = (evt.loaded / evt.total) * 100;
                                $("#uploadProgress").val(percent);
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        var messageDiv = document.createElement("p");
                        messageDiv.id = "message";
                        messageDiv.innerHTML = response;
                        fileInput.parentNode.appendChild(messageDiv);
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        var messageDiv = document.createElement("p");
                        messageDiv.id = "message";
                        messageDiv.className = "message error";
                        messageDiv.innerHTML = "Upload failed: " + error;
                        fileInput.parentNode.appendChild(messageDiv);
                    }
                });
            } else {
                var messageDiv = document.createElement("p");
                messageDiv.id = "message";
                messageDiv.className = "message error";
                messageDiv.innerHTML = "Please select an image file.";
                fileInput.parentNode.appendChild(messageDiv);
            }
        });
    });
}