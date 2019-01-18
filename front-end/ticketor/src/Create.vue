<template>
  <div id="create">
    <form class="form">
      <input class="input" type="text" name="title" value="" placeholder="Title">
      <textarea class="input" name="value" placeholder="Describe your task here"></textarea>
      <p class="text"> Priority: </p>
      <label class="radioOption">
        <span>Chill ✨</span>
        <input type="radio" name="priority" value="0">
        <span class="checkmark"></span>
      </label>
      <label class="radioOption">
        <span>Let's do this 💪</span>
        <input type="radio" name="priority" value="1">
        <span class="checkmark"></span>
      </label>
      <label class="radioOption">
        <span>Burning 🔥</span>
        <input type="radio" name="priority" value="2">
        <span class="checkmark"></span>
      </label>
      <div @click='tryCreate()' class="create-btn">Task it!</div>
      <input type="hidden" name="createTask" value="true">
    </form>
  </div>  
</template>
<script>
import G from './ext/globals.js'
import { EventBus } from "./ext/eventBus.js"

export default {
  methods: {
    postForm(jForm, path) {
      G.api(path, jForm.serialize()).then(
        response => {
          // LOGIN success
        },
        (text, error) => {
          EventBus.$emit("popError", text);
        }
      )
    },
    tryCreate() {
      EventBus.$emit('createTask', $("#create form"));
      return;
      this.postForm($("#create form"), "/create_task.php");
    }
  }
}
</script>
<style lang="scss" scoped>
* {
  box-sizing: border-box;
}

#create {
  width: 100%;
  height: 100%;
  padding: 50px 0;

  .form {
    border: 1px black solid;
    width: 50%;
    margin: auto;
    padding: 20px;

    textarea {
      width: 60%;
      margin: auto;
      resize: none;
      height: 200px;
    }

    input[type="text"] {
      border-top: none;
      border-left: none;
      border-right: none;
      margin-bottom: 10px;
      border-bottom: black 1px solid;
      height: 30px;
      font-size: 16px;
      width: 30%;
      display: block;
      margin: 0 auto 15px auto;
      outline: none; 
    }

    .create-btn {
      border: 1px solid grey;
      color: grey;
      padding: 7px;
      min-width: 115px;
      width: max-content;
      padding: 10px 25px;
      margin: auto;
      margin-top: 10px; 
    }

    .create-btn:hover {
      cursor: pointer;
      opacity: 0.8;
    }

    .radioOption {
      display: inline-block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      user-select: none;

      input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
      }

      .checkmark {
        position: absolute;
        top: 1px;
        left: 12px;
        height: 15px;
        width: 15px;
        background-color: #eee;
        border-radius: 50%;
      }

      input:checked ~ .checkmark {
        background-color: #280647;
      }

      input:checked ~ .checkmark:after {
        display: block;
      }
    }
    .radioOption:hover input:not(:checked) ~ .checkmark {
      background-color: #ccc;
    }
  }
}

</style>
