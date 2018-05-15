import { get } from 'lodash'
// import toast from '@/plugins/toast/toast'

/**
 * Handle API messages.
 *
 */
export default {
  success (response) {
    return response
  },
  error (error) {
    const status = get(error, 'response.status')

    // const message = get(error, 'response.data.meta.message') || 'Falha ao realizar operação.'

    if (status === 400 || (status >= 402 && status <= 599)) {
      // toast.error(message)
    }

    if (status === 401) {
      // toast.error('Permissão negada, ou sua sessão expirou!')
    }

    return Promise.reject(error)
  }
}
