<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .logo {
            max-height: 50px; 
        }
        .info {
            margin-bottom: 20px;
        }
        .yth {
            align-items: center;
            text-align: center;
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
            border-collapse: collapse;
        }
        .info table, .info th, .info td {
            border: 0px solid #ddd;
        }
        .info th, .info td {
            padding: 10px;
            text-align: left;
        }
        .item-list {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .item-list th, .item-list td {
            border: 0px solid #ddd;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- <img src="{{asset('assets/images/logo.jpeg')}}" alt="Logo" class="logo"> -->
            <h2></h2>
        </div>
    
        
        <div class="info">
            <div class="col-4">
                 <table>
                     <tr>
                         <th></th>
                         <td></td>
                         <th></th>
                         <th></th>
                         <th></th>
                         <td></td>
                         <td></td>
                         <td></td>
                         <th></th>
                         <td>{{ $cont->NOPOL_KELUAR }}</td>
                     </tr>
                     <tr>
                         <th></th>
                         <td> </td>
                     </tr>
                 </table>
            </div>
            <div class="col-4">
                 <table>
                     <tr>
                         <th></th>
                         <td></td>
                     </tr>
                     <tr>
                         <th></th>
                         <td> </td>
                     </tr>
                 </table>
            </div>
            
        </div>
   
        <div class="yth">
            <h4>{{$cont->VESSEL}}</h4>
            <h4>{{$cont->VOY}}</h4>
        </div>
 
        <table class="item-list">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
               
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <h5>Container  1 X {{$cont->SIZE}}</h5> 
                        
                            <h5>{{$cont->NOCONTAINER}}</h5>
                            
                            <h5>{{$cont->NO_SEAL}}</h5>
                            
                            <h5>{{$cont->PEL_BONGKAR}}</h5>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                
            </tbody>
        </table>
    </div>
</body>
</html>