/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import './bootstrap';

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import {createApp} from 'vue';

const app = createApp({});

import DelPost from './components/DelPost.vue';
app.component('del-post', DelPost)

app.mount("#app");
