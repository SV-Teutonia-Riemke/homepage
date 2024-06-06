import './styles/app.scss';

import './bootstrap';
import ClipboardJS from 'clipboard';

import.meta.glob([
    './images/**',
    './documents/**',
]);

document.addEventListener('DOMContentLoaded', (): void => {
    new ClipboardJS('.copy-to-clipboard');
});

