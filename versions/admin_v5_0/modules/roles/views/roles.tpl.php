{{include file="views/parts/head.tpl.php"}}

    <body>

	{{include file="views/parts/top.tpl.php"}}

        <div class="container-fluid">
            <div class="row-fluid">
		{{include file="views/parts/menu.tpl.php"}}
		
		
                <div id='content' class="span9 section-body">
                    <div id="section-body" class="tabbable">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="row-fluid">
                                    <div class="span12">
                                    
                                    			<div id="accordion1" class="accordion">
								<div class="accordion-group">
								    <div class="accordion-heading">
									<a class="accordion-toggle" data-toggle="collapse" href="#notification" data-original-title="">
									    <i class="icon-th icon-white"></i> <span class="divider-vertical"></span>  UPRAWNIENIA <i class="icon-chevron-down icon-white pull-right"></i>
									</a>
								    </div>
								    <div id="notification" class="accordion-body collapse in">
									<div class="accordion-inner paddind">
									    <div class="pull-left">
									    <a class="btn data-original-title" href="admin.php?a={{$activetab}}"><i class="icon-list"></i> Przeglądaj</a>
									    </div>
									    <br /><br />
									</div>
								    </div>
								</div>
							</div>

                                    <form name="items" id="items" action="admin.php?a={{$activetab}}" method="POST">
         
							<table  class="table table-bordered table-striped pull-left" id="danetab" >
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
								    <th>{{$lang.role_name}}</th>
								    <th>Skrót</th>
								    <th>Akcja</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
								{{section name=id loop=$dane}}
                                                                <tr class="odd gradeX">
                                                                    <td>{{$smarty.section.id.iteration}}</td>
								    <td>{{$dane[id].nazwa}}</td>
								    <td>{{$dane[id].skrot}}</td>
                                                                    <td class="center"><a href="admin.php?a={{$activetab}}_edit&id={{$dane[id].id}}" class="btn" title="edytuj"><i class="icon-pencil"></i></a></td>
                                                                </tr>
                                                                {{/section}}
                                                            </tbody>
                                                        </table>
                                    
                                    </form>
                                    
                                    </div>
                                </div>






                            </div>
                        </div>
                    </div>
                </div>

            </div>
	    {{include file="views/parts/foot.tpl.php"}}
        </div><!--/.fluid-container-->

        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="{{$settings_dir}}js/bootstrap.min.js"></script>

        <script src="{{$settings_dir}}js/jquery.noty.js"></script>
        <script src="{{$settings_dir}}js/jquery.dataTables.js"></script>
      
        <script src="{{$settings_dir}}js/jquery-ui.min.js"></script>
 
         <script type="text/javascript">
            $(document).ready(function(){
                $('.togglemenuleft').click(function(){
                    $('#menu-left').toggleClass('span1');
                    $('#menu-left').toggleClass('icons-only');
                    $('#menu-left').toggleClass('span3');
                    
                    $('#content').toggleClass('span6');
                    $('#content').toggleClass('span8');
                    
                    $(this).find('i').toggleClass('icon-circle-arrow-right');
                    $(this).find('i').toggleClass('icon-circle-arrow-left');
                    $('#menu-left').find('span').toggle();
                    $('#menu-left').find('.dropdown').toggle();
                });

                $('#menu-left a').click(function(){
                    $('#menu-left').find('a').removeClass('active');
                    $(this).addClass('active');
                });
        // tool tip
                $('a').tooltip('hide');

        //datePciker
                $("#datepicker").datepicker();
// switch style 
                $('a.style').click(function(){
                    var style = $(this).attr('href');
                    $('.links-css').attr('href','css/' + style);
                    return false;
                });
                
                $('#danetab').dataTable({
		  "sPaginationType": "full_numbers",
		  "oLanguage": {
		      "sLengthMenu": "Pokaż _MENU_ rekordów",
		      "sZeroRecords": "Brak pasujących rekordów",
		      "sInfo": "Pokazuję _START_ do _END_ z _TOTAL_",
		      "sInfoEmpty": "Brak rekordów",
		      "sInfoFiltered": "(odfiltrowano z _MAX_)",
		      "oPaginate": {
			"sFirst": "Pierwsza",
			"sLast": "Ostatnia",
			"sNext": "Następna",
			"sPrevious": "Poprzednia"
		      }
		  }
		});

            });
        </script>
        
        {{include file="views/parts/common.tpl.php"}}
        
    </body>
</html>
