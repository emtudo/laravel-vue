import { sort as doSort } from '../services'
// import { filter } from 'lodash'

export const errors = ({ errors }) => errors
export const currentUser = ({ user }) => user
export const users = ({ users }) => users
export const loading = ({ loading }) => loading
export const saving = ({ saving }) => saving
export const filteredUsers = ({ users }) => {
  return users
}
export const sortedUsers = ({ users, filters, sort }) => doSort(filteredUsers({users}), filters, sort)
export const search = ({ search }) => search
export const filters = ({ filters }) => filters
export const resourcePath = ({ resourcePath }) => resourcePath
export const resourcePathProfile = ({ resourcePathProfile }) => resourcePathProfile
