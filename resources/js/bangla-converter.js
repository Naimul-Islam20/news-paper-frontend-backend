import { BanglaLikhi } from 'bangla-likhi';

function fixBrokenBijoy(text, isUnicodeField) {
    if (isUnicodeField && /[\u0980-\u09FF]/.test(text)) {
        return text;
    }

    let bijoy = '';
    for (let i = 0; i < text.length; i++) {
        const code = text.charCodeAt(i);
        bijoy += code <= 255 ? text[i] : String.fromCharCode(code & 0xff);
    }
    return BanglaLikhi.bijoyToUnicode(bijoy);
}

function initBanglaConverter() {
    const unicodeInput = document.getElementById('unicode-input');
    const bijoyInput = document.getElementById('bijoy-input');

    if (!unicodeInput || !bijoyInput) {
        return;
    }

    document.getElementById('btn-unicode-to-bijoy')?.addEventListener('click', () => {
        if (!unicodeInput.value.trim()) {
            return;
        }
        bijoyInput.value = BanglaLikhi.unicodeToBijoy(unicodeInput.value);
    });

    document.getElementById('btn-bijoy-to-unicode')?.addEventListener('click', () => {
        if (!bijoyInput.value.trim()) {
            return;
        }
        unicodeInput.value = BanglaLikhi.bijoyToUnicode(bijoyInput.value);
    });

    document.getElementById('btn-fix-broken')?.addEventListener('click', () => {
        const bijoyText = bijoyInput.value.trim();
        const unicodeText = unicodeInput.value.trim();
        if (!bijoyText && !unicodeText) {
            return;
        }
        if (bijoyText) {
            unicodeInput.value = BanglaLikhi.bijoyToUnicode(bijoyText);
            bijoyInput.value = BanglaLikhi.unicodeToBijoy(unicodeInput.value);
            return;
        }
        if (/[\u0980-\u09FF]/.test(unicodeText)) {
            bijoyInput.value = BanglaLikhi.unicodeToBijoy(unicodeText);
            return;
        }
        unicodeInput.value = fixBrokenBijoy(unicodeText, true);
        bijoyInput.value = BanglaLikhi.unicodeToBijoy(unicodeInput.value);
    });

    document.getElementById('btn-clear')?.addEventListener('click', () => {
        unicodeInput.value = '';
        bijoyInput.value = '';
        unicodeInput.focus();
    });

    document.getElementById('copy-unicode')?.addEventListener('click', () => {
        if (unicodeInput.value) {
            navigator.clipboard?.writeText(unicodeInput.value);
        }
    });

    document.getElementById('copy-bijoy')?.addEventListener('click', () => {
        if (bijoyInput.value) {
            navigator.clipboard?.writeText(bijoyInput.value);
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initBanglaConverter);
} else {
    initBanglaConverter();
}
