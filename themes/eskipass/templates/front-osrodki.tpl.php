<!DOCTYPE html>
<html>
    {{$header}}
    <body id="top">

        {{$topnav}}


        <div class="wrap cstyle03">

            

            <div class="container">
                <div class="row"><br><br></div>
                <div class="row">
                                {{section name=id loop=$boksy}}
                                <div class="col-md-3">
                                        <div class="listitem">
                                                {{if $boksy[id].url != ""}}<a href="{{$boksy[id].url}}">{{/if}}
                                                    <img src="{{$siteUrl}}{{$boksy[id].img}}" alt="{{$boksy[id].text1}}"/>
                                                {{if $boksy[id].url != ""}}</a>{{/if}}
                                        </div>
                                        <div class="itemlabel">
                                                {{if $boksy[id].text1}}<h6 class="lh1 dark"><b>{{$boksy[id].text1}}</b></h6>{{/if}}
                                                {{if $boksy[id].text2}}<p class="lh1 green">{{$boksy[id].text2}}</p>{{/if}}	
                                        </div>
                                </div>
                                {{/section}}
                </div>   
                <div class="row"><br><br></div>
            </div>

            
            {{$footer}}
        </div>
        <!-- END OF WRAP -->

        {{include file="partials/scripts.tpl.php"}}
    </body>
</html>
