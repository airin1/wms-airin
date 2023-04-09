<?php
  

	
	$tgl		= date("d-m-Y");
	$nmfile		= $nama_file = 'laporan_yor_'.date('Y-m-d_H-i-s');
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Expires: 0");
	header("Content-type: application/vnd.ms-excel"); 
	header("Content-Disposition: attachment; filename=".$nmfile.".xls");
	
	//if ($row = oci_fetch_array ($stmt)) {
	?>
      
    <div class="row">

        <div class="col-md-12">
            <table class="table table-bordered table-hover table-striped" style="background: #FFF;">
            <h4>LAPORAN HARIAN  YOR TPS UTARA (ARN1) </h4>
			<h4> TANGGAL {{strtoupper(date('d F Y H:i:s'))}}</h4>
                <tbody>
                    <tr>
                      <th>NO</th>
                        <th>TIPE</th>
						<th>LUAS(M2)</th>
                        <th>KAPASITAS EFEKTIVE TEU's</th>
						<th>KAPASITAS TERISI TEU's</th>
						<th>KAPASITAS KOSONG TEU's</th>
                        <th>YOR(%)</th>
						<th>KETERANGAN</th>          
					</tr>
                  
                    <tr>
                        <th align="center">1</th>
                        <td align="center">DRY</td>
						<td>17,738</td>
                        <td align="center">{{number_format($yarn1['drykaparn1'],'0',',','.') }}</td>
						<td align="center">{{number_format($yarn1['dryarn1'],'0',',','.')}}</td>
						<td align="center">{{number_format($yarn1['drykaparn1'] - $yarn1['dryarn1'],'0',',','.')}}</td>
					    <td align="center">{{number_format($yarn1['dryyorarn1'],'2',',','.')}}</td>
                        <td></td>
					</tr>
					<tr>
                        <th align="center">2</th>
                        <td align="center">REEFER</td>
						<td></td>
						<td align="center">{{number_format($yarn1['rfrkaparn1'],'0',',','.') }}</td>
						<td align="center">{{number_format($yarn1['rfrarn1'],'0',',','.')}}</td>
						<td align="center">{{number_format($yarn1['rfrkaparn1']-$yarn1['rfrarn1'],'0',',','.')}}</td>
                        <td align="center">{{number_format($yarn1['rfryorarn1'],'2',',','.')}}</td>
                        <td></td>
					</tr>
					<tr>
                        <th align="center">3</th>
                        <td align="center">DG</td>
						<td></td>
						<td align="center">{{number_format($yarn1['dgkaparn1'],'0',',','.') }}</td>
						<td align="center">{{number_format($yarn1['dgarn1'],'0',',','.')}}</td>
						<td align="center">{{number_format($yarn1['dgkaparn1']-$yarn1['dgarn1'],'0',',','.')}}</td>
                        <td align="center">{{number_format($yarn1['dgyorarn1'],'2',',','.')}}</td>
                        <td></td>
					</tr>
					
                </tbody>
            </table>
              <h4></h4>
			   <h4></h4>
			    <h4></h4>

      			<table class="table table-bordered table-hover table-striped" style="background: #FFF;">
				<h4>LAPORAN HARIAN  YOR TPS BARAT (ARN3)</h4>
				<h4>TANGGAL {{strtoupper(date('d F Y H:i:s'))}}</h4>	
                <tbody>
                    <tr>
                        <th>NO</th>
                        <th>TIPE</th>
						<th>LUAS(M2)</th>
                        <th>KAPASITAS EFEKTIVE TEU's</th>
						<th>KAPASITAS TERISI TEU's</th>
						<th>KAPASITAS KOSONG TEU's</th>
                        <th>YOR(%)</th>
						<th>KETERANGAN</th>
                    </tr>
               
                    <tr>
                        <th align="center">1</th>
                        <td align="center">DRY</td>
						<th>13,298</th>
                        <td align="center">{{number_format($yarn3['drykaparn3'],'0',',','.') }}</td>
						<td align="center">{{number_format($yarn3['dryarn3'],'0',',','.')}}</td>
				        <td align="center">{{number_format($yarn3['drykaparn3']-$yarn3['dryarn3'],'0',',','.')}}</td>                       
					   <td align="center">{{number_format($yarn3['dryyorarn3'],'2',',','.')}}</td>
                       <td></td>
					</tr>
					<tr>
                        <th align="center">2</th>
                        <td align="center">REEFER</td>
						<td></td>
						<td align="center">{{number_format($yarn3['rfrkaparn3'],'0',',','.') }}</td>
						<td align="center">{{number_format($yarn3['rfrarn3'],'0',',','.')}}</td>
						<td align="center">{{number_format($yarn3['rfrkaparn3']-$yarn3['rfrarn3'],'0',',','.')}}</td>

                        <td align="center">{{number_format($yarn3['rfryorarn3'],'2',',','.')}}</td>
                        <td></td>
					</tr>
					<tr>
                        <th align="center">3</th>
                        <td align="center">DG</td>
						<td></td>
						<td align="center">{{number_format($yarn3['dgkaparn3'],'0',',','.') }}</td>
						<td align="center">{{number_format($yarn3['dgarn3'],'0',',','.')}}</td>
						<td align="center">{{number_format($yarn3['dgkaparn3']-$yarn3['dgarn3'],'0',',','.')}}</td>
                        <td align="center">{{number_format($yarn3['dgyorarn3'],'2',',','.')}}</td>
                        <td></td> 
					</tr>
                </tbody>
            </table>
			
			
	
        </div>
    </div>
