<template>
  <!DOCTYPE html>
  <!--
  This is a starter template page. Use this page to start your new project from
  scratch. This page gets rid of all links and provides the needed markup only.
  -->
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ACS Admin | Example</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="css/adminlte.min.css">
  </head>
  <body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <NavBar></NavBar>

   <SideBar></SideBar>

    <!-- Content Wrapper. Contains page content -->
    <router-view></router-view>
    <!-- /.content-wrapper -->
    <Footer></Footer>

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <div id="jquery"></div>
  <div id="bootstrap"></div>
  <div id="adminlte"></div>

  </body>
  </html>

</template>

<style lang="scss">

</style>

<script>
/* eslint-disable no-useless-escape */
import postscribe from 'postscribe'
import NavBar from '@/components/NavBar'
import SideBar from '@/components/SideBar'
import Footer from '@/components/Footer'

export default {
  components: {
    NavBar,
    SideBar,
    Footer
  },
  name: 'AdminLTEScripts',
  // eslint-disable-next-line @typescript-eslint/explicit-module-boundary-types
  mounted: function () {
    postscribe('#jquery', `<script src="js/jquery.min.js"><\/script>`)
    postscribe('#bootstrap', `<script src="js/bootstrap.bundle.min.js"><\/script>`)
    postscribe('#adminlte', `<script src="js/adminlte.min.js"><\/script>`)
  }
}
</script>