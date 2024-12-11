{{include file="views/parts/head.tpl.php"}}
<body class="dashboard">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->

{{include file="views/parts/nav.tpl.php"}}

{{include file="views/parts/menubar.tpl.php"}}

{{include file="views/parts/menugrid.tpl.php"}}


<!-- Page -->
<div class="page">
    <div class="page-content padding-30 container-fluid">
        <div class="row" data-plugin="matchHeight" data-by-row="true">


            <div class="col-xlg-12 col-md-12">
                <!-- Panel Theme Change -->
                <div class="widget widget-shadow" id="widgetTable">
                    <div class="widget-body padding-30">
                        <h3 class="widget-title">
                            <span class="text-truncate">Szablon</span>
                            <span class="pull-right red-600 font-size-24 font-weight-bold">
                            <select id="theme_change" class="form-control">
                                <option value="winter" {{if $theme_style== "winter"}} selected {{/if}}>Zima</option>
                                <option value="summer" {{if $theme_style== "summer"}} selected {{/if}}>Lato</option>
                            </select>
                        </span>
                        </h3>
                    </div>
                </div>
                <!-- End Panel Theme Change -->
            </div>


        </div>
    </div>
</div>
<!-- End Page -->


{{include file="views/parts/foot2.tpl.php"}}

<!-- Core  -->
<script src="{{$themedir}}assets/vendor/jquery/jquery.js"></script>
<script src="{{$themedir}}assets/vendor/bootstrap/bootstrap.js"></script>
<script src="{{$themedir}}assets/vendor/animsition/jquery.animsition.js"></script>
<script src="{{$themedir}}assets/vendor/asscroll/jquery-asScroll.js"></script>
<script src="{{$themedir}}assets/vendor/mousewheel/jquery.mousewheel.js"></script>
<script src="{{$themedir}}assets/vendor/asscrollable/jquery.asScrollable.all.js"></script>
<script src="{{$themedir}}assets/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>

<!-- Plugins -->
<script src="{{$themedir}}assets/vendor/switchery/switchery.min.js"></script>
<script src="{{$themedir}}assets/vendor/intro-js/intro.js"></script>
<script src="{{$themedir}}assets/vendor/screenfull/screenfull.js"></script>
<script src="{{$themedir}}assets/vendor/slidepanel/jquery-slidePanel.js"></script>
<script src="http://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="http://www.amcharts.com/lib/3/serial.js"></script>
<script src="http://www.amcharts.com/lib/3/themes/light.js"></script>


<!-- Scripts -->
<script src="{{$themedir}}assets/js/core.js"></script>
<script src="{{$themedir}}assets/js/site.js"></script>

<script src="{{$themedir}}assets/js/sections/menu.js"></script>
<script src="{{$themedir}}assets/js/sections/menubar.js"></script>
<script src="{{$themedir}}assets/js/sections/sidebar.js"></script>

<script src="{{$themedir}}assets/js/configs/config-colors.js"></script>
<script src="{{$themedir}}assets/js/configs/config-tour.js"></script>

<script src="{{$themedir}}assets/js/components/asscrollable.js"></script>
<script src="{{$themedir}}assets/js/components/animsition.js"></script>
<script src="{{$themedir}}assets/js/components/slidepanel.js"></script>
<script src="{{$themedir}}assets/js/components/switchery.js"></script>

<!-- Scripts For This Page -->
<script src="{{$themedir}}assets/js/components/matchheight.js"></script>


<script>
    $(document).ready(function ($) {
        Site.run();

        $('#theme_change').on('change', function () {
            var val = $(this).val();
            $.ajax({
                url: '{{$siteUrl}}home',
                data: {
                    theme: val
                },
            });
        })

    });
</script>


</body>

</html>