<script>
import UsersSearch from './search'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'users-users-index',

  components: {
    UsersSearch
  },

  computed: {
    ...mapGetters(['currentUser']),
    ...mapGetters({
      'users': 'app/users/sortedUsers',
      'currentSearch': 'app/users/search'
    })
  },

  data () {
    return {
      mounted: false,
      search: {
        name: null,
        email: null,
        is_admin: null,
        trashed: null
      }
    }
  },
  methods: {
    ...mapActions({
      'setUsers': 'app/users/setUsers',
      'doLoad': 'app/users/bootLoad',
      'updateUser': 'app/users/updateUser',
      'doActive': 'app/users/active',
      'doDelete': 'app/users/delete',
      'doSuspend': 'app/users/suspend',
      'setSearch': 'app/users/setSearch'
    })
  },
  mounted () {
    this.search = this.currentSearch
    this.doLoad()
    this.mounted = true
  },
  watch: {
    search: {
      handler (values) {
        this.setSearch(values)
      },
      deep: true
    }
  }
}
</script>

<template>
  <page title="Lista de usuários">
    <div class="form-group row">
        <div class="col-md-12">
          <div class="card">
              <users-search v-if="mounted" v-model="search" @filter="doLoad"></users-search>
          </div>
        </div>
    </div>

    <div class="form-group row">
      <div class="col-md-3">Usuário</div>
      <div class="col-md-4">Email</div>
      <div class="col-md-2">Status</div>
      <div class="col-md-3">Ações</div>
    </div>

    <div class="form-group row" v-for="user in users" :key="user.id">
      <div class="col-md-3">{{ user.name }}</div>
      <div class="col-md-4">{{ user.email }}</div>
      <div class="col-md-2">{{ user._parsed.status }}</div>
      <div class="col-md-3">
        <router-link class="btn btn-sm btn-success" :to="{ name: 'users.edit', params: {id: user.id} }"><i class="fa fa-edit"></i></router-link>
        <a v-if="user.id !== currentUser.id && !user.deleted_at" @click.prevent="doSuspend(user)" title="Suspender" class="btn btn-sm btn-warning" href="#"><i class="fa fa-ban"></i></a>
        <a v-if="user.deleted_at" @click.prevent="doActive(user)" title="Ativar" class="btn btn-sm btn-warning" href="#"><i class="fa fa-check"></i></a>
        <a v-if="user.id !== currentUser.id" @click.prevent="doDelete(user)" title="Excluir" class="btn btn-sm btn-danger" href="#"><i class="fa fa-trash"></i></a>
      </div>
    </div>
    <template slot="footer">
      <router-link class="btn btn-xs btn-success" :to="{ name: 'users.create' }">
        <i class="fa fa-plus"> Adicionar</i>
      </router-link>
    </template>
  </page>
</template>
