<template>
  <div class="ticket">
    <div class="title"> 
      <span>{{ data.title }}</span>
    </div>
    <div class="description">
      <span>{{ data.value }}</span>
    </div>
    <div class="priority">
      <div class="priority-sign" :style='priorityStyle'>
      </div>
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
      let color = "";
      switch (this.data.priority) {
        case 0:
        color = "blue";
        break;
        case 1:
        color = "yellow";
        break;
        case 2:
        color = "red";
        break;
      }
      return {
        backgroundColor: color
      }
    }
  },
  props: ['data']
}
</script>
<style scoped>
.ticket {
  box-shadow: 0px 0px 3px 0px rgba(0,0,0,0.57);
  width: 100%;
  height: 70px;
  padding: 10px;
  text-align: left;
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
</style>
