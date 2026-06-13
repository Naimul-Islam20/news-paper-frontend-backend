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

    var bijoySource = bijoy.value.trim();
    var unicodeSource = unicode.value.trim();
    if (!bijoySource && !unicodeSource) {
        return;
    }

    if (bijoySource) {
        unicode.value = ConvertToUnicode('bijoy', bijoySource);
        bijoy.value = ConvertToASCII('bijoy', unicode.value);
        return;
    }

    if (/[\u0980-\u09FF]/.test(unicodeSource)) {
        bijoy.value = ConvertToASCII('bijoy', unicodeSource);
        return;
    }

    var fixed = '';
    for (var i = 0; i < unicodeSource.length; i++) {
        var code = unicodeSource.charCodeAt(i);
        fixed += code <= 255 ? unicodeSource.charAt(i) : String.fromCharCode(code & 0xff);
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
