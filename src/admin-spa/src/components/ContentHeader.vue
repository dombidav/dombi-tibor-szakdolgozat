<template>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><slot /></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
              <li class="breadcrumb-item" v-for="(text, link) in breadCrumbItems" v-bind:key="link"><router-link :to="link">
                {{ text }}</router-link></li>
              <li class="breadcrumb-item active"><slot /></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</template>

<script lang="ts">
import {Options, Vue} from 'vue-class-component';

@Options({
  props: {
    breadCrumbItems: Array
  }
})

export default class ContentHeader extends Vue {
  breadCrumbItems: string[] = []
}
</script>

<style lang="sass">
</style>
