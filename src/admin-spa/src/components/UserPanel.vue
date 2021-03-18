<template>
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      <a href="#" class="d-block">Example User</a>
    </div>
  </div>
</template>
<script lang="ts">
import {Options, Vue} from 'vue-class-component';

@Options({
  props: {},
  mounted() {
    console.log('a')
  }
})
export default class UserPanel extends Vue {

}
</script>
