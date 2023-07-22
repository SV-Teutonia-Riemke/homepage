import { startStimulusApp } from '@symfony/stimulus-bridge';
import Clipboard from 'stimulus-clipboard'
import '@tabler/core'

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));
app.register('clipboard', Clipboard)

export { app };
