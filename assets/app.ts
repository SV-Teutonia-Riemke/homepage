import './styles/app.scss';

import './bootstrap';
import ClipboardJS from 'clipboard';
import * as OfflinePluginRuntime from '@lcdp/offline-plugin/runtime';

document.addEventListener('DOMContentLoaded', (): void => {
    new ClipboardJS('.copy-to-clipboard');
});

OfflinePluginRuntime.install();
