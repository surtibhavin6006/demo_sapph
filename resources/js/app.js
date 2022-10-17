import './bootstrap';
import '../scss/styles.scss';
import Router from "../js/router/index";
import * as bootstrap from 'bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';

const app = createApp({});
app.use(bootstrap);
app.use(Router);
app.mount("#app");
