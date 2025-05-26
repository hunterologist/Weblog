// function.js

// حذف همه کوکی‌ها
function deleteAllCookies() {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        // اضافه کردن path برای اطمینان از حذف کامل
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    }
}

// ریدایرکت به آدرس مشخص
function redirect(dst) {
    window.location.href = dst;
}