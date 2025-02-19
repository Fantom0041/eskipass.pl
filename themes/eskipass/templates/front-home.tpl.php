<!DOCTYPE html>
<html dir="ltr" lang="en-US">
{{$header}}
<body class="stretched eskipass {{$theme_style}}">
<div id="wrapper" class="clearfix">
    {{$topnav}}
    <section id="content">

        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row" style="margin-bottom: -100px;">
                    {{if count($slider) > 0}}
                    <div class="col-lg-8 col-sm-12 slider-col"> <!-- class before=bottommargin-lg -->
                        <div class="fslider" data-arrows="false">
                            <div class="flexslider">
                                <div class="slider-wrap">
                                    {{section name=id loop=$slider}}
                                    <div class="slide">
                                        <a href="{{if $slider[id].url != ""}} {{$slider[id].url}} {{else}} # {{/if}}">
                                        <img class="resize_img" data-format="4:3" src="{{$siteUrl}}{{$slider[id].img}}"
                                             alt="Shop Image">
                                        </a>
                                    </div>
                                    {{/section}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{/if}}
                    <div class="{{if count($slider) > 0}} col-lg-4{{else}} col-lg-12{{/if}} col-sm-12 bottommargin-lg important-blocks">
                        <div class="row">
                            {{if count($slider_boksy) > 0}}
                            {{section name=id loop=$slider_boksy}}
                            <div class="{{if count($slider) <= 0}} col-lg-6 {{else}} col-lg-12 {{/if}} col-sm-6 bottommargin-sm">
                                <a href="{{$slider_boksy[id].url}}"><img class="resize_img" data-format="4:3"
                                                                         src="{{$siteUrl}}{{$slider_boksy[id].img}}"
                                                                         alt="{{$slider_boksy[id].text1}}"></a>
                            </div>
                            {{/section}}
                            {{/if}}
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            {{section name=id loop=$paralaksa}}
            <div class="promo parallax promo-full bottommargin"
                 style="background-image: url('{{$siteUrl}}{{$paralaksa[id].img}}');"
                 data-bottom-top="background-position:0px -100px;" data-top-bottom="background-position:0px -300px;">
                <div class="background-opacity"></div>
                <div class="container clearfix">
                    <h3>{{$paralaksa[id].text1}}</h3>
                    <span>{{$paralaksa[id].text2}}</span>
                    <a href="{{$paralaksa[id].url}}" class="button button-xlarge button-rounded">Zacznij sprzedawać</a>
                </div>
            </div>
            {{/section}}
            <div class="container clearfix">
                <div class="col-sm-12 boksy-filters">
                    <div class="row">
                        <div class="col-lg-1 hidden-md order-lg-1">FILTRUJ</div>
                        <div id="boksy-sort" class="col-lg-1 col-md-2 col-sm-6 order-lg-2 order-md-2 order-sm-1 order-2 col-12" data-dir="none">A-Z
                            <span class="icon icon-arrow-up"></span>
                        </div>
                        <div id="boksy-state" class="col-lg-9 col-md-8 col-sm-12 order-lg-3 order-md-3 order-sm-3 order-3">
                            <div class="row">
                                <div class="label col-lg-3 col-md-5 col-sm-12">
                                    Województwo
                                    <span class="icon icon-chevron-down">
                                </span>
                                </div>
                                <ul id="boksy-states-list">
                                    {{section name=id loop=$states}}
                                    <li value="{{$states[id]}}" {{if $postback.state== $states[id]}} selected {{/if}}>{{$states[id]}}</li>
                                    {{/section}}
                                </ul>
                                <div id="boksy-states-tabs" class="col-lg-9 col-md-7 col-sm-12">
                                    <span id="boksy-states-clear-all" class="tab">Wyczyść filtry</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-2 col-sm-6 col-12 order-lg-4 order-sm-2 order-md-4 order-1">
                            <span class="icon icon-search"></span>
                            <div id="boksy-search">
                                <input id="boksy-search-input" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="boksy" class="container clearfix">
                    <div class="row">
                        {{section name=id loop=$boksy}}
                        <div data-name="{{$boksy[id].text1}}" data-state="{{$boksy[id].state}}"
                             class="boks col-lg-4 col-sm-6 col-xs-12 bottommargin" {{if $boksy[id].url != ""}}style="cursor: pointer;"{{/if}}>
                            <div class="feature-box center media-box fbox-bg">
                                <div class="fbox-media">
                                    <img class="resize_img" data-format="16:9" src="{{$siteUrl}}{{$boksy[id].img}}"
                                         alt="{{$boksy[id].text1}}"/>
                                </div>
                                <div class="fbox-desc">
                                    {{if $boksy[id].text1}}<h3>{{$boksy[id].text1}}{{if $boksy[id].text2}}<span
                                                class="subtitle">{{$boksy[id].text2}}</span>{{/if}}
                                    </h3>{{/if}}
                                    {{if $boksy[id].url != ""}}<p><a href="{{$boksy[id].url}}"
                                                                     class="btn btn-secondary">{{if $boksy[id].text3}}{{$boksy[id].text3}}{{else}}Kup bilet{{/if}}</a>
                                    </p>{{/if}}
                                </div>
                                <div class="hover-content">
                                    <p>{{if $boksy[id].description}}{{$boksy[id].description}}{{else}}Odkryj więcej szczegółów o tej ofercie. Kliknij, aby zobaczyć pełną ofertę i dokonać rezerwacji.{{/if}}</p>
                                </div>
                            </div>
                        </div>
                        {{/section}}
                        {{section name=id loop=$oldboksy}}
                        <div data-name="{{$oldboksy[id].text1}}" data-state="{{$oldboksy[id].state}}"
                             class="boks col-lg-4 col-sm-6 col-xs-12 bottommargin-lg" {{if $oldboksy[id].url != ""}}style="cursor: pointer;"{{/if}}>
                            <div class="feature-box center media-box fbox-bg" style="opacity: 0.3">
                                <div class="fbox-media">
                                    <img class="resize_img" data-format="16:9" src="{{$siteUrl}}{{$oldboksy[id].img}}"
                                         alt="{{$oldboksy[id].text1}}"/>
                                </div>
                                <div class="fbox-desc">
                                    {{if $oldboksy[id].text1}}<h3>{{$oldboksy[id].text1}}{{if $oldboksy[id].text2}}<span
                                                class="subtitle">{{$oldboksy[id].text2}}</span>{{/if}}
                                    </h3>{{/if}}
                                    {{if $oldboksy[id].url != ""}}<p><a href="{{$oldboksy[id].url}}"
                                                                     class="btn btn-secondary">{{if $oldboksy[id].text3}}{{$oldboksy[id].text3}}{{else}}Kup bilet{{/if}}</a>
                                    </p>{{/if}}
                                </div>
                            </div>
                        </div>
                        {{/section}}
                    </div>
                </div>
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
    </section>
    {{$footer}}
    {{$scripts}}
</div>
</body>
</html>
