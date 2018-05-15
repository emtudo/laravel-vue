<script>
import { mapGetters } from 'vuex'

export default {
  name: 'home',

  computed: {
    ...mapGetters(['userIsLogged', 'userFirstName'])
  }
}
</script>

<template>
  <page>
    <div class="title m-b-md" v-if="!userIsLogged">
        Emtudo Skeleton
    </div>
    <div class="title m-b-md" v-if="userIsLogged">
        Bem vindo, {{ userFirstName }}!
    </div>
  </page>
</template>
