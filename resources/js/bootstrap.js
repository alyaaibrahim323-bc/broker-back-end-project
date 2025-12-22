import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */
// window.Echo = new Echo({
//     broadcaster: 'reverb',
//     key: process.env.MIX_REVERB_APP_KEY,
//     wsHost: window.location.hostname,
//     wsPort: 8080, // أو البورت الذي تستخدمه
//     forceTLS: false, // إذا كنت تستخدم HTTPS غيرها لـ true
// });
import './echo';
