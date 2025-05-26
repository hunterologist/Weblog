// upload.js

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
                    dataType: 'json', // انتظار JSON داریم
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
                        messageDiv.className = response.status === 'success' ? "message success" : "message error";
                        messageDiv.innerHTML = response.message;
                        fileInput.parentNode.appendChild(messageDiv);
                        // به جای رفرش، فقط تصویر رو آپدیت می‌کنیم
                        if (response.status === 'success') {
                            var img = document.querySelector('img[alt="Profile Image"]');
                            img.src = img.src + '?' + new Date().getTime(); // Force reload image
                        }
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