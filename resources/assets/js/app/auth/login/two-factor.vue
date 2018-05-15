<script>
import { mapActions } from 'vuex'
import { isEmpty } from 'lodash'

export default {
  name: 'auth-login-two-factor',

  data () {
    return {
      active: false,
      errors: {},
      code: null,
      timeout: true
    }
  },
  methods: {
    ...mapActions(['setupJWT', 'activeTwoFactor', 'updateUserData', 'updateTwoFactorValid']),
    setVerifyOk ({token, user}) {
      Promise.all([
        this.setupJWT(token),
        this.updateUserData(user)
      ])
        .then(() => {
          this.$router.push({name: 'home'})
        })
    },
    doActive () {
      this.$resource.post('active')
        .then(({data}) => {
          this.timeout = false
          this.active = true
          this.updateTwoFactorValid(false)
          this.activeTwoFactor()
        })
        .catch(() => {
          this.error = true
        })
    },
    verify () {
      if (isEmpty(this.code)) {
        return
      }
      if (this.code.length === 6) {
        this.doSend()
      }
    },
    doSend () {
      this.$resource.post('verify', {code: this.code})
        .then(({data}) => {
          this.setVerifyOk(data)
        })
        .catch(({data}) => {
          this.errors = data
        })
    }
  },
  mounted () {
    this.doActive()
  },

  resourcePath: 'auth/two_factor/'
}
</script>

<template>
  <page title="Two Factor: Informe o código">
    <form @submit.prevent="doSend()">
      <div class="form-group row">
        <div class="col-md-8 offset-md-4" v-if="!active">
          Aguarde, solicitando ativação!
        </div>
        <div class="col-md-6 offset-md-4" v-if="active">
          <f-text @input="verify" v-model="code" name="code" label="Código" :error="errors['code']" :maxlength="6" />
        </div>
      </div>
      <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
          <button type="submit" class="btn btn-success">
              Verificar
          </button>
          <button type="button" class="btn btn-primary disabled" v-if="!timeout">
              Reenviar código <countdown :value="60" v-if="!timeout" @timeout="timeout=true"></countdown>
          </button>
          <button @click.prevent="doActive()" type="button" class="btn btn-primary"  v-if="timeout">
              Reenviar código
          </button>
        </div>
      </div>
    </form>
  </page>
</template>
