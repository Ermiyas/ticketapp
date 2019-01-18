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
import { EventBus } from "./ext/eventBus.js"

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
    EventBus.$on("createTask", jForm => {
      let task = {};
      jForm.serializeArray().forEach(item => {
        task[item.name] = item.value;
      });
      this.items.push(new TicketStruct('#' + Date.now(), task.title, task.value, task.priority, []));
    })

    this.items.push(new TicketStruct('#12321', 'This is a cool task', 'this task require a lot of fun to accomplish', 0, []))
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
