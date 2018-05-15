<script>
import UserForm from '@/app/users/form/form'
import { mapActions } from 'vuex'

export default {
  name: 'perfil-me',

  extends: UserForm,

  computed: {
    title () {
      return 'Editar perfil'
    }
  },

  data () {
    return {
      role: false,
      requiredPassword: false
    }
  },
  methods: {
    ...mapActions({
      doLoadProfile: 'app/users/doLoadProfile',
      saveProfile: 'app/users/saveProfile'
    }),
    doSave () {
      this.saveProfile(this.user)
        .then((data) => {
          this.errors = {}
          this.user = data
          this.updateUserData(data)
        })
        .catch((data) => {
          this.errors = data
        })
    }
  },
  mounted () {
    this.mounted = false
    this.doLoadProfile()
      .then((user) => {
        this.user = user
        this.mounted = true
      })
      .catch((data) => {
        console.log('erro', data)
        this.mounted = true
      })
  }
}
</script>
