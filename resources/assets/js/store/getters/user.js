import { get, first } from 'lodash'

// isLogged
export const isLogged = ({ user }) => {
  return get(user, 'id', null) !== null
} // isLogged

// user getters
export const currentUser = ({ user }) => user // all user data
export const user = ({ user }) => user // all user data
export const userId = ({ user }) => get(user, 'id') // current user id
export const userName = ({ user }) => get(user, 'name') // current user name
export const userAvatar = ({ user }) => get(user, 'avatar') // current user name
export const userFirstName = ({ user }) => first((get(user, 'name') || '').split(' ')) // current user first name
export const userEmail = ({ user }) => get(user, 'email') // current user email
export const userIsLogged = ({ user }) => get(user, 'id', null) !== null

// current user role
export const userIsAdmin = ({ user }) => get(user, 'is_admin', false)
