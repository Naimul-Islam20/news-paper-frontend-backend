import { BanglaLikhi } from 'bangla-likhi';

function fixBrokenBijoy(text) {
    let bijoy = '';
    for (let i = 0; i < text.length; i++) {
        bijoy += String.fromCharCode(text.charCodeAt(i) & 0xff);
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
        const source = bijoyInput.value.trim() || unicodeInput.value.trim();
        if (!source) {
            return;
        }
        unicodeInput.value = fixBrokenBijoy(source);
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
