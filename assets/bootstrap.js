import { startStimulusApp } from '@symfony/stimulus-bridge';
import Clipboard from '@stimulus-components/clipboard';
import '@tabler/core';
import '@tabler/core/dist/libs/fslightbox';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));
app.register('clipboard', Clipboard)

export { app };
