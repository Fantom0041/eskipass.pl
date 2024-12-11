{{include file="views/parts/head.tpl.php"}}
<body class="dashboard">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

  {{include file="views/parts/nav.tpl.php"}}
  
  {{include file="views/parts/menubar.tpl.php"}}
  
  {{include file="views/parts/menugrid.tpl.php"}}


  <!-- Page -->
  <div class="page">
  
    <div class="page-header">
      <h1 class="page-title">Magazyn</h1>
      <ol class="breadcrumb">
        <li><a href="{{$siteUrl}}">Pulpit</a></li>
        <li class="active">Magazyn</li>
      </ol>
    </div>
    
    
    <div class="page-content">
      <!-- Panel -->
      <div class="panel">
        <div class="panel-body" id="table">
	  
          {{include file="modules/magazyn/views/table.tpl.php"}}
          
        </div>
      </div>
      <!-- End Panel -->
    </div>
    

  </div>
  <!-- End Page -->


  
  {{include file="views/parts/foot2.tpl.php"}}
  
  <!-- Modal -->
  <div class="modal fade" id="zmianaModal" aria-hidden="false" aria-labelledby="zmianaModalLabel" role="dialog" tabindex="-1" data-show="false">
    <div class="modal-dialog">
      <form class="modal-content">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	    <span aria-hidden="true">×</span>
	  </button>
	  <h4 class="modal-title" id="zmianaModalLabel">Masowa zmiana produktów</h4>
	</div>
	<div class="modal-body">
	  <div class="row">
	    <div class="col-lg-12 form-group">
	      <p>Uwaga! Zmiany są nieodwracalne!</p>
	    </div>
	  </div>
	  <div class="row">
	    <div class="col-lg-6 form-group">
	      <p><b>Zmiana stanów magazynowych.</b><br>
	      <i>Przykład: +100 albo -20</i></p>
	    </div>
	    <div class="col-lg-4 form-group">
	      <input type="text" class="form-control" name="qtychange" id="qtychange" placeholder="+100">
	    </div>
	    <div class="col-lg-2 form-group">
	      <button type="button" class="btn btn-default modalchangebtn" data-action="qtychange" data-method="kwota">Zmień</button>
	    </div>

	  </div>
	  
	  <div class="row">
	    <div class="col-lg-6 form-group">
	      <p><b>Zmiana ceny podstawowej.</b><br>
	      <i>Przykład: +10.00 albo -2.50</i></p>
	    </div>
	    <div class="col-lg-4 form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="pricechange" id="pricechange" placeholder="+1.30">
                    <input type="hidden" name="pricechangemethod" id="pricechangemethod" value="procent" />
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default btn-outline dropdown-toggle" data-toggle="dropdown"
                      aria-expanded="false" id="pricechangemethodlabeldrop"><span id="pricechangemethodlabel">%</span>
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li role="presentation"><a href="#" class="methodchange" role="menuitem" data-value="%" data-method="procent" data-labeltarget="pricechangemethodlabel" data-methodtarget="pricechangemethod">%</a></li>
                        <li role="presentation"><a href="#" class="methodchange" role="menuitem" data-value="zł" data-method="kwota" data-labeltarget="pricechangemethodlabel" data-methodtarget="pricechangemethod">zł</a></li>
                      </ul>
                    </div>
                  </div>
	    </div>
	    <div class="col-lg-2 form-group">
	      <button type="button" class="btn btn-default modalchangebtn" data-action="pricechange" data-method="pricechangemethod">Zmień</button>
	    </div>
	  </div>
	  
	  <div class="row">
	    <div class="col-lg-6 form-group">
	      <p><b>Zmiana cen specjalnych.</b><br>
	      <i>Przykład: +10.00 albo -2.50</i></p>
	    </div>
	    <div class="col-lg-4 form-group">
	      
		  <div class="input-group">
                    <input type="text" class="form-control" name="spricechange" id="spricechange" placeholder="+1.30">
                    <input type="hidden" name="spricechangemethod" id="spricechangemethod" value="procent" />
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default btn-outline dropdown-toggle" data-toggle="dropdown"
                      aria-expanded="false" id="spricechangemethodlabeldrop"><span id="spricechangemethodlabel">%</span>
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li role="presentation"><a href="#" class="methodchange" role="menuitem" data-value="%" data-method="procent" data-labeltarget="spricechangemethodlabel" data-methodtarget="spricechangemethod">%</a></li>
                        <li role="presentation"><a href="#" class="methodchange" role="menuitem" data-value="zł" data-method="kwota" data-labeltarget="spricechangemethodlabel" data-methodtarget="spricechangemethod">zł</a></li>
                      </ul>
                    </div>
                  </div>
	    </div>
	    <div class="col-lg-2 form-group">
	      <button type="button"class="btn btn-default modalchangebtn" data-action="spricechange" data-method="spricechangemethod">Zmień</button>
	    </div>
	  </div>
	  
	  <div class="row">
	    <div class="col-lg-6 form-group">
	      <p><b>Zmiana wszystkich cen.</b><br>
	      <i>Przykład: +10.00 albo -2.50</i></p>
	    </div>
	    <div class="col-lg-4 form-group">
	      
		  <div class="input-group">
                    <input type="text" class="form-control" name="allpricechange" id="allpricechange" placeholder="+1.30">
                    <input type="hidden" name="allpricechangemethod" id="allpricechangemethod" value="procent" />
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default btn-outline dropdown-toggle" data-toggle="dropdown"
                      aria-expanded="false" id="allpricechangemethodlabeldrop"><span id="allpricechangemethodlabel">%</span>
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li role="presentation"><a href="#" class="methodchange" role="menuitem" data-value="%" data-method="procent" data-labeltarget="allpricechangemethodlabel" data-methodtarget="allpricechangemethod">%</a></li>
                        <li role="presentation"><a href="#" class="methodchange" role="menuitem" data-value="zł" data-method="kwota" data-labeltarget="allpricechangemethodlabel" data-methodtarget="allpricechangemethod">zł</a></li>
                      </ul>
                    </div>
                  </div>
	    </div>
	    <div class="col-lg-2 form-group">
	      <button type="button"class="btn btn-default modalchangebtn" data-action="allpricechange" data-method="allpricechangemethod">Zmień</button>
	    </div>
	  </div>
	</div>
	<input type="hidden" name="act" id="act" value="" />
      </form>
    </div>
  </div>
  <!-- End Modal -->
  
  
  <!-- Modal -->
  <div class="modal fade" id="exportstanyModal" aria-hidden="false" aria-labelledby="exportstanyModalLabel" role="dialog" tabindex="-1" data-show="false">
    <div class="modal-dialog">
      <form class="modal-content" id="exportstanyFrm" action="{{$siteUrl}}{{$module}}/exportstany" method="GET">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	    <span aria-hidden="true">×</span>
	  </button>
	  <h4 class="modal-title" id="exportstanyModalLabel">Eksport stanów magazynowych</h4>
	</div>
	<div class="modal-body">
	  
	  <div class="row">
	    <div class="col-lg-8 form-group">
	      <p><b>Eksport stanów magazynowych</b></p>
	    </div>
	    <div class="col-lg-4 form-group">
	      <button type="submit" class="btn btn-default"><i class="icon wb-print" aria-hidden="true"></i>  Eksportuj do XLS</button>
	    </div>
	  </div>
	  
	</div>
      </form>
    </div>
  </div>
  <!-- End Modal -->
  
  <!-- Modal -->
  <div class="modal fade" id="exportcenyModal" aria-hidden="false" aria-labelledby="exportcenyModalLabel" role="dialog" tabindex="-1" data-show="false">
    <div class="modal-dialog">
      <form class="modal-content" id="exportcenyFrm" action="{{$siteUrl}}{{$module}}/exportceny" method="GET">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	    <span aria-hidden="true">×</span>
	  </button>
	  <h4 class="modal-title" id="exportcenyModalLabel">Eksport cennika</h4>
	</div>
	<div class="modal-body">
	  <div class="row">
	    <div class="col-lg-4 form-group">
	      <p><b>Marża allegro</b></p>
	    </div>
	    <div class="col-lg-4 form-group">
	      <div class="input-group">
		<input type="number" class="form-control" name="increase">
		<span class="input-group-addon">%</span>
	      </div>
	    </div>
	    <div class="col-lg-4 form-group">
	      <button type="submit" class="btn btn-default"><i class="icon wb-print" aria-hidden="true"></i>  Eksportuj do XLS</button>
	    </div>
	  </div>
	</div>
      </form>
    </div>
  </div>
  <!-- End Modal -->

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
  <script src="{{$themedir}}assets/vendor/editable-table/mindmup-editabletable.js"></script>
  <script src="{{$themedir}}assets/vendor/editable-table/numeric-input-example.js"></script>
  <script src="{{$themedir}}assets/vendor/icheck/icheck.min.js"></script>


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
  <script src="{{$themedir}}assets/js/components/editable-table.js"></script>
  <script src="{{$themedir}}assets/vendor/toastr/toastr.js"></script>
  <!--<script src="{{$themedir}}assets/js/components/icheck.js"></script>-->

  <script>
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": false,
      "positionClass": "toast-top-center",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
	    
	    
    function isNumeric(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }
    function LoadElements() {
	    LoadEditable();
	    $(".togrowh").hide();
	    $("#menuforselected").hide();
	    $('.rowcheck').iCheck({
	      checkboxClass: 'icheckbox_flat-blue'
	    });
	    $('#checkAll').iCheck({
	      checkboxClass: 'icheckbox_flat-blue'
	    });
    }
    function ToggleBottomMenu() {
	    var checked = false;
	    $(".rowcheck").each(function(){
		if( $(this).attr("data-checked") == "true" ) {
		      checked = true;
		}
	    });
	    if(checked) {
		$("#menuforselected").show();
		$("#menuforall").hide();
	    } else {
		$("#menuforselected").hide();
		$("#menuforall").show();
	    }
    }
    function LoadTable() {
	    $.post("{{$siteUrl}}{{$module}}/loadtable", { pname: '{{$filters.pname}}', s: {{$s}} }, function(data){
		  if(data != "") {
			$("#table").html( data );
			LoadElements();
		  } else {
			toastr["error"]("Nie udało się odświeżyć danych");
			return false;
		  }
	    }, "html");
    }
    function LoadEditable() {
	    $('.editableTable').editableTableWidget().numericInputExample().find('td:first').focus();
	    $('td.editable').on('validate', function(evt, newValue) {
		    if ( !isNumeric(newValue) ) { 
			    return false;
		    }
	    });
	    $('td.editable').on('change', function(evt, newValue) {
		    var tbl = $(this).data("tbl");
		    var field = $(this).data("field");
		    
		    if($(this).hasClass("updatebrutto")) {
			    var ub = $(this).data("brutto");
			    var brutto = Math.round(parseFloat(newValue) * 1.23 * 100) / 100;
			    $("#"+ub).text(brutto);

		    }
		    
		    if( tbl == "sp" ) {
			    var sp = $(this).data("sp");
			    $.post("{{$siteUrl}}{{$module}}/saveprice", { sp: sp, field: field, value: newValue }, function(data){
				  if(data.status) {
					return true;
				  } else {
					toastr["error"](data.err);
					return false;
				  }
			    }, "json");
		    }
		    
		    if( tbl == "qt" ) {
			    var stockavailable = $(this).data("stockavailable");
			    $.post("{{$siteUrl}}{{$module}}/savequantity", { stockavailable: stockavailable, field: field, value: newValue }, function(data){
				  if(data.status) {
					return true;
				  } else {
					toastr["error"](data.err);
					return false;
				  }
			    }, "json");
		    }
		    
		    if( tbl == "pr" ) {
			    var product = $(this).data("product");
			    $.post("{{$siteUrl}}{{$module}}/saveproduct", { product: product, field: field, value: newValue }, function(data){
				  if(data.status) {
					return true;
				  } else {
					toastr["error"](data.err);
					return false;
				  }
			    }, "json");
		    }
		    
		    if( tbl == "al" ) {
			    var product = $(this).data("product");
			    $.post("{{$siteUrl}}{{$module}}/saveallegro", { product: product, field: field, value: newValue }, function(data){
				  if(data.status) {
					return true;
				  } else {
					toastr["error"](data.err);
					return false;
				  }
			    }, "json");
		    }

	    });
    }
    (function(document, window, $) {
      'use strict';

      var Site = window.Site;

      $(document).ready(function($) {
	    Site.run();
	    $(".wb-search").trigger("click");
	    $("#zmianaModal").modal();
	    $("#exportcenyModal").modal();
	    $("#exportstanyModal").modal();
	    
	    LoadElements();
	    
	    $(document.body).on('click', '.togrow', function() {
		var elem = $(this).data("togrow");
		if( $(elem).is(":visible") ) $(elem).hide();
		else $(elem).show();
		return false;
	    });
	    
	    
	    var showall = true;
	    $(document.body).on('click', '.togrowall', function() {
		if( showall ) {
			showall = false;
			$('.togrowh').show();
		} else {
			showall = true;
			$('.togrowh').hide();
		}
		return false;
	    });
	    
	    $(document.body).on('ifChecked', '#checkAll', function() {
		$('.rowcheck').iCheck('check');
		return false;
	    });
	    
	    $(document.body).on('ifUnchecked', '#checkAll', function() {
		$('.rowcheck').iCheck('uncheck');
		return false;
	    });
	    
	    $(document.body).on('ifChecked', '.rowcheck', function() {
		$(this).attr("data-checked", true);
		ToggleBottomMenu();
		return false;
	    });
	    
	    $(document.body).on('ifUnchecked', '.rowcheck', function() {
		$(this).attr("data-checked", false);
		ToggleBottomMenu();
		return false;
	    });
	    
	    $(document.body).on('click', '.openzmiana', function() {
		var act = $(this).data("act");
		$("#act").val(act);
		
		$("#zmianaModal").modal("show");
	    });
	    
	    $(".modalchangebtn").on("click", function(){
		var action = $(this).data("action");
		var act = $("#act").val();
		var value = $("#"+action).val();
		var method = $("#"+ $(this).data("method") ).val();
		var products = [];
		var index = 0;
		
		$(".rowcheck").each(function(){
		    
		    if( $(this).attr("data-checked") == "true" || $("#act").val() == "allpage" ) {
			  products[index] = $(this).data("product");
			  index++;
		    }
		});
		
		$.post("{{$siteUrl}}{{$module}}/savemulti", { action: action, act:act, value:value, method:method, products:products, pname:'{{$filters.pname}}' }, function(data){
		      if(data.status) {
			    toastr["success"]("Zmiany zapisane!");
			    $("#zmianaModal").modal("hide");
			    LoadTable();
		      } else {
			    toastr["error"](data.err);
		      }
		}, "json");
		return false;
	    });
	    
	    $(".methodchange").on("click", function() {
		var label = $(this).data("value");
		var method = $(this).data("method");
		var labeltarget = $(this).data("labeltarget");
		var methodtarget = $(this).data("methodtarget");
		
		$("#"+labeltarget).text( label );
		$("#"+methodtarget).val( method );
		
		$("#"+labeltarget+"drop").dropdown('toggle');
		return false;
	    });
	    

	    $(document.body).on('click', '.addprice', function() {
		var cont = $(this).data("cont");
		var product = $(this).data("product");
		$.post("{{$siteUrl}}{{$module}}/addprice", { product: $(this).data("product") }, function(data){
		      if(data.status) {
			    var newrow = '<tr data-sp="'+data.row.id_specific_price+'"><td class="editable" data-sp="'+data.row.id_specific_price+'" data-field="from_quantity" data-tbl="sp">0</td><td class="editable updatebrutto" data-sp="'+data.row.id_specific_price+'" data-field="price" data-tbl="sp" data-brutto="brutto-sp-'+data.row.id_specific_price+'">0.00</td><td id="brutto-sp-'+data.row.id_specific_price+'">0.00</td><td><a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-default delprice" data-toggle="tooltip" data-original-title="Usuń" ><i class="icon wb-close" aria-hidden="true"></i></a></td></tr>';
			    $("#"+cont).append(newrow);
			    LoadEditable();
		      } else {
			    toastr["error"](data.err);
		      }
		}, "json");
		
		return false;
	    });
	    
	    $(document.body).on('click', '.delprice', function() {
		var row = $(this).parent().parent("tr");
		var sp = row.data("sp");
		$.post("{{$siteUrl}}{{$module}}/delprice", { price: sp }, function(data){
		      if(data.status) {
			    toastr["success"]("Wariant cenowy usunięty");
			    row.remove();
		      } else {
			    toastr["error"](data.err);
		      }
		}, "json");
		return false;
	    });
	    
	    $(document.body).on('click', '.exportstanybtn', function() {
		$("#exportstanyModal").modal("show");
		return false;
	    });
	    $(document.body).on('click', '.exportcenybtn', function() {
		$("#exportcenyModal").modal("show");
		return false;
	    });
	    
      });

      

    })(document, window, jQuery);
  </script>



</body>

</html>