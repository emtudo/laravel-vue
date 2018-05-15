<script>
import LayoutHeader from './header/header'
import LayoutMain from './main'

export default {
  name: 'app',

  components: {
    LayoutHeader,
    LayoutMain
  }
}
</script>

<template>
  <div id="app">
    <layout-header></layout-header>
    <layout-main></layout-main>
  </div>
</template>

<style>
.footer {
    position: fixed;
    bottom: 0;
}
</style>
