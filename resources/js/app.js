require('./bootstrap');
//resources/js/app.js
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//Add these two components.
Vue.component('chat-messages', require('./components/ChatMessages.vue').default);
Vue.component('chat-form', require('./components/ChatForm.vue').default);
