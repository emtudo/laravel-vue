<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'layout-menu-right',

  computed: {
    ...mapGetters(['userIsLogged', 'currentUser', 'twoFactorIsValid', 'twoFactorIsActive'])
  },

  methods: {
    ...mapActions(['logout', 'disabledTwoFactor']),
    doDisabledTwoFactor () {
      this.disabledTwoFactor()
        .then((data) => {
          this.$toast.success('Two factor desativado!')
        })
        .catch((data) => {
          console.log('error', data)
        })
    },
    doLogout () {
      this.logout().then(() => {
        this.$router.push({name: 'auth.login'})
      })
    }
  }
}
</script>

<template>
  <!-- Right Side Of Navbar -->
  <ul class="navbar-nav ml-auto">
      <!-- Authentication Links -->
      <template v-if="!userIsLogged">
        <li>
          <router-link class="nav-link" :to="{name: 'auth.login'}">Login</router-link>
        </li>
        <li>
          <router-link  class="nav-link" :to="{name: 'auth.register'}">Cadastrar</router-link>
        </li>
      </template>
      <template v-if="userIsLogged">
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ currentUser.name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <router-link v-if="!twoFactorIsActive || twoFactorIsValid"  class="dropdown-item" :to="{name: 'perfil'}">Profile</router-link>
              <router-link v-if="!twoFactorIsActive"  class="dropdown-item" :to="{name: 'auth.two_factor'}">Ativar two factor</router-link>
              <a v-if="twoFactorIsActive && twoFactorIsValid" class="dropdown-item" href="#" @click.prevent="doDisabledTwoFactor()">
                  Desativar two factor
              </a>
                <a class="dropdown-item" href="#" @click.prevent="doLogout()">
                    Sair
                </a>

                <form id="logout-form" action="/auth/logout" method="POST" style="display: none;">
                </form>
            </div>
        </li>
      </template>
    </ul>
</template>
