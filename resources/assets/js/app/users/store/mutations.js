import { find } from 'lodash'
import { prepareShow } from '../helpers'

const addUser = (state, user) => {
  const users = state.users
  users.push(user)
  state.users = [...users]
}

const updateUser = (state, user, current) => {
  const users = state.users
  const index = users.indexOf(current)

  users[index] = user

  state.users = [...users]
}

export default {
  setErrors (state, values) {
    state.errors = values
  },
  setCurrentUser (state, value) {
    state.user = value
  },
  setUsers (state, values) {
    state.users = values.map(prepareShow)
  },
  setSearch (state, values) {
    state.search = {
      name: null,
      email: null,
      is_admin: null,
      trashed: null,
      ...values
    }
  },
  setFilters (state, values) {
    state.filters = values
  },
  setLoading (state, value) {
    state.loading = value
  },
  setSaving (state, value) {
    state.saving = value
  },
  updateUser (state, user) {
    const current = find(state.users, {id: user.id})
    if (current) {
      return updateUser(state, user, current)
    }
    return addUser(state, user)
  }
}
