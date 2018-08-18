<template>
  <div>
    <h1>Chat</h1>
    <div class="row">
      <div class="col-lg-4">
        <ul class="list-group users">
          <li class="list-group-item" v-for="user in users">{{ user.name }}</li>
        </ul>
      </div>
      <div class="col-lg-8">
        <div class="messages-area">
          <div class="messages">
            <div class="message" v-for="message in messages">{{ message }}</div>
          </div>
          <div class="preview">{{ message }}</div>
          <div class="message">
            <input type="text" @keyup.enter="sendMessage" class="form-control" placeholder="Message.." v-model="message">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data: function() {
      return {
        message: '',
        users: [],
        messages: [],
      }
    },
    created: function() {
      this.getUsers();
    },
    methods: {
      getUsers: function() {
        axios.get('/api/users', this.$data).then(response => {
          for (let i = 0; i < response.data.length; i++) {
            this.users.push(response.data[i]);
          }
        }).catch(err => console.log(err));
      },
      sendMessage: function() {
        if (this.message !== '') {
          this.messages.push(this.message);
          this.message = '';
        }
      }
    }
  }
</script>
<style>
  .messages {
    height: 500px;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 3px;
    margin-bottom: 10px;
    overflow-y: scroll;
  }
  .messages .message {
    margin: 10px;
    padding: 10px;
    border-radius: 3px;
    background: #f5f8fa;
    border: 1px solid #ebf2f7;
  }
  .preview {
    margin-bottom: 10px;
  }
</style>
