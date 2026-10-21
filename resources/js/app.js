import './bootstrap';

import { createApp } from 'vue';
import { setOptions } from '@googlemaps/js-api-loader';
import KortetComponent from './components/KortetComponent.vue';

setOptions({ key: import.meta.env.VITE_GOOGLE_MAPS_KEY });

const el = document.getElementById('kortet-app');

if (el) {
    createApp(KortetComponent, {
        kredse: JSON.parse(el.dataset.kredse),
        kredsprop: el.dataset.kreds ? JSON.parse(el.dataset.kreds) : null,
    }).mount(el);
}
