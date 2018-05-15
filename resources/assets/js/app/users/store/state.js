export default {
  resourcePath: 'admin/users/users/',
  resourcePathProfile: 'user/users/profile',

  /**
   * @type {Bool}
   */
  saving: false,

  /**
   * @type {Bool}
   */
  loading: false,

  /**
   * @type {Array}
   */
  users: [],

  /**
   * @type {Object}
   */
  errors: {},

  /**
   * @type {Object}
   */
  search: {
    name: null,
    email: null,
    is_admin: null,
    trashed: null
  },

  /**
   * @type {Object}
   */
  filters: {
  },

  /**
   * @type {Object}
   */
  sort: {
    column: 'name', // default sort column.
    direction: 'asc' // default sort direction.
  },

  /**
   * @type {Object}
   */
  currentUser: {
    name: null,
    email: null,
    is_admin: false,
    password: null,
    password_confirmation: null
  }
}
