<template>
  <div class="loginPage">
    <div class="bckground">
      <div class="forms">
        <div v-if='login' class="login">
          <form class="form">
            <input type="text" v-model='loginData.username' name="username" placeholder="username">
            <input type="password" v-model='loginData.password' name="pwd" placeholder="password">
            <div @click='tryLogin()' class="do-btn">login</div>
          </form>
        </div>
        <div class="register" v-if='!login'>
          <form class="form">
            <input type="text" v-model='registerData.username' name="username" placeholder="username">
            <input type="password" v-model='registerData.password' name="pwd" placeholder="password">
            <input type="password" v-model='registerData.passwordRepeat' name="pwdrepeat" placeholder="repeat your password">
            <label class="radioOption">
              <span>Buržo</span>
              <input type="radio" name="role" value="burzo">
              <span class="checkmark"></span>
            </label>
            <label class="radioOption">
              <span>Proletár</span>
              <input type="radio" name="role" value="proletar">
              <span class="checkmark"></span>
            </label>
            <div @click='tryRegister()' class="do-btn">register</div>
          </form>
        </div>
        <div class="redirect">
          <span class="link" v-if='login' @click='login = false'>Register</span>
          <span class="link" v-if='!login' @click='login = true'>Login</span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import G from "./ext/globals.js"
import { EventBus } from "./ext/eventBus.js"

export default {
  data: () => {
    return {
      login: true,
      loginData: {
        username: "",
        password: "",
      },
      registerData: {
        username: "",
        password: "",
        passwordRepeat: "",
        role: ""
      }
    }
  },
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
    tryRegister() {
      this.postForm($(".register .form"), "/signup.inc.php");
    },
    tryLogin() {
      this.postForm($(".login .form"), "/login.inc.php");
    },
  },
  computed: {
  }
}
</script>
<style lang="scss" scoped>
* {
  box-sizing: border-box;
}

.loginPage {

  .bckground {
    width: 100vw;
    height: 100vh;
    background-color: white;    
  }

  .redirect {
    margin: auto;
    text-align: center;
  }

  .link {
    text-decoration: underline;
    color: rgb(10, 134, 172);
  }
  .link:hover {
    cursor: pointer;
  }

  .forms {
    padding: 35px 20px;
    width: 35%;
    border: 1px black solid;
    border-radius: 4px;
    margin: auto;
    position: relative;
    top: 30%;

    .do-btn {
      border: 1px solid grey;
      color: grey;
      padding: 7px;
      min-width: 115px;
      width: max-content;
      padding: 10px 25px;
      margin: auto;
      margin-top: 10px; 
    }

    .do-btn:hover {
      cursor: pointer;
      opacity: 0.8;
    }

    input[type="text"] {
      border-top: none;
      border-left: none;
      border-right: none;
      margin-bottom: 10px;
      border-bottom: black 1px solid;
      height: 30px;
      font-size: 16px;
      width: 50%;
      display: block;
      margin: 0 auto 15px auto;
      outline: none; 
      text-align: center;
    }

    input[type="password"] {
      border-top: none;
      border-left: none;
      border-right: none;
      border-bottom: black 1px solid;
      display: block;
      height: 30px;
      font-size: 16px;
      width: 50%;
      margin: 0 auto 15px auto;
      outline: none;
      text-align: center;
    }

    .redirect {
      position: relative;
      top: 60px;
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

