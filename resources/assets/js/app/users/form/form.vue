<script>
import UsersUser from './user'
import { get, isEmpty } from 'lodash'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'users-form-form',

  components: {
    UsersUser
  },
  computed: {
    ...mapGetters(['currentUser']),
    ...mapGetters({loading: 'app/users/loading'}),
    title () {
      if (get(this.user, 'id', null)) {
        return 'Editar usuário: ' + this.userName
      }

      return 'Cadastro de usuários'
    }
  },

  data () {
    return {
      showFooter: true,
      role: true,
      mounted: false,
      errors: {},
      requiredPassword: true,
      userName: null,
      user: {
        name: null,
        email: null,
        is_admin: false,
        password: null,
        password_confirmation: null
      }
    }
  },
  methods: {
    ...mapActions(['updateUserData']),
    ...mapActions({
      'saveUser': 'app/users/saveUser',
      'bootLoad': 'app/users/bootLoad',
      'find': 'app/users/find'
    }),

    doSave () {
      if (!this.passwordIsValid()) {
        return this.$toast.warning('As senhas não conferem!')
      }
      this.saveUser(this.user)
        .then((data) => {
          if (this.currentUser.id === this.user.id) {
            this.updateUserData(data)
          }

          this.$router.push({name: 'users.index'})
        })
        .catch((data) => {
          console.log('errors', data)
          this.errors = data
        })
    },
    passwordIsValid () {
      if (isEmpty(this.user.password) && isEmpty(this.user.password_confirmation)) {
        return true
      }
      return this.user.password === this.user.password_confirmation
    }
  },
  mounted () {
    const id = get(this.$route, 'params.id', null)

    if (id) {
      this.requiredPassword = false
      this.find(id)
        .then((user) => {
          this.user = user
          this.mounted = true
        })
        .catch(() => {
        })
    } else {
      this.mounted = true
    }
  }
}
</script>

<template>
  <page :title="title" v-if="mounted">
    <users-user :role="role" @save="doSave" v-if="!loading" v-model="user" :errors="errors" :required-password="requiredPassword"></users-user>
    <template slot="footer" v-if="showFooter">
      <router-link class="btn btn-xs btn-success" :to="{ name: 'users.index' }">
        <i class="fa fa-users"> Lista de usuários</i>
      </router-link>
    </template>
  </page>
</template>
