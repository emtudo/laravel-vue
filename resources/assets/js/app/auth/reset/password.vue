<script>
import { mapActions } from 'vuex'
import { get } from 'lodash'
import sessionStorage from '@/helpers/sessionStorage'

export default {
  name: 'auth-reset-password',

  data () {
    return {
      reset: {
        password: null,
        password_confirmation: null,
        email: null,
        token: null
      },
      errors: {}
    }
  },
  methods: {
    ...mapActions(['setupJWT', 'updateUserData']),
    setUserAndToken ({token, user}) {
      sessionStorage.set('remember', true)
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
    doReset () {
      if (this.reset.password !== this.reset.password_confirmation) {
        this.errors = {
          password_confirmation: 'A senhas não conferem'
        }

        return
      }

      this.$resource.post('', this.reset)
        .then(({data}) => {
          this.setUserAndToken(data)
        })
        .catch(({data, meta}) => {
          this.$toast.error(get(meta, 'message', 'Ocorreu um erro'))
          this.errors = data
        })
    }
  },
  mounted () {
    this.reset.token = get(this.$route, 'params.token', '')
  },

  resourcePath: 'auth/password/reset'
}
</script>

<template>
  <page title="Defina uma senha para acesso:">
    <form v-on:submit.prevent="doReset()">
      <div class="form-group">
        <f-text :error="errors['email']" v-model="reset.email" name="email" type="email" label="Email" :required="true" />
      </div>
      <div class="form-group">
        <f-text :error="errors['password']" v-model="reset.password" type="password" name="password" label="Senha" :required="true" />
      </div>
      <div class="form-group">
        <f-text :error="errors['password_confirmation']" v-model="reset.password_confirmation" type="password" name="password_confirmation" label="Confirmar a senha" :required="true" />
      </div>
      <div class="form-group">

      </div>
      <div class="form-group">
          <button class="btn btn-primary" type="submit">Salvar</button>
      </div>
    </form>
  </page>
</template>
