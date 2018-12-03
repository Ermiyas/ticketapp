<template>
  <div class="comment">
    <div class="name">
      <div class="circle" :style='displayOwner'></div>
    </div>
    <div class="text">
      <span>{{ data.value }}</span>
    </div>
    <div class="date">
     <span>{{ data.displayDate() }}</span>
    </div>
  </div>
</template>
<script>
export default {
  props: ["data"],
  computed: {
    displayOwner() {
      let count = 0;
      for (let i = 0; i < this.data.owner.length; i++) {
        let char = this.data.owner.charCodeAt(i);
        count += i % 2 === 0 ? char : -char;
      }
      let hue = Math.floor((count % 361) / 10) * 10;
      return {
        backgroundColor: "hsl(" + hue + ", 50%, 50%)"
      }
    }
  }
}
</script>
<style scoped>
.comment {
  width: 100%;
  height: 30px;
  max-height: 30px;
  box-sizing: border-box;
  padding: 5px 5px;
  font-size: 14px;
}
.name {
  float: left;
  margin-right: 5px;
}
.text {
  float: left;
}
.date {
  float: right;
  color: rgba(105, 103, 103, 0.664);
}
.circle {
  border-radius: 50%;
  width: 8px;
  height: 8px;
  position: relative;
  top: 4px;
}
</style>
