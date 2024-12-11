<!DOCTYPE html>
<html>
{{$header}}
<body class="stretched eskipass {{$theme_style}}">
<div id="wrapper" class="clearfix">
    {{$topnav}}
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix bottommargin-lg">
                <div class="row clearfix">
                    <div class="col-xl-5">
                        <div class="heading-block topmargin">
                            <h1>{{$boxy['top'][0].text1}}</h1>
                        </div>
                        <p class="lead">{{$boxy['top'][0].text2}}</p>
                    </div>
                    <div class="col-xl-7">
                        <div class="ohidden" data-height-xl="426" data-height-lg="567" data-height-md="470"
                             data-height-md="287" data-height-xs="183">
                            <img src="{{$siteUrl}}{{$boxy['top'][0].img}}"
                                 style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="100"
                                 alt="{{$boxy['top'][0].text1}}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="section topmargin-lg">
                <div class="container">
                    <div class="col_one_third bottommargin-sm center">
                        <img data-animate="fadeInLeft" src="{{$siteUrl}}{{$boxy['middle'][0].img}}"
                             alt="{{$boxy['middle'][0].text1}}">
                    </div>
                    <div class="col_two_third bottommargin-sm col_last">

                        <div class="heading-block topmargin-sm">
                            <h3>{{$boxy['middle'][0].text1}}</h3>
                        </div>
                        <p>{{$boxy['middle'][0].text2}}</p>

                        <a href="{{$boxy['middle'][0].url}}"
                           class="button button-border button-dark button-rounded button-large noleftmargin topmargin-sm {{if $form}}to-form{{/if}}">{{$boxy['middle'][0].text3}}</a>
                    </div>
                </div>
            </div>

            {{if !$insurance}}
            <div class="container clearfix">
                <div class="heading-block topmargin-lg center">
                    <h2>{{$boxy['bottom'][0].text1}}</h2>
                    <span class="divcenter">{{$boxy['bottom'][0].text2}}</span>
                </div>
                <div class="row bottommargin-sm">
                    <div class="col-lg-4 col-md-6 bottommargin">
                        {{section name=id loop=$boxy['bottom_left']}}
                        <div class="feature-box fbox-right topmargin" data-animate="fadeInLeft">
                            <div class="fbox-icon">
                                <span><i class="icon-{{$boxy['bottom_left'][id].text4}}"></i></span>
                            </div>
                            <h3>{{$boxy['bottom_left'][id].text1}}</h3>
                            <p>{{$boxy['bottom_left'][id].text2}}</p>
                        </div>
                        {{/section}}
                    </div>
                    <div class="col-lg-4 d-md-none d-lg-block bottommargin center">
                        <img src="{{$siteUrl}}{{$boxy['bottom'][0].img}}" alt="iphone 2">
                    </div>
                    <div class="col-lg-4 col-md-6 bottommargin">
                        {{section name=id loop=$boxy['bottom_right']}}
                        <div class="feature-box topmargin" data-animate="fadeInRight">
                            <div class="fbox-icon">
                                <span><i class="icon-{{$boxy['bottom_right'][id].text4}}"></i></span>
                            </div>
                            <h3>{{$boxy['bottom_right'][id].text1}}</h3>
                            <p>{{$boxy['bottom_right'][id].text2}}</p>
                        </div>
                        {{/section}}
                    </div>
                </div>
            </div>
            {{/if}}
            <div class="{{if !$insurance}}section{{else}}container{{/if}} bottommargin-lg">
                <div class="container clear-bottommargin clearfix">
                    <div class="row topmargin-sm clearfix">
                        {{section name=id loop=$boxy['bottom_group']}}
                        <div class="col-lg-4 bottommargin">
                            <i class="i-plain color i-large icon-{{$boxy['bottom_group'][id].text4}} inline-block"
                               style="margin-bottom: 15px; cursor: default"></i>
                            <div class="heading-block nobottomborder" style="margin-bottom: 15px;">
                                <span class="before-heading">{{$boxy['bottom_group'][id].text1}}</span>
                                <h4>{{$boxy['bottom_group'][id].text2}}</h4>
                            </div>
                            <p>{{$boxy['bottom_group'][id].text3}}</p>
                        </div>
                        {{/section}}
                    </div>
                </div>
            </div>
            {{if $form}}
            {{$contact}}
            {{/if}}
            {{if count($loga) > 0}}

            {{if $insurance}}
            <div class="section" style="margin-bottom: -80px">
                {{/if}}
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

                {{if $insurance}}
            </div>
            {{/if}}
            {{/if}}

        </div>

    </section><!-- #content end -->

    {{$footer}}
    {{$scripts}}
</div>
</body>
</html>
