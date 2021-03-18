<template>
  <div class="content-wrapper">
<!--    <ContentHeader :breadCrumbItems="{link: 'some', text: 'something'}">Dashboard</ContentHeader>-->
    <ContentHeader>Dashboard</ContentHeader>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Card variant 1</h5>

                <p class="card-text">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque earum est eveniet fugit ipsam totam voluptatum. Consequatur deserunt ea eius eligendi libero perspiciatis provident quisquam, tempore. Doloribus dolorum magnam reprehenderit.
                </p>

                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div>

            <div class="card card-primary card-outline">
              <div class="card-body">
                <h5 class="card-title">Card variant 3</h5>

                <p class="card-text">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut id ipsum magnam minima officia quod ratione suscipit tenetur vel voluptatum. Asperiores ex provident quos sit! Atque autem cum dolores hic.
                </p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Card variant 2</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Subtitle</h6>

                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus architecto consequuntur eaque, illo officia porro quia repellat! Cumque debitis deserunt, eius eum neque quae quas qui totam ut vitae voluptatum.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Featured</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Subtitle</h6>

                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus culpa hic illum incidunt quisquam! Ad excepturi minima nam necessitatibus sapiente sequi voluptate? Adipisci, aperiam expedita nihil nulla omnis soluta voluptatum.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import ContentHeader from "@/components/ContentHeader.vue";
@Options({
  components: {
    ContentHeader
  },
})
export default class Home extends Vue {}
</script>
