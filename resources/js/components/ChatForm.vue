//resources/js/components/ChatForm.vue
<template>
  //Display an input field and a send button.
  <div class="input-group">
    //Input field.
    <input
      id="btn-input"
      type="text"
      name="message"
      class="form-control input-sm"
      placeholder="Type your message here..."
      v-model="newMessage"
   
      @keyup.enter="sendMessage"
    />
    //Button
    <span class="input-group-btn">
      //Call sendMessage() this button is clicked.
      <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
        Send
      </button>
    </span>
  </div>
</template>
<script>
export default {
  //Takes the "user" props from <chat-form> … :user="{{ Auth::user() }}"></chat-form> in the parent chat.blade.php.
  props: ["user"],
  data() {
    return {
      newMessage: "",
    };
  },
  methods: {
    sendMessage() {
      //Emit a "messagesent" event including the user who sent the message along with the message content
      this.$emit("messagesent", {
        user: this.user,
      //newMessage is bound to the earlier "btn-input" input field
        message: this.newMessage,
      });
      //Clear the input
      this.newMessage = "";
    },
  },
};
</script>
