<html>
    <head>
        <title>Email Report Gateout FCL - PT. AIRIN</title>
        <style>
            body{
                background:#f2f2f2;
                font-size: 14px;
                font-family: 'Open Sans', sans-serif;
            }
            .container{
                width:100%;
                max-width: 800px;
                margin: 0 auto;
            }
            .content{
                background:#FFF;
                padding:20px;
            }
            th,td{
                font-size: 10px;
            }
        </style>
    </head>
    <body>
        
        <div class="container">
            
            <div class="content">
 
                <p>Kepada Yth.<br />Pihak Pelayaran (Shipping Line)</p>

                <p>Bersama Email ini kami lampirkan data Gate Out FCL Tanggal {{date('d F Y', strtotime($data->tgl_laporan))}}.</p><br />
                
                <p><strong>Nama Depo : PT. AIRIN</strong></p>
                <table border="1" cellpadding="10" cellspacing="0" width="100%" id="emailBody">
                    <tr>
                        <th>No. Container</th>
                        <th>Size</th>
                        <th>Ex. Vessel</th>
                        <th>VOY</th>
                        <th>Port</th>
                        <th>Shipping Line</th>
                        <th>Consignee</th>
                        <th>ETA</th>
                        <th colspan="2">Gate IN</th>
                        <th colspan="2">Gate OUT</th>
                    </tr>
                    @foreach($containers as $container)
                    <tr>
                        <td>{{$container->NOCONTAINER}}</td>
                        <td>{{$container->SIZE}}</td>
                        <td>{{$container->VESSEL}}</td>
                        <td>{{$container->VOY}}</td>
                        <td>{{$container->KD_TPS_ASAL}}</td>
                        <td>{{$container->SHIPPINGLINE}}</td>
                        <td>{{$container->CONSIGNEE}}</td>
                        <td>{{date('d-m-y', strtotime($container->ETA))}}</td>
                        <td>{{date('d-m-y', strtotime($container->TGLMASUK))}}</td>
                        <td>{{$container->JAMMASUK}}</td>
                        <td>{{date('d-m-y', strtotime($container->TGLRELEASE))}}</td>
                        <td>{{$container->JAMRELEASE}}</td>
                    </tr>
                    @endforeach
                </table>
                <br /><br />
                <p>Salam hormat,</p>
                <img src="{{ asset('assets/images/logo.jpeg') }}" alt="" style="width: 200px;" />
                <p>
                    <h3 style="margin: 0;">PT. Indonesian Air & Marine Supply</h3><br />
                    Jl. Cilincing Raya no. 33<br />
                    Tanjung Priok – Jakarta 14110<br />
                    Indonesia<br />
                    Tel. 021 – 430 1831<br />
                    Fax. 021 – 350 760<br />
                    E-mail: sekretariat@airin.co.id<br />
                </p>
            </div>
            
        </div>

    </body>
</html>