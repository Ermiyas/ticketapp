<template>
  <div id="app">
    <div id="menu" :class='resizeMenu'>
      <div class="menu-btn" @click='toggleMenu'>
        <span class="dot"></span>
      </div>
      <transition name="fade">
        <div class="full-menu" v-if='menuOpened'>
          <ul>
            <li @click="takeMe('/tasks')">
              <span>- Tasks -</span>
            </li>
            <li @click="takeMe('/create')">
              <span>- Create -</span>
            </li>
            <li @click="logout()">
              <span>- Sign out -</span>
            </li>
          </ul>
        </div>
      </transition>
    </div>
    <div id="page-view">
      <router-view :user='user' :logged='loggedIn'></router-view>
    </div>
    <div class="errorsHolder">
        <div class="errorMsg" v-for="error in errors" :key="error.id">
          <span class="cross" @click="removeError(error.id)">x</span>
          <span>{{ error.msg }}</span>
        </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "./ext/eventBus.js"

export default {
  name: 'app',
  data() {
    return {
      menuOpened: false,
      errors: [],
      loggedIn: false,
      user: {}
    }
  },
  created() {
    EventBus.$on("popError", msg => {
      this.popErrorMsg(msg);
    });

    EventBus.$on("login", user => {
      this.loggedIn = true;
      this.user = user;
      this.takeMe("/tasks");
    });

    EventBus.$on("logout", () => {
      this.loggedIn = false;
      this.user = {};
      this.takeMe("/login");
    })

    EventBus.$on()

    this.takeMe("/login")
  },
  methods: {
    toggleMenu() {
      this.menuOpened = !this.menuOpened;
    },
    logout() {
      EventBus.$emit("logout");
    },
    takeMe(to) {
      if (to !== "/login" && (!this.loggedIn || Object.keys(this.user) === 0)) {
        EventBus.$emit("popError", "You are not logged in");
        this.$router.push("/login");
        return;
      }
      this.$router.push(to);
    },
    guid() {
      function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
          .toString(16)
          .substring(1);
      }
      return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
    },
    removeError(id) {
      this.errors.splice(this.errors.find( error=> { return error.id === id }),1);
    },
    popErrorMsg(msg) {
      let cache = {msg: msg, id: this.guid()};
      this.errors.push(cache);
      setTimeout(()=> {
        this.errors.splice(this.errors.find( error=> { return error.id === cache.id }),1);
      }, 10000)
    }
  },
  computed: {
    resizeMenu() {
      return this.menuOpened ? "opened" : "closed";
    }
  }
}
</script>
<style>
body {
  margin: 0;
}
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: black;
  margin: auto;
  width: 100%;
  height: 100%;
  padding: 0 0 0 50px;
}
#page-view {
  float: left;
  width: calc(100vw - 50px);
  box-sizing: border-box;
  height: 100vh;
  max-height: 100vh;
  overflow: hidden;
  position: relative;
}
#menu {
  position: absolute;
  float: left;
  left: 0;
  width: 50px;
  max-width: 200px;
  box-sizing: border-box;
  height: 100vh;
  max-height: 100vh;
  background-color: rgb(40, 6, 71);
  transition: width 0.3s;
  top: 0;
  z-index: 10;
}
#menu.opened {
  width: 130px;
}
#menu.closed {
  width: 50px;
}
.full-menu ul {
  list-style-type: none;
  margin: 0;
  padding: 0px;
}
.menu-btn {
  position: relative;
  width: 50px;
  height: 50px;
}
.menu-btn:hover {
  cursor: pointer;
  opacity: 0.8;
}
#menu .dot {
  position: relative;
  width: 10px;
  display: inline-block;
  box-shadow: 0px 0px 3px 0px rgba(0,0,0,0.57);
  height: 10px;
  top: 15px;
  border-radius: 50%;
  background-color: yellow;
}
.full-menu {
  color: rgb(255, 255, 0);
}
.full-menu li {
  display: block;
  width: 100%;
  padding: 10px 10px;
  box-sizing: border-box;
}
.full-menu li:hover {
  background-color: rgba(172, 169, 192, 0.11);
  cursor: pointer;
}
.full-menu span {
  color: rgb(155, 144, 211);
}

.fade-enter-active {
  transition: opacity 1s;
}
.fade-leave-active {
  transition: opacity .2s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

.errorsHolder {
  position: absolute;
  bottom: 50px;
  right: 45px;
  z-index: 99999;
}

.errorMsg {
  padding: 25px 40px;
  margin-top: 10px;
  background-color: #d33051;
  border-radius: 12px;
  border: 1px red solid;
  text-align: center;
  position: relative;
}

.errorMsg .cross {
  position: absolute;
  right: 10px;
  top: 5px;
  font-size: 20px;
}

.errorMsg .cross:hover {
  cursor: pointer;
  text-decoration: underline;
}
</style>
