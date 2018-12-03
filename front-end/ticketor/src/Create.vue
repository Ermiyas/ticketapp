<template>
  <div id="create">
    <div class="form">
      <input class="input" type="text" name="title" value="">
      <textarea class="input" name="description" cols="30" rows="10"></textarea>
      <p class="text"> Priority </p>
      <input class="input" type="radio" name="priority" value="Burning">
      <input class="input" type="radio" name="priority" value="Let's do this">
      <input class="input" type="radio" name="priority" value="Chill">
    </div>
  </div>  
</template>
<script>
export default {
  methods: {
    formtoJson() {
      var retVal = {};
      var form = document.querySelector("div.form");
      var inputs = from.querySelectorAll(".input");
      inputs.forEach(input => {
        let key = input.getAttribute("name") || undefined;
        if (key === undefined) throw Error("Undefined name when parsing form to JSON");
        retVal[input.getAttribute("name")] = input.getAttribute("value") || undefined;
      });
      return retVal;
    }
  }
}
</script>
<style scoped>
#create {
  width: 100%;
  height: 100%;
  box-sizing: border-box;
  padding: 50px 0;
  border: 1px solid black;
}
.form {
  border: 1px black solid;
  width: 50%;
  margin: auto;
  padding: 20px;
}
.form input {
  outline: none;
  display: inline-block;
}

</style>
