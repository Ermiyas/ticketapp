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
            <li @click="takeMe('/logout.php')">
              <span>- Sign out -</span>
            </li>
          </ul>
        </div>
      </transition>
    </div>
    <div id="page-view">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>

export default {
  name: 'app',
  data() {
    return {
      menuOpened: false
    }
  },
  created() {
    this.takeMe("/tasks")
  },
  methods: {
    toggleMenu() {
      this.menuOpened = !this.menuOpened;
    },
    takeMe(to) {
      this.$router.push(to);
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
</style>
