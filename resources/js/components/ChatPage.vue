<template>
    <div class="flex h-full w-full overflow-hidden font-sans">
        <aside class="w-64 border-r border-gray-200 p-3 overflow-auto">
            <h3 class="font-bold text-lg mb-2">Users</h3>
            <div
                v-for="u in users"
                :key="u.id"
                @click="selectUser(u)"
                class="p-2 cursor-pointer rounded"
                :class="selectedUser?.id === u.id ? 'bg-gray-100' : 'bg-transparent hover:bg-gray-50'"
            >
                {{ u.name }}
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-h-0 w-full">
            <div class="p-3 border-b border-gray-200 shrink-0">
                <strong>{{ selectedUser ? selectedUser.name : 'Select a user' }}</strong>
            </div>

                        <div ref="messagesContainer" class="flex-1 min-h-0 overflow-y-auto p-3">
                            <div
                                v-for="m in messages"
                                :key="m.id"
                                class="mb-2.5 flex"
                                :class="isOutgoing(m) ? 'justify-end' : 'justify-start'"
                            >
                                <div
                                    class="max-w-[75%] rounded-xl px-3 py-2"
                                    :class="isOutgoing(m) ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-900'"
                                >
                                    <div class="text-xs opacity-70 mb-0.5">
                                        {{ isOutgoing(m) ? 'You' : (m.sender?.name || 'User') }}
                                    </div>
                                    <div>{{ m.message }}</div>
                                </div>
                </div>
            </div>

            <form @submit.prevent="sendMessage" class="flex p-3 border-t border-gray-200 shrink-0">
                <input
                    v-model="newMessage"
                    type="text"
                    placeholder="Type message..."
                    class="flex-1 p-2 border border-gray-300 rounded outline-none focus:ring-2 focus:ring-blue-300"
                />
                <button
                    type="submit"
                    class="ml-2 px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                >
                    Send
                </button>
            </form>
        </main>
    </div>
</template>

<script setup>
import {nextTick, onMounted, ref} from 'vue';

const props = defineProps({initial: {type: Object, required: true}
});

const me = ref(props.initial.me);
const users = ref(props.initial.users);
const selectedUser = ref(null);
const messages = ref([]);
const newMessage = ref('');
const messagesContainer = ref(null);

const senderId = (m) => (typeof m.sender === 'object' ? m.sender?.id : m.sender);
const isOutgoing = (m) => Number(senderId(m)) === Number(me.value.id);

const scrollToBottom = async () => {
    await nextTick();
    if (messagesContainer.value) {
        messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
    }
};

const loadMessages = async () => {
    if (!selectedUser.value) return;
    const {data} = await window.axios.get(`/chat/messages/${selectedUser.value.id}`);
    messages.value = data;
    await scrollToBottom();
};

const selectUser = async (u) => {
    selectedUser.value = u;
    await loadMessages();
    await scrollToBottom();
};

const sendMessage = async () => {
    if (!selectedUser.value || !newMessage.value.trim()) return;

    const {data} = await window.axios.post('/chat/messages', {
        recipient: selectedUser.value.id,
        message: newMessage.value.trim(),
    });

    messages.value.push(data);
    newMessage.value = '';
    await scrollToBottom();
};

onMounted(() => {
    window.Echo.private(`chat.${me.value.id}`)
        .listen('.message.sent', (e) => {
            const m = e.message;
            if (!selectedUser.value) return;

            const sId = Number(senderId(m));
            const rId = Number(m.recipient);

            const isCurrentThread =
                (sId === Number(selectedUser.value.id) && rId === Number(me.value.id)) ||
                (sId === Number(me.value.id) && rId === Number(selectedUser.value.id));

            if (isCurrentThread) {
                messages.value.push(m);
                scrollToBottom();
            }
        });
});
</script>
