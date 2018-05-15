<script>
export default {
  name: 'layout-main'
}
</script>

<template>
  <main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <alerts></alerts>
            </div>
        </div>
      </div>
      <router-view></router-view>
  </main>
</template>
