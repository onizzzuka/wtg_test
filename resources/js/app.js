import './bootstrap';
import { createApp } from 'vue';
import ChatPage from './components/ChatPage.vue';

createApp(ChatPage, { initial: window.__CHAT__ }).mount('#app');
