<template>
    <div >
        <ul>
            <li v-for="thread in threads" v-text="thread"></li>
        </ul>

        <input type="text" v-model="newThread" @blur="addThread" @keydown="typing">
    </div>
</template>

<script>
    export default {
        data() {
            return {
                threads: [],
                newThread: ''
            };
        },

        created() {
            axios.get('/threads').then(response => (this.threads = response.data));

            window.Echo.channel('threads').listen('ThreadCreated', e=> {
                this.threads.push(e.thread.title);
            })
            .listenForWhisper('typing', e=> {
                alert('somebody is typing');
            });
        },

        methods: {

            typing() {
                window.Echo.channel('threads')
                    .whisper("typing", {
                        name:"mmghunaim"
                    });
            },

            addThread(){
                axios.post('/threads', { title: this.newThread });

                this.threads.push(this.newThread);
                this.newThread = '';
            }
        }
    }
</script>
