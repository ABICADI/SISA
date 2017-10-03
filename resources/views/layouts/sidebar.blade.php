  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <!-- Optionally, you can add icons to the links -->
        <li class="active"><a href="/dashboard"><i class="glyphicon glyphicon-home"></i> <span>Dashboard</span></a></li>
        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
        <li><a href="{{ route('user-management.index') }}"><i class="fa fa-users"></i> <span>Empleado</span></a></li>
        <li><a href="{{ route('paciente-management.index') }}"><i class="fa fa-users"></i> <span>Paciente</span></a></li>
        <li><a href="{{ route('medico-management.index') }}"><i class="fa fa-users"></i> <span>Medico</span></a></li>
        @endif
        <li><a href="{{ route('actividad-management.index') }}"><i class="glyphicon glyphicon-calendar"></i> <span>Actividad</span></a></li>
       
        @if (1 == Auth::user()->rol_id || 2 == Auth::user()->rol_id)
        <li class="treeview"> s
          <a href="#"><i class="glyphicon glyphicon-cog"></i> <span>Opciones Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('system-management/terapia') }}"><i class="fa fa-bank"></i> Terapia</a></li>
            @if (1 == Auth::user()->rol_id)
            <li><a href="{{ url('system-management/bitacora') }}"><i class="glyphicon glyphicon-zoom-out"></i> Bitacora</a></li>
            <!--<li><a href="{{ url('system-management/report') }}"><i class="fa fa-archive"></i> Report</a></li>-->
            @endif
          </ul>
        </li>
        @endif
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>