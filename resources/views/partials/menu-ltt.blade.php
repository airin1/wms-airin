<header class="main-header">

    <!-- Logo -->
    <a href="{{route('index')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">AIRIN</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>WIS</b>PT.AIRIN</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
<!--      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>-->
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">{{ \Auth::getUser()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- Menu Footer-->
              <li class="user-footer">
<!--                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>-->
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
  </header>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu tree" data-widget="tree">
        <li>
          <a href="{{route('index')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        @role('bea-cukai')
            @if(\Auth::getUser()->username != 'bcgaters1')
            <li class="treeview">
                <a href="#">
                  <i class="fa fa-th"></i> <span>Import LCL</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a tabindex="-1" href="{{ route('lcl-register-index') }}">Register</a></li>
                  <li><a tabindex="-1" href="{{ route('lcl-manifest-index') }}">Manifest</a></li>
                  <li><a tabindex="-1" href="{{ route('lcl-dispatche-index') }}">Dispatche E-Seal</a></li>

                  <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Realisasi
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="{{ route('lcl-realisasi-gatein-index') }}">Masuk / Gate In</a></li>
                      <li><a href="{{ route('lcl-realisasi-stripping-index') }}">Stripping</a></li>
                      <li><a href="{{ route('lcl-realisasi-buangmty-index') }}">Buang MTY</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Delivery
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="{{ route('lcl-delivery-behandle-index') }}">Behandle</a></li>
                      <li><a href="{{ route('lcl-delivery-release-index') }}">Release / Gate Out</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-th"></i> <span>Import FCL</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a tabindex="-1" href="{{ route('fcl-register-index') }}">Register</a></li>
                  <li><a tabindex="-1" href="{{ route('fcl-dispatche-index') }}">Dispatche E-Seal</a></li>

                  <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Realisasi
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="{{ route('fcl-realisasi-gatein-index') }}">Masuk / Gate In</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Delivery
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="{{ route('fcl-delivery-behandle-index') }}">Behandle</a></li>
                      <li><a href="{{ route('fcl-delivery-release-index') }}">Release / Gate Out</a></li>
                    </ul>
                  </li>
                </ul>
              </li>

              <li class="treeview">
                    <a href="#">
                      <i class="fa fa-th"></i> <span>Export (Stuffing)</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a tabindex="-1" href="{{ route('exp-register-index') }}">Register</a></li>
                      <li><a tabindex="-1" href="{{ route('exp-manifest-index') }}">Manifest</a></li>
                      <!-- <li><a tabindex="-1" href="{{ route('lcl-dispatche-index') }}">Dispatche E-Seal</a></li> -->
                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Realisasi
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('exp-register-gateIn') }}">Masuk / Gate In (Container)</a></li>
                          <li><a href="{{ route('exp-manifest-gateIn') }}">Masuk / Gate In (Barang)</a></li>
                          <li><a href="{{ route('exp-stuffing-index')}}">Stuffing</a></li>
           
                        </ul>
                      </li>

                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Delivery
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                    
                          <li><a href="{{ route('exp-release-gateOut') }}">Release / Gate Out</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>

              <li class="treeview">
                <a href="#">
                  <i class="fa fa-pie-chart"></i>
                  <span>TPS Online</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Penerimaan Data
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="{{ route('tps-responPlp-index') }}">Data Respon PLP</a></li>
                      <li><a href="{{ route('tps-responBatalPlp-index') }}">Data Respon Batal PLP</a></li>
                      <li><a href="{{ route('tps-obLcl-index') }}">Data OB LCL</a></li>
                      <li><a href="{{ route('tps-obFcl-index') }}">Data OB FCL</a></li>
                      <li><a href="{{ route('tps-spjm-index') }}">Data SPJM</a></li>
                      <li><a href="{{ route('tps-dokManual-index') }}">Data Dok Manual</a></li>
                      <li><a href="{{ route('tps-dokpabean-index') }}">Data Dok Pabean</a></li>
                      <li><a href="{{ route('tps-sppbPib-index') }}">Data SPPB</a></li>
                      <li><a href="{{ route('tps-sppbBc-index') }}">Data SPPB BC23</a></li>
                      <li><a href="{{ route('tps-infoNomorBc-index') }}">Info Nomor BC11</a></li>
					 
                    </ul>
                  </li>
                  <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Pengiriman Data
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li class="treeview">
                          <a href="#"><i class="fa fa-circle-o"></i> COARI (Cargo Masuk)
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                          <ul class="treeview-menu">
                              <li><a href="{{ route('tps-coariCont-index') }}">Coari Cont</a></li>
                              <li><a href="{{ route('tps-coariKms-index') }}">Coari KMS</a></li>
                          </ul>
                      </li>
                      <li class="treeview">
                          <a href="#"><i class="fa fa-circle-o"></i> CODECO (Cargo Keluar)
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                          <ul class="treeview-menu">
                              <li><a href="{{ route('tps-codecoContFcl-index') }}">Codeco Cont FCL</a></li>
                              <li><a href="{{ route('tps-codecoContBuangMty-index') }}">Codeco Cont Buang MTY</a></li>
                              <li><a href="{{ route('tps-codecoKms-index') }}">Codeco KMS</a></li>
                          </ul>
                      </li>
                      <li><a href="{{ route('tps-realisasiBongkarMuat-index') }}">Realisasi Bongkar Muat</a></li>
                      <li><a href="{{ route('tps-laporanYor-index') }}">Laporan YOR</a></li>
                    </ul>
                  </li>

                </ul>
              </li>
            <li class="treeview">
                <a href="{{route('barcode-index')}}">
                    <i class="fa fa-barcode"></i> Gate Pass (Autogate)
                </a>
            </li>
            @endif
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-legal"></i> <span>Bea Cukai @if($notif_behandle['total'] > 0)<small class="label pull-right bg-red">{{$notif_behandle['total']}}</small>@endif</span>
                </a>
                <ul class="treeview-menu"> 
                    <li class="treeview">
                        <a href="#">
                            <span>LCL @if($notif_behandle['lcl'] > 0)<small class="label pull-right bg-red">{{$notif_behandle['lcl']}}</small>@endif</span>
                        </a>
                        <ul class="treeview-menu">
<!--                            <li><a tabindex="-1" href="{{ route('lcl-behandle-index') }}">Status Behandle @if($notif_behandle['lcl'] > 0)<small class="label pull-right bg-red">{{$notif_behandle['lcl']}}</small>@endif</a></li>-->
                            <li class="treeview">
                                <a href="#">
                                    <span>Behandle</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="{{ route('lcl-behandle-index') }}">Ready @if($notif_behandle['lcl'] > 0)<small class="label pull-right bg-red">{{$notif_behandle['lcl']}}</small>@endif</a></li>
                                    <li><a href="{{ route('lcl-behandle-finish') }}">Finish</a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('lcl-hold-index')}}">Dokumen HOLD</a></li>
							<li><a href="{{route('lcl-mtyhold-index')}}">Dokumen MTY HOLD</a></li>
							<li><a href="{{route('lcl-lain-index')}}">Dokumen HOLD LAINNYA</a></li>
                            <!--<li><a href="{{route('lcl-segel-index')}}">Segel Merah</a></li>-->
                            <li class="treeview">
                                <a href="#">
                                    <span>Segel Merah</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="{{ route('lcl-segel-index') }}">List Container</a></li>
                                    <li><a href="{{ route('lcl-segel-report') }}">Report Lepas Segel</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <span>Report</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="{{ route('lcl-bc-report-container') }}">Report Container</a></li>
                                    <li><a href="{{ route('lcl-bc-report-stock') }}">Report Cargo</a></li>
                                    <li><a href="{{ route('lcl-bc-report-inventory') }}">Report Stock</a></li>
                                    <li><a href="{{ route('lcl-report-harian') }}">Daily Report</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <span>FCL @if($notif_behandle['fcl'] > 0)<small class="label pull-right bg-red">{{$notif_behandle['fcl']}}</small>@endif</span>
                        </a>          
                        <ul class="treeview-menu">
                            <!--<li><a tabindex="-1" href="{{ route('fcl-behandle-index') }}">Status Behandle @if($notif_behandle['fcl'] > 0)<small class="label pull-right bg-red">{{$notif_behandle['fcl']}}</small>@endif</a></li>-->
                            <li class="treeview">
                                <a href="#">
                                    <span>Behandle</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="{{ route('fcl-behandle-index') }}">Ready @if($notif_behandle['fcl'] > 0)<small class="label pull-right bg-red">{{$notif_behandle['fcl']}}</small>@endif</a></li>
                                    <li><a href="{{ route('fcl-behandle-finish') }}">Finish</a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('fcl-hold-index')}}">Dokumen HOLD</a></li>
							<li><a href="{{route('fcl-lain-index')}}">Dokumen HOLD LAINNYA</a></li>
                            <!--<li><a href="{{route('fcl-segel-index')}}">Segel Merah</a></li>-->
                            <li class="treeview">
                                <a href="#">
                                    <span>Segel Merah</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>	
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="{{ route('fcl-segel-index') }}">List Container</a></li>
                                    <li><a href="{{ route('fcl-segel-report') }}">Report Lepas Segel</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <span>Report</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="{{ route('fcl-bc-report-container') }}">Report Container</a></li>
                                    <li><a href="{{ route('fcl-bc-report-inventory') }}">Report Stock</a></li>
                                    <li><a href="{{ route('fcl-report-harian') }}">Daily Report</a></li>
									<li><a href="{{ route('fcl-report-logReleaseDok') }}">Report Release Dok</a></li>                             
							 </ul>
                            </li>
                        </ul>
                    </li>

                    <!-- Export -->
                    <li class="treeview">
                        <a href="#">
                            <span>Export</span>
                        </a>
                        <ul class="treeview-menu">
<!--                            <li><a tabindex="-1" href="{{ route('lcl-behandle-index') }}">Status Behandle @if($notif_behandle['lcl'] > 0)<small class="label pull-right bg-red">{{$notif_behandle['lcl']}}</small>@endif</a></li>-->
                            <!-- <li class="treeview">
                                <a href="#">
                                    <span>Behandle</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="{{ route('lcl-behandle-index') }}">Ready @if($notif_behandle['lcl'] > 0)<small class="label pull-right bg-red">{{$notif_behandle['lcl']}}</small>@endif</a></li>
                                    <li><a href="{{ route('lcl-behandle-finish') }}">Finish</a></li>
                                </ul>
                            </li> -->
                            <li><a href="{{route('exp-release-HoldBC')}}">Dokumen HOLD</a></li>
							              <!-- <li><a href="{{route('lcl-mtyhold-index')}}">Dokumen MTY HOLD</a></li>
							              <li><a href="{{route('lcl-lain-index')}}">Dokumen HOLD LAINNYA</a></li> -->
                            <!--<li><a href="{{route('lcl-segel-index')}}">Segel Merah</a></li>-->
                            <!-- <li class="treeview">
                                <a href="#">
                                    <span>Segel Merah</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="{{ route('lcl-segel-index') }}">List Container</a></li>
                                    <li><a href="{{ route('lcl-segel-report') }}">Report Lepas Segel</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <span>Report</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="{{ route('lcl-bc-report-container') }}">Report Container</a></li>
                                    <li><a href="{{ route('lcl-bc-report-stock') }}">Report Cargo</a></li>
                                    <li><a href="{{ route('lcl-bc-report-inventory') }}">Report Stock</a></li>
                                    <li><a href="{{ route('lcl-report-harian') }}">Daily Report</a></li>
                                </ul>
                            </li> -->
                        </ul>
                    </li>

                </ul>
            </li>
        @else
        
        @role('upload-fcl')
            <li class="treeview">
                <a href="#">
                  <i class="fa fa-th"></i> <span>Import FCL</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Realisasi
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="{{ route('fcl-realisasi-gatein-index') }}">Masuk / Gate In</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Delivery
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="{{ route('fcl-delivery-release-index') }}">Release / Gate Out</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
        @else
            @role('upload-lcl')
                <li class="treeview">
                    <a href="#">
                      <i class="fa fa-th"></i> <span>Import LCL</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a tabindex="-1" href="{{ route('lcl-manifest-index') }}">Manifest</a></li>

                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Realisasi
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('lcl-realisasi-gatein-index') }}">Masuk / Gate In</a></li>
                          <li><a href="{{ route('lcl-realisasi-stripping-index') }}">Stripping</a></li>
                        </ul>
                      </li>

                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Delivery
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('lcl-delivery-release-index') }}">Release / Gate Out</a></li>
                        </ul>
                      </li>

                    </ul>
                  </li>
            @else
                <li class="treeview">
                    <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Master Data</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="{{ route('consolidator-index') }}">Consolidator</a></li>
                      <li><a href="{{ route('depomty-index') }}">Depo MTY</a></li>
                      <li><a href="{{ route('lokasisandar-index') }}">Lokasi Sandar</a></li>
                      <li><a href="{{ route('negara-index') }}">Negara</a></li>
                      <li><a href="{{ route('packing-index') }}">Packing</a></li>
                      <li><a href="{{ route('pelabuhan-index') }}">Pelabuhan</a></li>
                      <li><a href="{{ route('perusahaan-index') }}">Perusahaan</a></li>
                      <li><a href="{{ route('tpp-index') }}">TPP</a></li>
                      <li><a href="{{ route('shippingline-index') }}">Shipping Line</a></li>
                      <li><a href="{{ route('eseal-index') }}">E-Seal</a></li>
                      <li><a href="{{ route('vessel-index') }}">Vessel</a></li>
                      <li><a href="{{ route('ppjk-index') }}">PPJK</a></li> 
                      <li><a href="{{ route('location-index') }}">Lokasi LCL</a></li> 
                      <li><a href="{{ route('locationfcl-index') }}">Lokasi FCL</a></li> 
                    </ul>
                  </li>
                  <li class="treeview">
                      <a href="{{route('payment-bni-index')}}">
                          <i class="fa fa-money"></i> BNI E-Collection
                      </a>
                  </li>
                  <li class="treeview">
                    <a href="#">
                      <i class="fa fa-th"></i> <span>Import LCL</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a tabindex="-1" href="{{ route('lcl-register-index') }}">Register</a></li>
                      <li><a tabindex="-1" href="{{ route('lcl-manifest-index') }}">Manifest</a></li>
                      <li><a tabindex="-1" href="{{ route('lcl-dispatche-index') }}">Dispatche E-Seal</a></li>
                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Photo
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('lcl-photo-container-index') }}">Container</a></li>
                          <li><a href="{{ route('lcl-photo-cargo-index') }}">Cargo</a></li>
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Realisasi
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('lcl-realisasi-gatein-index') }}">Masuk / Gate In</a></li>
                          <li><a href="{{ route('lcl-realisasi-stripping-index') }}">Stripping</a></li>
                          <li><a href="{{ route('lcl-realisasi-buangmty-index') }}">Buang MTY</a></li>
                        </ul>
                      </li>

                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Delivery
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('lcl-delivery-behandle-index') }}">Behandle</a></li>
                          <li><a href="{{ route('lcl-delivery-release-index') }}">Release / Gate Out</a></li>
                        </ul>
                      </li>

                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Report
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('lcl-report-container') }}">Report Container</a></li>
                          <li><a href="{{ route('lcl-report-inout') }}">Report Cargo</a></li>    
                          <li><a href="{{ route('lcl-report-longstay') }}">Report Stock</a></li>
                          <li><a href="{{ route('lcl-report-harian') }}">Daily Report</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>

                
                @if(\Auth::getUser()->username == 'ltf'|\Auth::getUser()->username == 'IPUY'|\Auth::getUser()->username == 'rinielvira'|
					\Auth::getUser()->username == 'masdel'|\Auth::getUser()->username == 'indra'|\Auth::getUser()->username == 'adith'|
				\Auth::getUser()->username == 'Yanuar'|\Auth::getUser()->username == 'Fadoli'|\Auth::getUser()->username == 'wawa24'|
				\Auth::getUser()->username == 'susanbae'|\Auth::getUser()->username == 'sukri'|\Auth::getUser()->username == 'efriandi'|
				\Auth::getUser()->username == 'riof'|\Auth::getUser()->username == 'sujaya'|\Auth::getUser()->username == 'timanoce'|
				\Auth::getUser()->username == 'mustari'|\Auth::getUser()->username == 'wibi'|\Auth::getUser()->username == 'senthot'|
				\Auth::getUser()->username == 'erik'|\Auth::getUser()->username == 'wibi2'|\Auth::getUser()->username == 'Tony'|
				\Auth::getUser()->username == 'nugroho'|\Auth::getUser()->username == 'reza'|\Auth::getUser()->username == 'ariief'|
				\Auth::getUser()->username == 'tonii'|\Auth::getUser()->username == 'anton'|\Auth::getUser()->username == 'KELIK'

				)
           
                  <li class="treeview">
                    <a href="#">
                      <i class="fa fa-th"></i> <span>Import FCL</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a tabindex="-1" href="{{ route('fcl-register-index') }}">Register</a></li>
                      <li><a tabindex="-1" href="{{ route('fcl-dispatche-index') }}">Dispatche E-Seal</a></li>
                        <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Photo
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('fcl-photo-container-index') }}">Container</a></li>
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Realisasi
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('fcl-realisasi-gatein-index') }}">Masuk / Gate In</a></li>
                        </ul>
                      </li>

                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Delivery
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('fcl-delivery-behandle-index') }}">Behandle</a></li>
                          <li><a href="{{ route('fcl-delivery-release-index') }}">Release / Gate Out</a></li>
                        </ul>
                      </li>

                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Report
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('fcl-report-rekap') }}">Report Container</a></li>
                          <li><a href="{{ route('fcl-report-longstay') }}">Report Stock</a></li>
                          <li><a href="{{ route('fcl-report-harian') }}">Daily Report</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                 @endif  
				 
                    <!-- EXPORT -->
                    <li class="treeview">
                    <a href="#">
                      <i class="fa fa-th"></i> <span>Export (Stuffing)</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a tabindex="-1" href="{{ route('exp-register-index') }}">Register</a></li>
                      <li><a tabindex="-1" href="{{ route('exp-manifest-index') }}">Manifest</a></li>
                      <!-- <li><a tabindex="-1" href="{{ route('lcl-dispatche-index') }}">Dispatche E-Seal</a></li> -->
                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Photo
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('exp-container-photo') }}">Container</a></li>
                          <li><a href="{{ route('exp-manifest-photo') }}">Cargo</a></li>
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Realisasi
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('exp-register-gateIn') }}">Masuk / Gate In (Container)</a></li>
                          <li><a href="{{ route('exp-manifest-gateIn') }}">Masuk / Gate In (Barang)</a></li>
                          <li><a href="{{ route('exp-stuffing-index')}}">Stuffing</a></li>
           
                        </ul>
                      </li>

                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Delivery
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                    
                          <li><a href="{{ route('exp-release-gateOut') }}">Release / Gate Out</a></li>
                        </ul>
                      </li>

                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Report
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('exp-report-cont') }}">Report Container</a></li>
                          <!-- <li><a href="{{ route('lcl-report-inout') }}">Report Cargo</a></li>     -->
                          <li><a href="{{ route('exp-report-mani') }}">Report Stock</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#">
                      <i class="fa fa-pie-chart"></i>
                      <span>TPS Online</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Data
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('gudang-index') }}">Gudang</a></li>
                          <li><a href="{{ route('pelabuhandn-index') }}">Pelabuhan DN</a></li>
                          <li><a href="{{ route('pelabuhanln-index') }}">Pelabuhan LN</a></li>
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Penerimaan Data
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(\Auth::getUser()->username == 'ltf'|\Auth::getUser()->username == 'IPUY'|\Auth::getUser()->username == 'rinielvira'|
							\Auth::getUser()->username == 'masdel'|\Auth::getUser()->username == 'indra'|\Auth::getUser()->username == 'adith'|
							\Auth::getUser()->username == 'Yanuar'|\Auth::getUser()->username == 'Fadoli'|\Auth::getUser()->username == 'wawa24'|
							\Auth::getUser()->username == 'susanbae'|\Auth::getUser()->username == 'sukri'|\Auth::getUser()->username == 'efriandi'|
							\Auth::getUser()->username == 'riof'|\Auth::getUser()->username == 'sujaya'|\Auth::getUser()->username == 'timanoce'|
							\Auth::getUser()->username == 'mustari'|\Auth::getUser()->username == 'wibi'|\Auth::getUser()->username == 'senthot'|
							\Auth::getUser()->username == 'erik'|\Auth::getUser()->username == 'wibi2'|\Auth::getUser()->username == 'Tony'|
							\Auth::getUser()->username == 'nugroho'|\Auth::getUser()->username == 'reza'|\Auth::getUser()->username == 'ariief'|
							\Auth::getUser()->username == 'tonii'|\Auth::getUser()->username == 'anton'|\Auth::getUser()->username == 'tonii'|\Auth::getUser()->username == 'KELIK'
							)                        
						  <li><a href="{{ route('tps-responPlp-index') }}">Data Respon PLP FCL</a></li>
                          @endif
						  <li><a href="{{ route('tps-responPlpLCL-index') }}">Data Respon PLP LCL</a></li>
                       						  
						  <li><a href="{{ route('tps-responBatalPlp-index') }}">Data Respon Batal PLP</a></li>
                          <li><a href="{{ route('tps-obLcl-index') }}">Data OB LCL</a></li>
                          <li><a href="{{ route('tps-obFcl-index') }}">Data OB FCL</a></li>
                          <li><a href="{{ route('tps-spjm-index') }}">Data SPJM</a></li>
                          <li><a href="{{ route('tps-dokManual-index') }}">Data Dok Manual</a></li>
                          <li><a href="{{ route('tps-dokpabean-index') }}">Data Dok Pabean</a></li>
                          <li><a href="{{ route('tps-sppbPib-index') }}">Data SPPB</a></li>
                          <li><a href="{{ route('tps-sppbBc-index') }}">Data SPPB BC23</a></li>
                          <li><a href="{{ route('tps-infoNomorBc-index') }}">Info Nomor BC11</a></li>
						              <li><a href="{{ route('tps-dokNPE-index') }}">Data Dok NPE</a></li>
						              <li><a href="{{ route('tps-dokPKBE-index') }}">Data Dok PKBE</a></li>
						
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Pengiriman Data
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li class="treeview">
                              <a href="#"><i class="fa fa-circle-o"></i> COARI (Cargo Masuk)
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                              </a>
                              <ul class="treeview-menu">
                                  <li><a href="{{ route('tps-coariCont-index') }}">Coari Cont</a></li>
                                  <li><a href="{{ route('tps-coariKms-index') }}">Coari KMS</a></li>
                              </ul>
                          </li>
                          <li class="treeview">
                              <a href="#"><i class="fa fa-circle-o"></i> CODECO (Cargo Keluar)
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                              </a>
                              <ul class="treeview-menu">
                                  <li><a href="{{ route('tps-codecoContFcl-index') }}">Codeco Cont FCL</a></li>
                                  <li><a href="{{ route('tps-codecoContBuangMty-index') }}">Codeco Cont Buang MTY</a></li>
                                  <li><a href="{{ route('tps-codecoKms-index') }}">Codeco KMS</a></li>
								  <li><a href="{{ route('tps-reject-index') }}">Info Data Reject</a></li>
                              </ul>
                          </li>
                          <li><a href="{{ route('tps-realisasiBongkarMuat-index') }}">Realisasi Bongkar Muat</a></li>
                          <li><a href="{{ route('tps-laporanYor-index') }}">Laporan YOR</a></li>
                        </ul>
                      </li>

                    </ul>
                  </li>
                   @if(\Auth::getUser()->username == 'ltf'|\Auth::getUser()->username == 'IPUY'|\Auth::getUser()->username == 'rinielvira'|
							\Auth::getUser()->username == 'masdel'|\Auth::getUser()->username == 'indra'|\Auth::getUser()->username == 'adith'|
							\Auth::getUser()->username == 'Yanuar'|\Auth::getUser()->username == 'Fadoli'|\Auth::getUser()->username == 'wawa24'|
							\Auth::getUser()->username == 'susanbae'|\Auth::getUser()->username == 'sukri'|\Auth::getUser()->username == 'efriandi'|
							\Auth::getUser()->username == 'riof'|\Auth::getUser()->username == 'sujaya'|\Auth::getUser()->username == 'timanoce'|
							\Auth::getUser()->username == 'mustari'|\Auth::getUser()->username == 'wibi'|\Auth::getUser()->username == 'senthot'|
							\Auth::getUser()->username == 'erik'|\Auth::getUser()->username == 'wibi2'|\Auth::getUser()->username == 'Tony'|
							\Auth::getUser()->username == 'nugroho'|\Auth::getUser()->username == 'reza'|\Auth::getUser()->username == 'ariief'|
							\Auth::getUser()->username == 'tonii'|\Auth::getUser()->username == 'anton'|\Auth::getUser()->username == 'KELIK'
							)
				  <li class="treeview">
                    <a href="#">
                      <i class="fa fa-upload"></i>
                      <span>NPCT1</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">  
                      <li><a href="{{ route('movement-container-index') }}">Data Container</a></li>
                      <li><a href="{{ route('movement-index') }}">Laporan Movement</a></li>
                      <li><a href="{{ route('yor-index') }}">Laporan YOR</a></li>
                      <li><a href="{{ route('tracking-index') }}">Tracking</a></li>
                    </ul>
                  </li>
				  @endif
                  <li class="treeview">
                      <a href="#">
                        <i class="fa fa-money"></i>
                        <span>Invoice</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                           @if(\Auth::getUser()->username == 'ltf'|\Auth::getUser()->username == 'IPUY'|\Auth::getUser()->username == 'rinielvira'|
							\Auth::getUser()->username == 'masdel'|\Auth::getUser()->username == 'indra'|\Auth::getUser()->username == 'adith'|
							\Auth::getUser()->username == 'Yanuar'|\Auth::getUser()->username == 'Fadoli'|\Auth::getUser()->username == 'wawa24'|
							\Auth::getUser()->username == 'susanbae'|\Auth::getUser()->username == 'sukri'|\Auth::getUser()->username == 'efriandi'|
							\Auth::getUser()->username == 'riof'|\Auth::getUser()->username == 'sujaya'|\Auth::getUser()->username == 'timanoce'|
							\Auth::getUser()->username == 'mustari'|\Auth::getUser()->username == 'wibi'|\Auth::getUser()->username == 'senthot'|
							\Auth::getUser()->username == 'erik'|\Auth::getUser()->username == 'wibi2'|\Auth::getUser()->username == 'Tony'|
							\Auth::getUser()->username == 'nugroho'|\Auth::getUser()->username == 'reza'|\Auth::getUser()->username == 'ariief'|
							\Auth::getUser()->username == 'tonii'|\Auth::getUser()->username == 'anton'|\Auth::getUser()->username == 'KELIK'
							)
						  <li class="treeview">
                              <a href="#"><i class="fa fa-circle-o"></i> FCL
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                              </a>
                              <ul class="treeview-menu">
                                  <li><a href="{{route('invoice-tarif-nct-index')}}">Data Tarif</a></li>
                                  <li><a href="{{route('invoice-release-nct-index')}}">Data Release/Gate Out</a></li>
                                  <li><a href="{{route('invoice-nct-index')}}">Data Invoice</a></li>
                              </ul>
                          </li>
						  @endif
                          <li class="treeview">
                              <a href="#"><i class="fa fa-circle-o"></i> LCL
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                              </a>
                              <ul class="treeview-menu">
                                  <li><a href="{{route('invoice-tarif-index')}}">Data Tarif</a></li>
                                  <li><a href="{{route('invoice-release-index')}}">Data Release/Gate Out</a></li>
                                  <li><a href="{{route('invoice-index')}}">Data Invoice</a></li>
                              </ul>
                          </li>

                      </ul>
                  </li>

                  <li class="treeview">
                      <a href="{{route('barcode-index')}}">
                          <i class="fa fa-barcode"></i> Gate Pass (Autogate)
                      </a>
                  </li>
				   <li class="treeview">
                      <a href="http://36.95.97.167:8989/nle/">
                          <i class="fa fa-barcode"></i> NLE
                      </a>
                  </li>
                  <li class="treeview">
                      <a href="#">
                        <i class="fa fa-users"></i>
                        <span>Users</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                          <li><a href="{{route('user-index')}}">User Lists</a></li>
                          <li><a href="{{route('role-index')}}">Roles</a></li>
                          <li><a href="{{route('permission-index')}}">Permissions</a></li>
                      </ul>
                  </li>
            @endrole
        @endrole
    </ul>
    @endrole  
    </section>
    <!-- /.sidebar -->
  </aside>
<script>
    $('.sidebar-menu ul li').find('a').each(function () {
        var link = new RegExp($(this).attr('href')); //Check if some menu compares inside your the browsers link
        if (link.test(document.location.href)) {
            if(!$(this).parents().hasClass('active')){
                $(this).parents('li').addClass('menu-open');
                $(this).parents().addClass("active");
                $(this).addClass("active"); //Add this too
            }
        }
    });
</script>