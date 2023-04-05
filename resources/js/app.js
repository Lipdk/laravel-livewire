import './bootstrap';

// import moment from 'moment';
// window.moment = moment;

import Pikaday from 'pikaday';
window.Pikaday = Pikaday;
import "pikaday/css/pikaday.css";

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import 'flowbite';

window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
