import { get } from 'lodash'
import toast from '@/plugins/toast/toast'
/**
 * Handle API messages.
 *
 */
export default {
  success (store) {
    return function (response) {
      return response
    }
  },
  error (store) {
    return function (response) {
      const status = get(response, 'response.status')

      if (status === 401) {
        return store.dispatch('refreshToken')
          .then(() => {
            toast.warning('Sessão será atualizada!')
            setTimeout(() => {
              window.location.reload()
            }, 1000)
          })
          .catch(() => {
            return Promise.reject(response)
          })
      }

      return Promise.reject(response)
    }
  }
}
