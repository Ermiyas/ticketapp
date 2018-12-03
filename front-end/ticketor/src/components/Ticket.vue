<template>
  <div class="ticket" @click='openTask()'>
    <div class="title"> 
      <span>{{ data.title }}</span>
    </div>
    <div class="priority">
      <div class="priority-sign" :style='priorityStyle'>
      </div>
    </div>
    <div class="description">
      <span>{{ data.value }}</span>
    </div>
  </div>
</template>
<script>
export default {
  data () {
    return {
    }
  },
  computed: {
    priorityStyle () {
      return {
        backgroundColor: this.data.priorityColor()
      }
    }
  },
  methods: {
    openTask() {
      this.$emit('openTask', this.data);
    }
  },
  props: ['data']
}
</script>
<style scoped>
.ticket {
  box-shadow: 0px 0px 3px 0px rgba(0,0,0,0.57);
  width: 100%;
  height: 90px;
  padding: 10px;
  box-sizing: border-box;
  text-align: left;
  position: relative;
}
.title {
  font-weight: bold;
  font-size: 16px;
  margin-bottom: 10px;
}
.priority-sign {
  width: 10px;
  height: 10px;
  display: inline-block;
  position: relative;
  border-radius: 50%;
}
.priority {
  position: absolute;
  right: 12px;
  top: 8px;
}
.description {
  overflow: hidden;
}
</style>
