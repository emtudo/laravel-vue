<script>
import { mapGetters } from 'vuex'

export default {
  name: 'layout-menu',

  computed: {
    ...mapGetters(['twoFactorIsValid', 'userIsAdmin'])
  }
}
</script>

<template>
  <ul class="navbar-nav mr-auto" v-if="userIsAdmin && twoFactorIsValid">
    <li class="nav-item dropdown">
      <router-link class="nav-link" :to="{name: 'users.index'}"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Usuários
      </router-link>
    </li>
  </ul>
</template>
