<style>
    body {
        color: #000;
        background: #fff;
        font-size: 11px;
    }
    table, th, tr, td {
        font-size: 20px;
    }
 
</style>
<div style="margin: 20px 0">
        <div style="text-align: center;margin: 0 auto;">
            
      
        <span style="font-size:28;">CONTAINER {{$photos->NOCONTAINER}}</span>
        <br>
        <span style="font-size:22;"> {{$photos->NAMACONSOLIDATOR}}</span>
                <h3 style="margin: 20px;">GATE IN</h3>
                @foreach($gateIn as $foto)
                <img src="{{ asset('/uploads/photos/export/container/' . $foto->photo) }}" alt=""  width="200" height="200">

                @endforeach
              
                <br>
                <hr>
                <h3 style="margin: 20px;">STUFFING</h3>
                @foreach($stuffing as $foto)
                <img src="{{ asset('/uploads/photos/export/container/' . $foto->photo) }}" alt=""  width="200" height="200">

                @endforeach
         

                <br>
                <hr>
                <h3 style="margin: 20px;">GATE OUT</h3>
                @foreach($gateOut as $foto)
                <img src="{{ asset('/uploads/photos/export/container/' . $foto->photo) }}" alt=""  width="200" height="200">

                @endforeach
           
          
            
        
            <p style="font-size: 13px;font-weight: bold">
                                  
            </p>
            <p style="font-size: 13px;">
                
                </p>
            

        </div>
    </div>
    <div style="display:block; page-break-before:always;"></div>
