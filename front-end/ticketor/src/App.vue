<template>
  <div id="app">
    <div class="tickets">
      <draggable v-model="items" :options='{ ghostClass: "ghost" }'>
        <transition-group>
          <component v-for='(item, index) in items' :key='item.id' :index='index' :data='item' :is='item.type' />
        </transition-group>
      </draggable>
    </div>
  </div>
</template>

<script>
import Ticket from './components/Ticket'
import TicketStruct from './structs/ticket.ts'
import draggable from 'vuedraggable'

export default {
  name: 'app',
  data() {
    return {
      items: []
    }
  },
  components: {
    'ticket': Ticket,
    draggable
  },
  created() {
    this.items.push(new TicketStruct('#12321', 'This is a cool task', 'this task require a lot of fun to accomplish', 0, []))
    this.items.push(new TicketStruct('#999', 'Hurry up', 'i have hight priority', 2, []));
    this.items.push(new TicketStruct('#9991', 'Another?', 'i havey', 1, []));
    this.items.push(new TicketStruct('#9992', 'Seriously?', 'What the fuck?', 2, []));
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
.tickets {
  width: 40%;
  margin: auto;
}
.ghost {
  background-color: #ebebeb;
}

</style>
