<script>
import { mapGetters } from 'vuex'
import LayoutMenuLeft from './menu-left'
import LayoutMenuRight from './menu-right'

export default {
  name: 'layout-header',

  components: {
    LayoutMenuLeft,
    LayoutMenuRight
  },

  computed: {
    ...mapGetters(['userIsLogged'])
  }
}
</script>

<template>
  <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
      <div class="container">
          <a class="navbar-brand" href="/">
              Emtudo Skeleton
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <layout-menu-left v-if="userIsLogged"></layout-menu-left>
            <layout-menu-right></layout-menu-right>
          </div>
      </div>
  </nav>
</template>
