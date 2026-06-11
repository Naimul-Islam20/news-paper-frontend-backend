function banglaUnicodeToBijoy() {
    var input = document.getElementById('unicode-input');
    var output = document.getElementById('bijoy-input');
    if (!input || !output || !input.value.trim()) {
        return;
    }
    output.value = ConvertToASCII('bijoy', input.value);
}

function banglaBijoyToUnicode() {
    var input = document.getElementById('bijoy-input');
    var output = document.getElementById('unicode-input');
    if (!input || !output || !input.value.trim()) {
        return;
    }
    output.value = ConvertToUnicode('bijoy', input.value);
}

function banglaFixBroken() {
    var unicode = document.getElementById('unicode-input');
    var bijoy = document.getElementById('bijoy-input');
    if (!unicode || !bijoy) {
        return;
    }

    var source = bijoy.value.trim() || unicode.value.trim();
    if (!source) {
        return;
    }

    var fixed = '';
    for (var i = 0; i < source.length; i++) {
        fixed += String.fromCharCode(source.charCodeAt(i) & 0xff);
    }

    unicode.value = ConvertToUnicode('bijoy', fixed);
    bijoy.value = ConvertToASCII('bijoy', unicode.value);
}

function banglaClearAll() {
    var unicode = document.getElementById('unicode-input');
    var bijoy = document.getElementById('bijoy-input');
    if (unicode) {
        unicode.value = '';
    }
    if (bijoy) {
        bijoy.value = '';
    }
    unicode?.focus();
}

function banglaCopy(field) {
    var el = document.getElementById(field === 'unicode' ? 'unicode-input' : 'bijoy-input');
    if (el && el.value) {
        navigator.clipboard?.writeText(el.value);
    }
}
