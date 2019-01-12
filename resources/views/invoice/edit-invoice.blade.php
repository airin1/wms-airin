@extends('layout')

@section('content')
<section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          {{ $container->NAMACONSOLIDATOR }}
          <small class="pull-right">Date: {{ date('d F, Y') }}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-xs-12 text-center margin-bottom">
            <h3 style="text-decoration: underline;">FAKTUR</h3>
            <p>No : {{$invoice->no_invoice}}<br />{{$invoice->no_spk}}</p>
        </div>
      <div class="col-sm-3 invoice-col">
          <table>
              <tr>
                  <td><b>FORWARDER</b></td>
              </tr>
              <tr>
                  <td><b>D/O - B/L NO</b></td>
              </tr>
              <tr>
                  <td><b>CONTAINER NO</b></td>
              </tr>
              <tr>
                  <td><b>JUMLAH B/L</b></td>
              </tr>
          </table>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <table>
              <tr>
                  <td>:&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ $invoice->forwarder }}</b></td>
              </tr>
              <tr>
                  <td>:&nbsp;&nbsp;&nbsp;&nbsp;{{ $invoice->no_mbl }}</td>
              </tr>
              <tr>
                  <td>:&nbsp;&nbsp;&nbsp;&nbsp;{{ $container->NOCONTAINER .' / '. $container->SIZE."'" }}</td>
              </tr>
              <tr>
                  <td>:&nbsp;&nbsp;&nbsp;&nbsp;{{ $invoice->jumlah_hbl .' BL'}}</td>
              </tr>
          </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <br /><br />
    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped" border="0">
          <thead>
          <tr>
            <th>NO</th>
            <th>JENIS JASA</th>
            <th>SATUAN</th>     
            <th class="text-center" colspan="2">TARIF</th>
            <th class="text-center" colspan="2">JUMLAH BIAYA</th>
          </tr>
          </thead>
          <tbody>

          <tr>
            <td>1</td>           
            <td>Kontribusi RDM ({{$container->SIZE."'"}})</td>
            <td>1 x {{ $container->SIZE }} M3/Ton</td>
            <td align="right">Rp.</td>
            <td align="right">{{ ($container->SIZE == 20) ? number_format($tarif->rdm_20) : number_format($tarif->rdm_40)  }}</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($invoice->rdm) }}</td>
          </tr>
        <tr>
            <td>2</td>           
            <td>LIFT ON/OFF FULL ({{$container->SIZE."'"}})</td>
            <td>1</td>
            <td align="right">Rp.</td>
            <td align="right">{{ ($container->SIZE == 20) ? number_format($tarif->lift_full_20) : number_format($tarif->lift_full_40)  }}</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($invoice->lift_full) }}</td>
          </tr>
        <tr>
            <td>3</td>           
            <td>LIFT ON/OFF MTY ({{$container->SIZE."'"}})</td>
            <td>1</td>
            <td align="right">Rp.</td>
            <td align="right">{{ ($container->SIZE == 20) ? number_format($tarif->lift_mty_20) : number_format($tarif->lift_mty_40)  }}</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($invoice->lift_mty) }}</td>
          </tr>
        <tr>
            <td>4</td>           
            <td>STORAGE EMPTY ({{$container->SIZE."'"}})</td>
            <td>0</td>
            <td align="right">Rp.</td>
            <td align="right">{{ ($container->SIZE == 20) ? number_format($tarif->storage_mty_20) : number_format($tarif->storage_mty_40)  }}</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($invoice->storage_mty) }}</td>
          </tr>
        <tr>
            <td colspan="5"><b>SUBTOTAL</b></td>           
            <td align="right"><b>Rp.</b></td>
            <td align="right"><b>{{ number_format($invoice->subtotal) }}</b></td>
          </tr>
          <tr>
            <td>5</td>           
            <td>PPN </td>
            <td>10%</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($invoice->subtotal) }}</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($invoice->ppn) }}</td>
          </tr>
        <tr>
            <td>6</td>           
            <td>ADMINISTRASI</td>
            <td>{{$invoice->jumlah_hbl.' B/L'}}</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($tarif->adm) }}</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($invoice->adm) }}</td>
          </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
        <p>Terbilang:</p>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px; color: #000;">
          {{ $terbilang }}
        </p>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <!--<p class="lead">Amount Due 2/22/2014</p>-->

        <div class="table-responsive">
          <table class="table">
            <tbody>
            <tr>
              <th align="right">MATERAI</th>
              <td align="right">Rp.</td>
              <td align="right">{{ number_format($invoice->materai) }}</td>
            </tr>
            <tr>
              <th align="right">TOTAL PEMBAYARAN</th>
              <td align="right"><b>Rp.</b></td>
              <td align="right"><b>{{ number_format($invoice->total) }}</b></td>
            </tr>
          </tbody></table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
      <div class="col-xs-12">
          <button id="print-invoice-btn" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
<!--        <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
        </button>
        <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
          <i class="fa fa-download"></i> Generate PDF
        </button>-->
      </div>
    </div>
  </section>

@endsection

@section('custom_css')

@endsection

@section('custom_js')

<script type="text/javascript">
    $('#print-invoice-btn').click(function() {
//        window.open("{{ route('invoice-print',$invoice->id) }}","preview invoice ","width=600,height=600,menubar=no,status=no,scrollbars=yes");
    });
</script>

@endsection