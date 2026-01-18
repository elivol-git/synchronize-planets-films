import { createApp } from 'vue';
import Planets from './components/Planets.vue';

const el = document.getElementById('app');

createApp(Planets, {
    planets: JSON.parse(el.dataset.planets)
}).mount('#app');
