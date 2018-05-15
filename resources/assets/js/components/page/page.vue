<script>
export default {
  name: 'page',

  props: {
    title: {
      type: String,
      default: ''
    }
  }
}
</script>

<template>
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-header" v-if="title">{{ title }}</div>

                  <div class="card-body">
                      <slot></slot>
                  </div>
              </div>
          </div>
      </div>

      <div class="footer">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <slot name="footer">
            </slot>
          </div>
        </div>
      </div>
  </div>
</template>
