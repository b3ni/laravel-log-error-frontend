try {
    window.onerror = function(errorMsg, url, line, col, error) {
        var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        var url =
            "logerrorfrontend?" +
            "errorMsg=" +
            encodeURIComponent(errorMsg) +
            "&errorLine=" +
            line +
            "&errorColumn=" +
            col +
            "&queryString=" +
            encodeURIComponent(document.location.search) +
            "&url=" +
            encodeURIComponent(document.location.pathname) +
            "&referrer=" +
            encodeURIComponent(document.referrer) +
            "&userAgent=" +
            encodeURIComponent(navigator.userAgent);

        xhr.open("GET", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send();

        return true; // suppress browser error messages
    };
} catch (e) {}
