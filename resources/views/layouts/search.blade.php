<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">{{isset($title) ? $title : 'Buscar'}}</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
<div class="box-body">
  <table>
    <tr>
      <td valign="top">
        {{ $slot }}
      </td>
      <td align="left" valign="bottom" class="col-md-3">
        <button type="submit" class="btn btn-primary">
    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
    Buscar
  </button>
      </td>
    </tr>
  </table>
  
  
  </div>
  <!-- /.box-body -->
<div class="box-footer">

  </div>
</div>
