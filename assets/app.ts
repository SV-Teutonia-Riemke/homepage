import './styles/app.scss';

import './bootstrap';
import ClipboardJS from 'clipboard';

document.addEventListener('DOMContentLoaded', (): void => {
    new ClipboardJS('.copy-to-clipboard');
});
