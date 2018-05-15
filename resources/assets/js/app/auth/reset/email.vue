<script>
import { get } from 'lodash'

export default {
  name: 'auth-reset-email',

  data () {
    return {
      errors: {},
      reset: {
        route: null,
        email: null
      }
    }
  },

  methods: {
    doReset () {
      const reset = {...this.reset}
      this.$resource.post('', reset)
        .then(({data}) => {
          this.$toast.success(data.status)
        })
        .catch(({data}) => {
          this.errors = data
        })
    }
  },

  mounted () {
    this.reset.route = document.location.origin + this.$router.resolve({name: 'auth.password.reset', params: {token: '{token}'}}).href
    this.reset.email = this.$route.query.email || null

    this.reset.email = get(this.$route, 'query.email', null)
  },

  resourcePath: 'auth/password/email'
}
</script>

<template>
  <page title="Recuperar senha">
    <form v-on:submit.prevent="doReset()">
      <div class="form-group">
        <f-text v-model="reset.email" type="email" label="Email" name="name" :error="errors['email']" :required="true" />
      </div>
      <div class="form-group">
        <button class="btn btn-primary" type="submit">Recuperar a senha</button>
      </div>
    </form>
  </page>
</template>
