<html>
    <head>
        <title>@yield('title')</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <!--<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' media="all">-->
        <!--<link href="https://fonts.googleapis.com/css?family=Raleway+Dots" rel="stylesheet">-->
        <link href="{{asset('print/style.css')}}" rel="stylesheet" type='text/css' media="all">
    </head>
    <body>
        <div>
            <div>
                <h2 class="name">PT. AIRIN INDONESIA AIR & MARINE SUPPLY</h2>
                <div>Jl. Cilincing Raya No. 33 Tanjung Priok Jakarta Utara</div>
                <div>Tel. 4301831 - 33 ( Hunting ), 4350762 Fax. 4350760, 4358524</div>
                <hr />
            </div>
        </div>
        <div class="clearfix"></div>
        <div id="main">
            
            @yield('content')

        </div>
    </body>
</html>