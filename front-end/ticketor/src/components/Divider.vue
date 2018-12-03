<template>
  <div class="ticket-divider">
    <div class="visible">
      <span class="text"> {{ data.value }} </span>
    </div>
  </div>
</template>
<script>
export default {
  props: ['data']
}
</script>
<style scoped>
.ticket-divider {
  position: relative;
  width: 100%;
  padding: 15px 0;
}

.visible {
  height: 8px;
  border-radius: 10px;
  background-color: black;
}

.text {
  top: 9px;
  color: black;
  left: 60px;
  padding: 0 10px;
  position: absolute;
  background-color: white;
}
</style>
