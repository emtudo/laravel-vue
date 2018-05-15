<script>
import { mapActions, mapGetters } from 'vuex'
import sessionStorage from '@/helpers/sessionStorage'

export default {
  name: 'auth-login-login',

  computed: {
    ...mapGetters(['twoFactorIsActive'])
  },

  data () {
    return {
      errors: {},
      credentials: {
        email: null,
        password: null,
        remember: true
      }
    }
  },

  methods: {
    ...mapActions(['setupJWT', 'updateUserData', 'activeTwoFactor', 'updateTwoFactorValid']),
    setUserAndToken ({token, user}) {
      sessionStorage.set('remember', this.credentials.remember)
      Promise.all([
        this.setupJWT(token),
        this.updateUserData(user)
      ])
        .then(() => {
          if (!user.two_factor.enabled) {
            return this.$router.push({name: 'home'})
          }
          this.$router.push({name: 'auth.two_factor'})
        })
        .catch(() => {
        })
    },
    doLogin () {
      this.$resource.post('', this.credentials)
        .then(({data}) => {
          this.setUserAndToken(data)
        })
        .catch(({data}) => {
          this.$toast.error('Não foi possível autenticar, verifique seus dados!')
        })
    }
  },

  mounted () {
    this.activeTwoFactor(false)
    this.updateTwoFactorValid(false)
  },

  resourcePath: 'auth/login'
}
</script>

<template>
  <page title="Login">
    <form @submit.prevent="doLogin()">
      <div class="form-group offset-md-3">
        <div class="col-md-8">
            <f-text label="Email" name="email" v-model="credentials.email" type="email" autofocus></f-text>
          </div>
      </div>
      <div class="form-group offset-md-3">
        <div class="col-md-8">
            <f-text label="Senha" name="password" v-model="credentials.password" type="password" autofocus></f-text>
        </div>
      </div>
      <div class="form-group offset-md-3">
        <div class="col-md-8">
          <div class="checkbox">
            <label>
                <input type="checkbox" v-model="credentials.remember" name="remember"> Lembre de mim
            </label>
          </div>
        </div>
      </div>
      <div class="form-group offset-md-3">
        <div class="col-md-8">
          <button type="submit" class="btn btn-primary">
            Login
          </button>

          <router-link class="btn btn-link" :to="{name: 'auth.password.email', query: {email: credentials.email}}">
            Esqueceu sua senha?
          </router-link>
        </div>
      </div>
    </form>
  </page>
</template>
