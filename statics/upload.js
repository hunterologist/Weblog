// upload.js

if (typeof jQuery === 'undefined') {
    console.error("jQuery is not loaded. Please include jQuery before this script.");
} else {
    $(document).ready(function() {
        $("#uploadForm").on('submit', function(e) {
            e.preventDefault(); // جلوگیری از ارسال فرم به صورت پیش‌فرض

            var formData = new FormData(this);
            var fileInput = document.getElementById("image");
            var file = fileInput.files[0];

            if (file) {
                // نمایش پیشرفت آپلود
                $("#uploadProgress").val(0); // ریست کردن progress bar

                $.ajax({
                    url: "upload.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percent = (evt.loaded / evt.total) * 100;
                                $("#uploadProgress").val(percent);
                                console.log("Upload progress: " + percent + "%");
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        $("#message").removeClass("message error success");
                        $("#message").addClass(response.status === 'success' ? "message success" : "message error");
                        $("#message").html(response.message);
                        if (response.status === 'success') {
                            var img = document.querySelector('img[alt="Profile Image"]');
                            img.src = img.src + '?' + new Date().getTime();
                        }
                    },
                    error: function(xhr, status, error) {
                        $("#message").removeClass("message error success");
                        $("#message").addClass("message error");
                        $("#message").html("Upload failed: " + error);
                    }
                });
            } else {
                $("#message").removeClass("message error success");
                $("#message").addClass("message error");
                $("#message").html("Please select an image file.");
            }
        });
    });
}