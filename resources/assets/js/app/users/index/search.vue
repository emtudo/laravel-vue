<script>
export default {
  name: 'users-index-search',

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
  mounted () {
    this.search = this.value
    this.mounted = true
  },
  updated () {
    this.search = this.value
  },
  props: {
    value: {}
  },
  watch: {
    search: {
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
  <div class="card-header">
    <form @submit.prevent="$emit('filter')">
      <div class="row">
        <div class="col-md-6">
          <f-text label="Nome" name="name" v-model="search.name" :maxlength="50"></f-text>
        </div>

        <div class="col-md-6">
          <f-text label="Email" name="name" v-model="search.email"></f-text>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <label for="is_admin" class="col-md-12 col-form-label">Tipo de usuário</label>
          <select v-model="search.is_admin" name="is_admin" id="is_admin" class="form-control">
            <option value="">Todos</option>
            <option value="true">Administradores</option>
            <option value="false">Comum</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="trashed" class="col-md-12 col-form-label">Status</label>
          <select v-model="search.trashed" name="trashed" class="form-control">
            <option value="">Ativos</option>
            <option value="only">Suspensos</option>
            <option value="with">Todos</option>
          </select>
        </div>
      </div>

      <div class="form-group row mb-0">
          <div class="col-md-2 offset-md-10">
              <button class="btn btn-warning" type="submit">
                  Filtrar
              </button>
          </div>
      </div>
    </form>
  </div>
</template>
