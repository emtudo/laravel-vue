<script>
import UserForm from '@/app/users/form/form'
import { mapActions, mapGetters } from 'vuex'
import sessionStorage from '@/helpers/sessionStorage'

export default {
  name: 'auth-login-register',

  extends: UserForm,

  computed: {
    ...mapGetters(['twoFactorIsActive']),
    title () {
      return 'Registrar usuário'
    }
  },

  data () {
    return {
      showFooter: false,
      mounted: true,
      role: false,
      requiredPassword: true
    }
  },
  methods: {
    ...mapActions(['setupJWT', 'updateUserData', 'activeTwoFactor', 'updateTwoFactorValid']),
    setUserAndToken ({token, user}) {
      sessionStorage.set('remember', true)
      Promise.all([
        this.setupJWT(token),
        this.updateUserData(user)
      ])
        .then(() => {
          if (!user.two_factor.enabled) {
            return this.$router.push({name: 'home'})
          }
          this.$router.push({name: 'auth.two_factor'})
        })
        .catch(() => {
        })
    },
    doSave () {
      this.$resource.post('', this.user)
        .then(({data}) => {
          this.errors = {}
          this.setUserAndToken(data)
        })
        .catch(({data}) => {
          console.log('errros', data)
          this.errors = data
        })
    }
  },

  resourcePath: 'auth/register'
}
</script>
