let cookies = {};

cookies.get = function (sName) {
    var oCrumbles = document.cookie.split(';');
    for (var i = 0; i < oCrumbles.length; i++) {
        var oPair = oCrumbles[i].split('=');
        var sKey = decodeURIComponent(oPair[0].trim());
        var sValue = oPair.length > 1 ? oPair[1] : '';
        if (sKey === sName) {
            return decodeURIComponent(sValue);
        }
    }
    return null;
};

cookies.set = function (sName, sValue, options) {
    //oDate.setYear(oDate.getFullYear()+1);
    var sCookie = encodeURIComponent(sName) + '=' + encodeURIComponent(sValue);

    // Shorthand: options === expires date
    if (options && options instanceof Date) {
        options = {
            expires: options
        };
    }
    // Longhand: options object
    if (options && typeof options == 'object') {
        if (options.expires) {
            sCookie += '; expires=' + options.expires.toGMTString();
        }
        if (options.path) {
            sCookie += '; path=' + options.path.toString();
        }
        if (options.domain) {
            sCookie += '; domain=' + options.domain.toString();
        }
        if (options.secure) {
            sCookie += '; secure';
        }
    }
    document.cookie = sCookie;
};

cookies.remove = function (sName, options) {
    if (!options) {
        let options = {};
    }
    options.expires = new Date();
    setCookie(sName, '', options);
};

export default cookies;