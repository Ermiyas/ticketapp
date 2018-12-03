<template>
  <div id="home">
    <div class="tickets">
      <draggable v-model="items" :options='{ ghostClass: "ghost" }'>
          <component v-for='(item, index) in items' :key='item.id' :index='index' :data='item' :is='item.type' @openTask='showTask($event, true)'/>
      </draggable>
    </div>
    <task :show='isTaskOpen' v-if='isTaskOpen' :data='openTask' @show-task='showTask({}, false)' />
  </div>
</template>

<script>
import Ticket from './components/Ticket'
import TicketStruct from './structs/ticket.ts'
import draggable from 'vuedraggable'
import Divider from './components/Divider'
import DividerStruct from './structs/divider.ts'
import TaskView from './components/Task'
import CommentStruct from './structs/comment.ts'

export default {
  data() {
    return {
      items: [],
      isTaskOpen: false,
      openTask: {}
    }
  },
  components: {
    'ticket': Ticket,
    draggable,
    'ticket-divider': Divider,
    'task': TaskView
  },
  created() {
    this.items.push(new TicketStruct('#12321', 'This is a cool task', 'this task require a lot of fun to accomplish', 0, [new CommentStruct("#123131", "This is a first comment", "weseli", Date.now()), new CommentStruct("#1237771", "This is a second comment", "weseli", Date.now()), new CommentStruct("#12399", "Why are you saying that?", "no way", Date.now())]))
    this.items.push(new TicketStruct('#999', 'Hurry up', 'i have hight priority', 2, []));
    this.items.push(new TicketStruct('#9991', 'Another?', 'i havey', 1, []));
    this.items.push(new TicketStruct('#9992', 'Seriously?', 'What the fuck?', 2, []));
    this.items.push(new DividerStruct('#awdwad', 'Today'));
  },
  methods: {
    showTask(task, open) {
      this.openTask = task;
      this.isTaskOpen = open;
    }
  }
}
</script>

<style>
#home {
  padding: 50px 0;
  width: 100%;
  height: 100%;
}
.tickets {
  width: 40%;
  margin: auto;
}
.ghost {
  height: 0;
  opacity: 0;
}

</style>
