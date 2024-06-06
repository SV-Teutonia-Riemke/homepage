import { startStimulusApp, registerControllers } from "vite-plugin-symfony/stimulus/helpers"
import Clipboard from '@stimulus-components/clipboard';
import '@tabler/core';
import '@tabler/core/dist/libs/fslightbox';

const app = startStimulusApp();
registerControllers(
    app,
    import.meta.glob('./controllers/*_(lazy)\?controller.[jt]s(x)\?')
)

app.register('clipboard', Clipboard)

export { app };
