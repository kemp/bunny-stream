import Overview from './components/Overview.vue';
import Videobrowser from './components/Videobrowser.vue';
import Settings from './components/Settings.vue';

import mitt from 'mitt'

export const emitter = mitt()

import '@uppy/core/dist/style.css';
import '@uppy/dashboard/dist/style.css';
 
Statamic.booting(() => {
    Statamic.$components.register('overview', Overview);
    Statamic.$components.register('videobrowser', Videobrowser);
    Statamic.$components.register('video-settings', Settings);
});
