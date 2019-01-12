@extends('layout')

@section('content')

@include('partials.form-alert')

<div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Form Tarif</h3>
    </div>
    <!-- /.box-header -->
    <form class="form-horizontal" action="{{ route('invoice-tarif-store') }}" method="POST">
        <div class="box-body">            
            <div class="row">
                <div class="col-md-6">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    
                    <div class="form-group" style="display: none;">
                      <label for="behandle" class="col-sm-3 control-label">Nama Tarif</label>
                      <div class="col-sm-8">
                          <input type="text" name="name" class="form-control" id="name">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="roles" class="col-sm-3 control-label">Consolidator</label>
                      <div class="col-sm-8">
                            <select class="form-control select2 select2-hidden-accessible" name="consolidator_id" style="width: 100%;" tabindex="-1" aria-hidden="true" required>
                                <option value="">Choose Consolidator</option>
                                @foreach($consolidators as $consolidator)
                                    <option value="{{ $consolidator->id }}">{{ $consolidator->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group" style="display: none;">
                      <label for="type" class="col-sm-3 control-label">Type</label>
                      <div class="col-sm-8">
                            <select class="form-control select2 select2-hidden-accessible" name="type" style="width: 100%;" tabindex="-1" aria-hidden="true" required>
                                <option value="">Choose Type</option>
                                <option value="BB">BB</option>
                                <option value="DRY" selected>DRY</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="rdm" class="col-sm-3 control-label">RDM (20')</label>
                      <div class="col-sm-3">
                          <input type="number" name="rdm_20" class="form-control" id="rdm_20" required>
                      </div>
                    <label for="rdm" class="col-sm-2 control-label">(40')</label>
                      <div class="col-sm-3">
                          <input type="number" name="rdm_40" class="form-control" id="rdm_40" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="rdm" class="col-sm-3 control-label">Lift Full (20')</label>
                      <div class="col-sm-3">
                          <input type="number" name="lift_full_20" class="form-control" id="lift_full_20" required>
                      </div>
                    <label for="rdm" class="col-sm-2 control-label">(40')</label>
                      <div class="col-sm-3">
                          <input type="number" name="lift_full_40" class="form-control" id="lift_full_40" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="rdm" class="col-sm-3 control-label">Lift MTY (20')</label>
                      <div class="col-sm-3">
                          <input type="number" name="lift_mty_20" class="form-control" id="lift_mty_20" required>
                      </div>
                    <label for="rdm" class="col-sm-2 control-label">(40')</label>
                      <div class="col-sm-3">
                          <input type="number" name="lift_mty_40" class="form-control" id="lift_mty_40" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="rdm" class="col-sm-3 control-label">Storage MTY (20')</label>
                      <div class="col-sm-3">
                          <input type="number" name="storage_mty_20" class="form-control" id="storage_mty_20" required>
                      </div>
                    <label for="rdm" class="col-sm-2 control-label">(40')</label>
                      <div class="col-sm-3">
                          <input type="number" name="storage_mty_40" class="form-control" id="storage_mty_40" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="adm" class="col-sm-3 control-label">Biaya Admin</label>
                      <div class="col-sm-8">
                          <input type="number" name="adm" class="form-control" id="adm" required>
                      </div>
                    </div>
                </div>
                <div class="col-md-6"> 
                    
                    
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-default pull-right" style="margin-right: 10px;"><i class="fa fa-trash"></i> Batal</button>
            <a href="{{ route('invoice-tarif-index') }}" class="btn btn-danger pull-right" style="margin-right: 10px;"><i class="fa fa-close"></i> Keluar</a>
        </div>
        <!-- /.box-footer -->
    </form>
</div>

@endsection

@section('custom_css')

<!-- Select2 -->
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />

<!-- Bootstrap Switch -->
<link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/bootstrap-switch/bootstrap-switch.min.css") }}">
@endsection

@section('custom_js')

<!-- Select2 -->
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>

<!-- Bootstrap Switch -->
<script src="{{ asset("/bower_components/AdminLTE/plugins/bootstrap-switch/bootstrap-switch.min.js") }}"></script>

<script type="text/javascript">
    $('select').select2(); 
  
//    $.fn.bootstrapSwitch.defaults.size = 'mini';
    $.fn.bootstrapSwitch.defaults.onColor = 'danger';
    $.fn.bootstrapSwitch.defaults.onText = 'Ya';
    $.fn.bootstrapSwitch.defaults.offText = 'Tidak';
    
    $("input[type='checkbox']").bootstrapSwitch();
  
</script>

@endsection
