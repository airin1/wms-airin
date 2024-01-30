@extends('layout')

@section('content')


<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Export Stuffing</h3>

    </div>
    <div class="box-body table-responsive">    
   
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>Action</th>
                    <th>No Container</th>
                    <th>No Booking</th>
                    <th>Jumlah Barang</th>
                    <th>Vessel</th>
                    <th>Pelabuhan Tujuan</th>
                    <th>Consignee</th>
                    <th>UID</th>
                </tr>
              </thead>
              <tbody>
               @foreach($container as $cont)
                <tr>
                    <td>
                    <a class="btn btn-outline-warning btn-sm" href="{{ route('exp-stuffing', $cont->TCONTAINER_PK) }}"><i class="fa fa-pencil"></i></a>
                  </td>
                    <td>{{$cont->NOCONTAINER}}</td>
                    <td>{{$cont->job->NOBOOKING}}</td>
                    <td>{{ count($cont->barang->where('TCONTAINER_FK', $cont->TCONTAINER_PK)) }}</td>
                    <td>{{$cont->job->VESSEL}}</td>
                    <td>{{$cont->job->PEL_BONGKAR}}</td>
                    <td>{{$cont->job->NAMACONSOLIDATOR}}</td>
                    <td>{{$cont->UID}}</td>
                </tr>
               @endforeach
              </tbody>
            </table>
    </div>
</div>


@endsection

@section('custom_js')

@endsection