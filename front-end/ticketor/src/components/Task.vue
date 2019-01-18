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
        <div class="comments-hover" @mouseenter='commentSectionExpanded = true' @mouseleave='commentSectionExpanded = false' :class='commentClass'>
          <transition name="fade">
            <div class="create" v-if='commentSectionExpanded'>
              <input type="text" name="comment" v-model='newComment'>
              <div class="submitComment" @click="addComment">
                Comment
              </div>
            </div>
          </transition>
        </div>
        <div class="comments">
          <comment v-for='(comment, index) in data.comments' :data='comment' :key='comment.id'  :index='index'></comment>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import TicketStruct from '../structs/ticket.ts'
import Comment from './Comment'
import CommentStruct from '../structs/comment.ts'

export default {
  data() {
    return {
      editTitle: false,
      editDescription: false,
      newComment: "",
      commentSectionExpanded: false
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
    },
    addComment() {
      this.data.comments.push(new CommentStruct("#xxxx" + this.data.comments.length, this.newComment, "weseli", Date.now()));
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
    },
    commentClass() {
      return this.commentSectionExpanded ? "expanded" : "contracted";
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
  height: 650px;
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
.comments {
  height: 120px;
  overflow-y: auto;
}
.border {
  width: 100%;
  height: 100%;
  border-radius: 5px;
  box-sizing: border-box;
  border: 1px solid black;
  padding: 10px;
}
.comments-hover {
  padding: 5px 10px;
  height: 20px;
  transition: height .6s;
  display: inline-block;
  width: 100%;
}
.comments-hover.expanded {
  height: 30px;
}
.fadeN-enter, fadeN-leave-to {
  opacity: 0;
  transition: opacity 0.5s;
}
.fade-enter-active {
  transition: opacity 1s;
}
.fade-leave-active {
  transition: opacity .2s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
.create input {
  outline: none;
  border-top: none;
  border-left: none;
  border-right: none;
  float: left;
  border-bottom: 1px solid black;
}
.create .submitComment {
  float: right;
  border: 1px solid grey;
  color: grey;
  padding: 5px 10px;
  position: relative;
  bottom: 8px;
}
.create .submitComment:hover {
  cursor: pointer;
  opacity: 0.8;
}
</style>

