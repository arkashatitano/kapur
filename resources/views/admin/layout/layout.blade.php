<!DOCTYPE html>
<html lang="en">

@include('admin.layout.app')

<body class="fix-header fix-sidebar card-no-border">
<i class="ajax-loader" ></i>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
  <svg class="circular" viewBox="25 25 50 50">
    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">

  <header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
      <!-- ============================================================== -->
      <!-- Logo -->
      <!-- ============================================================== -->
      <div class="navbar-header">
        <a class="navbar-brand" href="/">
          <!-- Logo icon --><b>
            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
            <!-- Dark Logo icon -->
            <img style="width: 90px" src="/img/logo.png" alt="КАПУР" class="dark-logo" />
            <!-- Light Logo icon -->
            <img style="width: 90px" src="/img/logo.png" alt="КАПУР" class="light-logo" />
          </b>
          <!--End Logo icon -->
          <!-- Logo text --><span>

                         {{--<img style="width: 140px; margin-top: 5px" src="/img/logo.png" alt="homepage" class="dark-logo" />
                         <img style="width: 140px; margin-top: 5px" src="/img/logo.png" class="light-logo" alt="homepage" />--}}
          </span> </a>
      </div>
      <!-- ============================================================== -->
      <!-- End Logo -->
      <!-- ============================================================== -->
      <div class="navbar-collapse">
        <!-- ============================================================== -->
        <!-- toggle and nav items -->
        <!-- ============================================================== -->
        <ul class="navbar-nav mr-auto mt-md-0">

          <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
          <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>

        </ul>

        <ul class="navbar-nav my-lg-0">

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{Auth::user()->name}}
            </a>
            <div class="dropdown-menu dropdown-menu-right scale-up">
              <ul class="dropdown-user">
                <li>
                  <div class="dw-user-box">
                    <div class="u-text">
                      <h4>{{Auth::user()->name}}</h4>
                      <p class="text-muted">{{Auth::user()->login}}</p>
                  </div>
                </li>
                <li role="separator" class="divider"></li>
                <li><a href="/admin/password"><i class="ti-settings"></i> Сменить пароль</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="/admin/logout"><i class="fa fa-power-off"></i> Выйти</a></li>
              </ul>
            </div>
          </li>

        </ul>
      </div>
    </nav>
  </header>

  <aside class="left-sidebar">

    @if(Auth::user()->role_id == 1)
        @include('admin.layout.sidebar.admin')
    @elseif(Auth::user()->role_id == 2)
        @include('admin.layout.sidebar.moderator')
    @endif

    <div class="sidebar-footer">
      <a href="/admin/password" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
      <a href="/admin/logout" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
    </div>
  </aside>

  <div class="page-wrapper">

    @yield('content')

    <footer class="footer"> © {{date('Y')}} </footer>
  </div>
</div>

<script src="/admin/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="/admin/assets/plugins/popper/popper.min.js"></script>
<script src="/admin/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="/admin/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="/admin/js/waves.js"></script>
<!--Menu sidebar -->
<script src="/admin/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="/admin/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="/admin/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!--Custom JavaScript -->
<script src="/admin/js/custom.min.js"></script>
<script src="/admin/assets/plugins/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
<script src="/admin/assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script src="/admin/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="/admin/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script>

<script src="/admin/assets/plugins/moment/moment.js"></script>

<script src="/admin//assets/plugins/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
<script src="/admin//assets/plugins/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
<script src="/admin//assets/plugins/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>

<script src="/admin/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script src="/admin/assets/plugins/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js" type="text/javascript"></script>

{{--<script src="/admin/assets/plugins/chartist-js/dist/chartist.min.js"></script>
<script src="/admin/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
<script src="/admin/assets/plugins/d3/d3.min.js"></script>
<script src="/admin/assets/plugins/c3-master/c3.min.js"></script>--}}
{{--<script src="/admin/js/dashboard1.js"></script>--}}
<script src="/admin/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>


<script type="text/javascript" src="/custom/wysiwyg/kindeditor.js?v=5"></script>
<script type="text/javascript" src="/custom/wysiwyg/ru_Ru.js"></script>
<script type="text/javascript" src="/custom/js/jquery.gritter.js"></script>

<script src="/custom/js/admin.js?v=14"></script>

@yield('js')


</body>

</html>