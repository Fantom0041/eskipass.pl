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

    <div class="page-header">
        <h1 class="page-title">Boksy - Jak Kupić</h1>
        <ol class="breadcrumb">
            <li><a href="{{$siteUrl}}">Pulpit</a></li>
            <li><a href="{{$siteUrl}}boksyhowtobuy">Jak Kupić</a></li>
            <li class="active">Edycja</li>
        </ol>
    </div>


    <div class="page-content">
        <!-- Panel -->
        <div class="panel">
            <div class="panel-body">

                <form autocomplete="off" method="POST" enctype="multipart/form-data">
                    <div id="type" class="form-group form-material">
                        <label class="control-label" for="nazwa">Typ</label>
                        <input type="text" class="form-control" placeholder="Nazwa"
                               value="{{$postback.type}}" disabled/>
                    </div>
                    <div id="name_div" class="form-group form-material">
                        <label class="control-label" for="nazwa">Nazwa</label>
                        <input type="text" class="form-control" id="nazwa" name="nazwa" placeholder="Nazwa"
                               value="{{$postback.nazwa}}"
                        />
                    </div>

                    {{if !($postback.type=="bottom_left" || $postback.type=="bottom_right" ||
                    $postback.type=="bottom_group")}}
                    <div class="form-group form-material">
                        <label class="control-label" for="url">Url</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="Url"
                               value="{{$postback.url}}"
                        />
                    </div>
                    {{/if}}

                    <div class="form-group form-material">
                        <label class="control-label" for="text1">Tekst 1</label>
                        <textarea class="form-control" id="text1" name="text1" rows="3">{{$postback.text1}}</textarea>
                    </div>

                    <div class="form-group form-material">
                        <label class="control-label" for="text2">Tekst 2</label>
                        <textarea class="form-control" id="text2" name="text2" rows="3">{{$postback.text2}}</textarea>
                    </div>

                    {{if $postback.type=="middle"}}
                    <div class="form-group form-material">
                        <label class="control-label" for="text3">Tekst Przycisku</label>
                        <textarea class="form-control" id="text3" name="text3" rows="3">{{$postback.text3}}</textarea>
                    </div>
                    {{/if}}

                    {{if $postback.type=="bottom_group"}}
                    <div class="form-group form-material">
                        <label class="control-label" for="text3">Tekst 3</label>
                        <textarea class="form-control" id="text3" name="text3" rows="3">{{$postback.text3}}</textarea>
                    </div>
                    {{/if}}

                    {{if $postback.type=="bottom_left" || $postback.type=="bottom_right" ||
                    $postback.type=="bottom_group"}}
                    <div class="form-group form-material">
                        <label class="control-label" for="text4">Ikonka</label>
                        <input name="text4" id="input-glyph" value="{{$postback.text4}}" hidden>
                        <i id="icon-glyph" class="icon-{{$postback.text4}}" style="font-size: 32px"></i>
                        {{if !trim($postback.text4) }}
                        <span id="no-icon">Nie wybrano ikonki</span>
                        {{/if}}
                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal"
                                data-target="#glyph-picker"
                                id="btn-glyph-picker">Wybierz ikonkę
                        </button>
                    </div>
                    {{/if}}

                    <div class="form-group form-material">
                        <label class="control-label" for="orderby">Sortowanie</label>
                        <input type="text" class="form-control" id="orderby" name="orderby" placeholder="0"
                               value="{{$postback.orderby}}"
                        />
                    </div>

                    <div class="form-group  form-material">
                        <div class="checkbox-custom checkbox-default">
                            <input type="checkbox" id="ishidden" name="ishidden" autocomplete="off" {{if
                                   $postback.ishidden== 1 || $postback.ishidden== 'on'}}checked{{/if}}>
                            <label for="ishidden">Ukryj ten boks</label>
                        </div>
                    </div>

                    {{if $postback.type!=="bottom_left" && $postback.type!=="bottom_right" &&
                    $postback.type!=="bottom_group"}}
                    <div class="form-group form-material">
                        <label class="control-label" for="newimg">Obrazek
                            <small> {{if $postback.type == "osrodek" || $postback.type == "logo"}} (w formacie 16:9 -
                                najlepiej od 512x288 do 1920x1080) {{else}} (w formacie 4:3 - najlepiej od 512x384 do
                                1920x1440) {{/if}}
                            </small>
                        </label>
                        <input type="text" class="form-control" placeholder="Wybierz z dysku.." readonly=""/>
                        <input type="file" id="newimg" name="newimg" multiple=""/>
                        <input type="hidden" name="img" id="img" value="{{$postback.img}}"/>
                    </div>

                    {{if $postback.img != ''}}
                    <div class="thumbnail">
                        <img src="{{$siteUrl}}{{$postback.img}}" class="img-responsive" id="imgthumb"/>
                        <div class="caption">
                            <p>Aktualny obrazek</p>
                            <p>
                                <button class="btn btn-danger btn-sm" id="delimg">usuń</button>
                            </p>
                        </div>
                    </div>

                    {{/if}}
                    {{/if}}


                    <div class="form-group form-material">
                        <br><br>
                        <hr>
                        <button class="btn btn-primary btn-lg">Zapisz zmiany</button>
                        <input type="hidden" name="save" value="1"/>
                    </div>
                </form>

            </div>
        </div>
        <!-- End Panel -->
    </div>


</div>
<!-- End Page -->

{{include file="views/parts/iconPicker.tpl.php"}}
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

<!-- Plugins For This Page -->
<script src="{{$themedir}}assets/vendor/editable-table/numeric-input-example.js"></script>
<script src="{{$themedir}}assets/vendor/icheck/icheck.min.js"></script>
<script src="{{$themedir}}assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>


<script src="{{$themedir}}assets/vendor/datatables/jquery.dataTables.js"></script>
<script src="{{$themedir}}assets/vendor/datatables-fixedheader/dataTables.fixedHeader.js"></script>
<script src="{{$themedir}}assets/vendor/datatables-bootstrap/dataTables.bootstrap.js"></script>
<script src="{{$themedir}}assets/vendor/datatables-responsive/dataTables.responsive.js"></script>
<script src="{{$themedir}}assets/vendor/datatables-tabletools/dataTables.tableTools.js"></script>
<script src="{{$themedir}}assets/vendor/asrange/jquery-asRange.min.js"></script>
<script src="{{$themedir}}assets/vendor/bootbox/bootbox.js"></script>
<script src="{{$themedir}}assets/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>


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
<script src="{{$themedir}}assets/vendor/toastr/toastr.js"></script>
<!--<script src="{{$themedir}}assets/js/components/icheck.js"></script>-->
<script src="{{$themedir}}assets/js/components/jquery-placeholder.js"></script>
<script src="{{$themedir}}assets/js/components/material.js"></script>
<script src="{{$themedir}}assets/js/components/bootstrap-datepicker.js"></script>

<script src="{{$themedir}}assets/js/iconPicker.js"></script>

<script>
    (function (document, window, $) {
        'use strict';

        var Site = window.Site;

        $(document).ready(function ($) {
            Site.run();

            $("#delimg").on("click", function () {
                $(this).remove();
                $("#imgthumb").remove();
                $("#img").val('');
            });

        });

    })(document, window, jQuery);

    $('#type').on('change', function () {
        if ($(this).val() == 'osrodek') {
            var block = '                <div id="state_div" class="form-group form-material">\n' +
                '                    <label class="control-label" for="orderby">Województwo</label>\n' +
                '                    <select name="state" id="state" class="form-control">\n' +
                '                        {{section name=id loop=$states}}\n' +
                '                            <option value="{{$states[id]}}" {{if $postback.state == $states[id]}} selected {{/if}}>{{$states[id]}}</option>\n' +
                '                        {{/section}}\n' +
                '                    </select>\n' +
                '                </div>';
            var date_block = '<div id="date_div" class="form-group form-material">\n' +
                '                        <label class="control-label" for="datastart">Okres publikacji</label>\n' +
                '                        <div class="input-daterange" data-plugin="datepicker">\n' +
                '                            <div class="input-group">\n' +
                '                      <span class="input-group-addon">\n' +
                '                        <i class="icon wb-calendar" aria-hidden="true"></i>\n' +
                '                      </span>\n' +
                '                                <input type="text" class="form-control" name="start" value="{{$postback.start}}"/>\n' +
                '                            </div>\n' +
                '                            <div class="input-group">\n' +
                '                                <span class="input-group-addon">do</span>\n' +
                '                                <input type="text" class="form-control" name="end" value="{{$postback.end}}"/>\n' +
                '                            </div>\n' +
                '                        </div>\n' +
                '                    </div>';
            $('#name_div').after(date_block);
            $('#type_div').after(block);
        } else {
            $('#state_div').remove();
            $('#date_div').remove();
        }
    });

</script>


</body>

</html>