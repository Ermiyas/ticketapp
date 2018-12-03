<template>
  <div class="dialog" @click='hide($event)'>
    <div class="middle">
      <div class="message-box" @click='cancelHide($event)'>
        <div class="title" @click='toggleEdit("editTitle")'>
          <input type="text" v-if='editTitle' ref="editTitle" @blur='toggleEdit("editTitle")' v-model='data.title'>
          <h2 v-if='!editTitle'>{{ data.title }}</h2>
        </div>
        <div class="done">
          <div class="done-btn" :style='doneStyle' @click="done">
            <span>{{ doneText }}</span>
          </div>
        </div>
        <div class="priority">
          <div class="dot" :style='dotStyle'></div>
          <p class="priority-text">{{ priorityText }}</p>
        </div>
        <div class="description">
          <div class="border">
            <textarea name="description" v-model='data.value'></textarea>
          </div>
        </div>
        <div class="comments">
          <div class="create">
          </div>
          <comment v-for='(comment, index) in data.comments' :data='comment' :key='comment.id'  :index='index'></comment>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import TicketStruct from '../structs/ticket.ts'
import Comment from './Comment'

export default {
  data() {
    return {
      editTitle: false,
      editDescription: false
    }
  },
  props: ['show', 'data'],
  methods: {
    hide(event) {
      this.$emit('show-task', false);
    },
    cancelHide(event) {
      event.stopPropagation();
    },
    done() {
      this.data.done = !this.data.done;
    },
    toggleEdit(what) {
      this[what] = !this[what];
      this.$nextTick(()=> {
        if (this[what]) {
          this.$refs[what].focus();
        }
      });
    }
  },
  computed: {
    doneStyle() {
      let done = this.data.done;
      return {
        border: done ? "1px solid green" : "1px solid grey",
        color: done ? "green" : "grey"
      }
    },
    doneText() {
      return this.data.done ? "Done!" : "Mark as done";
    },
    dotStyle() {
      return {
        backgroundColor: this.data.priorityColor()
      }
    },
    priorityText() {
      let msg = "";
      switch(this.data.priority) {
        case 0:
          msg = "It's all chill";
          break;
        case 1:
          msg = "Let's do this";
          break;
        case 2:
          msg = "Burning 🔥🔥🔥";
          break;
      }
      return msg;
    }
  },
  components: {
    'comment': Comment,
  }
}
</script>
<style scoped>
.dialog {
  width: 100%;
  background-color: rgba(0, 0, 0, 0.363);
  height: 100%;
  position: absolute;
  z-index: 2;
  top: 0;
  left: 0;
  display: table;
}
.middle {
  display: table-cell;
  vertical-align: middle;
}
.message-box {
  position: relative;
  z-index: 3;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
  height: 500px;
  background-color: white;
  border-radius: 12px;
  padding: 4px 20px;
  text-align: left;
}
div {
  box-sizing: border-box;
}
.title {
  padding: 1px 20px;
  float: left;
  max-width: 65%;
}
h2 {
  margin: 19px 0 19px 0;
}
.title input {
  display: block;
  font-size: 1.5em;
  margin: 19px 0 19px 0;
  border: none;
  font-weight: bold;
  width: 90%;
}
.done {
  text-align: center;
  float: right;
  padding: 13px 20px;
}
.done-btn {
  padding: 7px;
  min-width: 115px;
}
.done-btn:hover {
  cursor: pointer;
  opacity: 0.8;
}
.priority {
  width: 100%;
  float: left;
  padding: 0 30px;
  text-align: center;
}
.priority .dot {
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 50%;
}
.priority-text {
  display: inline-block;
  margin: 0 0 0 6px;
}
.description {
  width: 100%;
  display: inline-block;
  padding: 10px 12px;
  height: 65%;
}
.description textarea {
  width: 100%;
  height: 100%;
  resize: none;
  box-sizing: border-box;
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  outline: none;
  border: none;
}
.border {
  width: 100%;
  height: 100%;
  border-radius: 5px;
  box-sizing: border-box;
  border: 1px solid black;
  padding: 10px;
}
</style>

