/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
const { default: Echo } = require('laravel-echo');
require('./bootstrap');
alert("hello");
window.Vue = require('vue').default;
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//Add these two components.
Vue.component('chat-messages', require('./components/ChatMessages.vue').default);
Vue.component('chat-form', require('./components/ChatForm.vue').default);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    //Store chat messages for display in this array.
    data: {
        messages: []
    },
    //Upon initialisation, run fetchMessages().
    created() {
        this.fetchMessages();
        window.Echo.private('chat')
        .listen('MessageSent', (e) => {
        this.messages.push({
        message: e.message.message,
        user: e.user
    });
  });
    },
    methods: {
        fetchMessages() {
            //GET request to the messages route in our Laravel server to fetch all the messages
            axios.get('/messages').then(response => {
                //Save the response in the messages array to display on the chat view
                this.messages = response.data;
            });
        },
        //Receives the message that was emitted from the ChatForm Vue component
        addMessage(message) {
            //Pushes it to the messages array
            this.messages.push(message);
            //POST request to the messages route with the message data in order for our Laravel server to broadcast it.
            axios.post('/messages', message).then(response => {
                console.log(response.data);
            });
        }
    }
});
