import { resource } from '@/plugins/http'
import toast from '@/plugins/toast/toast'

const http = path => {
  return resource(path)
}
const doLoad = (commit, path, id = null, search = {}) => {
  commit('setLoading', true)

  return http(path).get(id, search)
    .then(({data}) => {
      commit('setLoading', false)
      if (id) {
        commit('setCurrentUser', data)
      } else {
        commit('setUsers', data)
      }

      return data
    })
    .catch(({data}) => {
      commit('setLoading', false)

      return Promise.reject(data)
    })
}

const doSave = (commit, path, user, message = 'Usuário salvo com sucesso!') => {
  commit('setSaving', true)

  const newUser = {...user}
  if (newUser.password === null) {
    delete newUser.password
    delete newUser.password_confirmation
  }

  return http(path).save(user)
    .then(({data}) => {
      commit('setSaving', false)
      commit('updateUser', data)
      toast.success(message)

      return data
    })
    .catch(({data}) => {
      commit('setErrors', data)
      commit('setSaving', false)

      return Promise.reject(data)
    })
}

export default {
  doLoadProfile: ({commit, getters}) => {
    return http(getters.resourcePathProfile).get()
      .then(({data}) => {
        commit('setLoading', false)
        commit('setCurrentUser', data)

        return data
      })
      .catch(({data}) => {
        commit('setLoading', false)

        return Promise.reject(data)
      })
  },
  find: ({commit, getters}, id) => {
    return doLoad(commit, getters.resourcePath, id)
  },
  bootLoad: ({commit, getters}) => {
    return doLoad(commit, getters.resourcePath, null, getters.search)
  },
  saveUser: ({commit, getters}, user) => {
    return doSave(commit, getters.resourcePath, user)
  },
  saveProfile: ({commit, getters}, user) => {
    commit('setSaving', true)

    const newUser = {...user}
    if (newUser.password === null) {
      delete newUser.password
      delete newUser.password_confirmation
    }

    return http(getters.resourcePathProfile).put('', user)
      .then(({data}) => {
        commit('setSaving', false)
        commit('updateUser', data)
        toast.success('Perfil atualizado com sucesso!')

        return data
      })
      .catch(({data}) => {
        commit('setErrors', data)
        commit('setSaving', false)

        return Promise.reject(data)
      })
  },
  setUsers: ({commit}, values = []) => {
    commit('setUsers', values)
  },
  setFilters: ({commit}, values = {}) => {
    commit('setFilters', values)
  },
  setSearch: ({commit}, values = {}) => {
    commit('setSearch', values)
  },
  updateUser: ({commit}, user) => {
    commit('updateUser', user)

    return user
  },

  active ({commit, getters}, user) {
    return http(getters.resourcePath).put(user.id + '/activate')
      .then(({data}) => {
        commit('updateUser', data)
        toast.success('Usuário ativado com sucesso!')

        return data
      }).catch(({data}) => {
        toast.error('Não foi possível ativar o usuário')

        return Promise.reject(data)
      })
  },
  suspend: ({commit, getters}, user) => {
    return http(getters.resourcePath).put(user.id + '/suspend')
      .then(({data}) => {
        commit('updateUser', data)
        toast.success('Usuário suspenso com sucesso!')

        return data
      }).catch(({data}) => {
        toast.error('Não foi possível suspenser o usuário')

        return Promise.reject(data)
      })
  },
  delete ({commit, getters}, user) {
    return http(getters.resourcePath).delete(user.id)
      .then(({data}) => {
        commit('updateUser', data)
        toast.success('Usuário excluído com sucesso!')

        return data
      }).catch(({data}) => {
        toast.error('Não foi possível excluir o usuário')

        return Promise.reject(data)
      })
  }
}
