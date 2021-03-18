<template>
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</template>

<script lang="ts">
import {Options, Vue} from 'vue-class-component';

@Options({
  props: {}
})
export default class Footer extends Vue {
}
</script>

<style lang="sass">
</style>
