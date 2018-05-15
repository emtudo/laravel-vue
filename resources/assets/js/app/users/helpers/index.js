import { get } from 'lodash'

export const status = user => {
  const deleted = get(user, 'deleted_at', null)
  if (deleted) {
    return 'Suspenso'
  }

  return 'Ativado'
}

export const prepareShow = user => {
  user._parsed = {
    status: status(user)
  }

  return user
}
