require('./bootstrap');

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import Tooltip from '@ryangjchandler/alpine-tooltip';

Alpine.plugin(Tooltip);
Alpine.plugin(persist);

window.Alpine = Alpine;
Alpine.start();



