import './bootstrap';
import './post-photocard';
import './web-push';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// AdSense — পেজ render + Alpine শেষ হওয়ার পর লোড (blank/hang রোধ)
window.addEventListener('load', () => {
    window.setTimeout(() => import('./adsense-lazy'), 1500);
}, { once: true });
