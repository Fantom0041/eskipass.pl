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
                    <div class="hpadding50c">
                        {{$dane.content}}
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12">
                                {{assign var=faqitems value=$dane.cf.faq}}
                                {{foreach from=$faqitems key=rownum item=faqitem name=faq}}
                                {{if $faqitem.naglowek}}
                                <h2>{{$faqitem.naglowek}}</h2>
                                <hr>
                                {{else}}
                                <div class="panel panel-default">
                                    <div class="panel-heading"><a data-toggle="collapse" href="#faq{{$rownum}}"
                                                                  aria-expanded="false"
                                                                  aria-controls="faq{{$rownum}}"><i
                                                    class="icon-chevron-right"></i> {{$faqitem.pytanie}}</a>
                                    </div>
                                    <div class="panel-body collapse" id="faq{{$rownum}}">
                                        {{$faqitem.odpowiedz}}
                                    </div>
                                </div>
                                {{/if}}
                                {{/foreach}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {{assign var=faqitems value=$dane.cf.faq1}}
                                {{foreach from=$faqitems key=rownum item=faqitem name=faq}}
                                {{if $faqitem.naglowek}}
                                <h2>{{$faqitem.naglowek}}</h2>
                                <hr>
                                {{else}}
                                <div class="panel panel-default">
                                    <div class="panel-heading"><a data-toggle="collapse" href="#faq1{{$rownum}}"
                                                                  aria-expanded="false" aria-controls="faq1{{$rownum}}"><i
                                                    class="icon-chevron-right"></i> {{$faqitem.pytanie}}</a>
                                    </div>
                                    <div class="panel-body collapse" id="faq1{{$rownum}}">
                                        {{$faqitem.odpowiedz}}
                                    </div>
                                </div>
                                {{/if}}
                                {{/foreach}}
                            </div>
                            <div class="col-md-6">
                                {{assign var=faqitems value=$dane.cf.faq2}}
                                {{foreach from=$faqitems key=rownum item=faqitem name=faq}}
                                {{if $faqitem.naglowek}}
                                <h2>{{$faqitem.naglowek}}</h2>
                                <hr>
                                {{else}}
                                <div class="panel panel-default">
                                    <div class="panel-heading"><a data-toggle="collapse" href="#faq2{{$rownum}}"
                                                                  aria-expanded="false" aria-controls="faq2{{$rownum}}"><i
                                                    class="icon-chevron-right"></i> {{$faqitem.pytanie}}</a>
                                    </div>
                                    <div class="panel-body collapse" id="faq2{{$rownum}}">
                                        {{$faqitem.odpowiedz}}
                                    </div>
                                </div>
                                {{/if}}
                                {{/foreach}}
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br><br>
                </div>
                <!-- END CONTENT -->
            </div>
    </section>

    {{$footer}}
    {{$scripts}}
</body>
</html>
