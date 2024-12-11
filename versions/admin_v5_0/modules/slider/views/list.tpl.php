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
        <h1 class="page-title">Slider główny</h1>
        <ol class="breadcrumb">
            <li><a href="{{$siteUrl}}">Pulpit</a></li>
            <li class="active">Slider główny</li>
        </ol>
    </div>


    <div class="page-content">
        <!-- Panel -->
        <div class="panel">
            <div class="panel-body">

                <table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nazwa</th>
                        <th>Od</th>
                        <th>Do</th>
                        <th>Ukryty</th>
                        <th>Kolejność</th>
                        <th class="toright"><a href="{{$siteUrl}}slider/edit" class="btn btn-success btn-sm">utwórz</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    {{section name=id loop=$dane}}
                    <tr>
                        <td>{{$dane[id].id}}</td>
                        <td>{{$dane[id].nazwa}}</td>
                        <td>{{$dane[id].datastart_iso}}</td>
                        <td>{{$dane[id].datastop_iso}}</td>
                        <td>{{if $dane[id].ishidden == 1}}tak{{/if}}</td>
                        <td>{{$dane[id].orderby}}</td>
                        <td class="toright">
                            <button type="button" data-href="{{$siteUrl}}slider?id={{$dane[id].id}}"
                                    data-name="{{$dane[id].nazwa}}" data-id="{{$dane[id].id}}"
                                    class="btn btn-danger btn-sm remove-slider">usuń
                            </button>
                            <a href="{{$siteUrl}}slider/edit?id={{$dane[id].id}}" class="btn btn-info btn-sm">edytuj</a>
                        </td>
                    </tr>
                    {{/section}}
                    </tbody>
                </table>

            </div>
        </div>
        <!-- End Panel -->
    </div>


</div>
<!-- End Page -->


{{include file="views/parts/foot2.tpl.php"}}
{{include file="views/parts/deleteModal.tpl.php"}}


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


<script src="{{$themedir}}assets/vendor/datatables/jquery.dataTables.js"></script>
<script src="{{$themedir}}assets/vendor/datatables-fixedheader/dataTables.fixedHeader.js"></script>
<script src="{{$themedir}}assets/vendor/datatables-bootstrap/dataTables.bootstrap.js"></script>
<script src="{{$themedir}}assets/vendor/datatables-responsive/dataTables.responsive.js"></script>
<script src="{{$themedir}}assets/vendor/datatables-tabletools/dataTables.tableTools.js"></script>
<script src="{{$themedir}}assets/vendor/asrange/jquery-asRange.min.js"></script>
<script src="{{$themedir}}assets/vendor/bootbox/bootbox.js"></script>


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
<script src="{{$themedir}}assets/js/components/datatables.js"></script>

<script>
    (function (document, window, $) {
        'use strict';

        var Site = window.Site;

        $(document).ready(function ($) {
            Site.run();

            let body = $('body');
            let modal = body.find('#delete-modal');
            let removeForm = modal.find('#confirm-remove-form');
            let idInput = removeForm.find('#id-input');
            let objectName = modal.find('#object-name');

            $(body).on('click', '.remove-slider', function () {
                removeForm.attr('action', $(this).attr('data-href'));
                idInput.val($(this).attr('data-id'));
                objectName.html($(this).attr('data-name'));
                modal.show();
            });

            $('#modal-dismiss').on('click', function () {
                modal.hide();
            })

        });

    })(document, window, jQuery);
</script>


</body>

</html>