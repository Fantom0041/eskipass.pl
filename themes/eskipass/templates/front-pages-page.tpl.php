<!DOCTYPE html>
<html>
{{$header}}
<body class="stretched eskipass {{$theme_style}}">
<div id="wrapper" class="clearfix">
    {{$topnav}}
    <section id="content">
            <div class="container mt25 offset-0">
                <!-- CONTENT -->
                <div class="pagecontainer2 offset-0">
                    <div class="hpadding50c">
                        <p class="lato size30 slim">{{$dane.nazwa}}</p>
                        <p class="aboutarrow"></p>
                    </div>
                    <div class="line3"></div>

                    <div class="hpadding50c custom-pages">

                        {{$dane.content}}
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <br><br>
                </div>
                <!-- END CONTENT -->
            </div>
    </section>

    {{$footer}}
    {{$scripts}}
</div>
</body>
</html>
