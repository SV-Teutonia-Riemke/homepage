import { startStimulusApp, registerControllers } from "vite-plugin-symfony/stimulus/helpers"
import Clipboard from '@stimulus-components/clipboard';
import '@tabler/core';
import '@tabler/core/dist/libs/fslightbox';

const app = startStimulusApp();
registerControllers(
    app,
    import.meta.glob('./controllers/*_controller.js', {
        query: "?stimulus",
        eager: true,
    })
)

app.register('clipboard', Clipboard)

export { app };
