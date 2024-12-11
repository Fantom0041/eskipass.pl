<!DOCTYPE html>
<html>
{{$header}}
<body class="stretched eskipass {{$theme_style}}">
<div id="wrapper" class="clearfix">
    {{$topnav}}
    <section id="content">

        <div class="content-wrap">
            {{$contact}}
            <div class="container clearfix text-justify">
                <p>
                    Dane rejestrowe:
                    E-skipass Sp. z o.o. z siedzibą w Woli Filipowskiej 32-065, ul. Chrzanowska 75,
                    wpisana do Rejestru Przedsiębiorców prowadzonego przez dla Krakowa-Śródmieścia w Krakowie , XII Wydział Gospodarczy Krajowego Rejestru Sądowego KRS pod nr 0000465088.
                    Wysokość kapitału zakładowego 5.000 zł. Numer NIP: 5130235158
                </p>
            </div>
            {{if count($loga) > 0}}
            <div class="container clearfix">
                <div id="oc-clients-full" class="owl-carousel image-carousel carousel-widget" data-margin="30"
                     data-nav="false"
                     data-autoplay="5000" data-pagi="false" data-items-xs="2" data-items-sm="3" data-items-md="4"
                     data-items-lg="5"
                     data-items-xl="7" data-loop="true">
                    {{section name=id loop=$loga}}
                    <div class="oc-item"><img src="{{$siteUrl}}{{$loga[id].img}}" alt="Clients"></div>
                    {{/section}}
                </div>
            </div>
            {{/if}}

        </div>

    </section><!-- #content end -->

    {{$footer}}
    {{$scripts}}
</div>
</body>
</html>
