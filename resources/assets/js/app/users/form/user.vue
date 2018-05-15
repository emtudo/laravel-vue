<script>
import { get } from 'lodash'
import { mapActions, mapGetters } from 'vuex'

const dataUser = (values = {}) => {
  return {
    name: null,
    email: null,
    is_admin: false,
    password: null,
    password_confirmation: null,
    ...values
  }
}

export default {
  name: 'users-form-user',

  computed: {
    ...mapGetters(['currentUser', 'userIsAdmin'])
  },

  data () {
    return {
      mounted: false,
      user: dataUser()
    }
  },
  mounted () {
    this.user = dataUser(this.value)
    this.mounted = true
  },
  updated () {
    this.user = this.value
  },
  props: {
    value: null,
    errors: {
      type: Object,
      default: () => {
        return {}
      }
    },
    role: {
      type: Boolean,
      default: true
    },
    requiredPassword: {
      type: Boolean,
      default: true
    }
  },
  watch: {
    user: {
      handler (value) {
        if (this.mounted) {
          this.$emit('input', value)
        }
      },
      deep: true
    }
  }
}
</script>

<template>
  <div>
    <form @submit.prevent="$emit('save')">
      <div class="form-group row">
        <div class="col-md-6">
          <f-text label="Nome" name="name" v-model="user.name" :error="errors['name']" :required="true" :maxlength="50"></f-text>
        </div>
        <div class="col-md-6">
          <f-text label="Email" type="email" name="email" v-model="user.email" :error="errors['email']" :required="true"></f-text>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-md-6">
          <f-text label="Senha" type="password" name="password" v-model="user.password" :error="errors['password']" :required="requiredPassword"></f-text>
        </div>
        <div class="col-md-6">
          <f-text label="Confirmar senha" type="password" name="password_confirmation" v-model="user.password_confirmation" :error="errors['password_confirmation']"></f-text>
        </div>
      </div>

      <div class="form-group row" v-if="userIsAdmin && role">
          <div class="col-md-4">
          </div>
          <input id="is_admin" v-model="user.is_admin" type="checkbox" name="is_admin"> Administrador
      </div>

      <div class="form-group row mb-0">
          <div class="col-md-8 offset-md-4">
              <button class="btn btn-primary" type="submit">
                  Salvar
              </button>
          </div>
      </div>
    </form>
  </div>
</template>
