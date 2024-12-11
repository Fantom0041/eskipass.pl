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
									    <i class="icon-th icon-white"></i> <span class="divider-vertical"></span>  Edycja uprawnień <i class="icon-chevron-down icon-white pull-right"></i>
									</a>
								    </div>
								    <div id="notification" class="accordion-body collapse in">
									<div class="accordion-inner paddind">
									    <a class="btn data-original-title" href="admin.php?a={{$activetab}}"><i class="icon-list"></i> Przeglądaj</a>
									    <br /><br />
									</div>
								    </div>
								</div>
							</div>
                                    
                                    


							<form class="form-horizontal" name="edit" id="edit" action="admin.php?a={{$activetab}}_edit{{if $postback.id>0}}&id={{$postback.id}}{{/if}}" method="POST">
                                                            <fieldset>
                          
                                                                <div class="control-group">
                                                                    <label for="nazwa" class="control-label">{{$lang.editrola_name}}:</label>
                                                                    <div class="controls">
                                                                        <input type="text" id="nazwa" class="input-xlarge" name="nazwa" value="{{$postback.nazwa}}" required>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <label for="skrot" class="control-label">Skrót:</label>
                                                                    <div class="controls">
                                                                        <input type="text" id="skrot" class="input-medium" name="skrot" value="{{$postback.skrot}}" required>
                                                                    </div>
                                                                </div>
                                                                

                                                                
                                                                <div class="control-group">
								    <table class="table table-striped">
								    <thead>
								    <tr>
								      <th>{{$lang.editrola_module}}</th>
								      <th colspan="3">{{$lang.editrola_perm}}</th>
								    </tr>
								    </thead>
								    <tbody>
								    {{section name=id loop=$uprpola}}
								    <tr>
									    <td>{{$uprpola[id].k}} </td>
									    <td><input type="radio" name="{{$uprpola[id].k}}" value="-" {{if $uprpola[id].w eq "-"}}checked{{/if}} > {{$lang.editrola_no}}</td>
									    <td><input type="radio" name="{{$uprpola[id].k}}" value="r" {{if $uprpola[id].w eq "r"}}checked{{/if}} > {{$lang.editrola_r}}</td>
									    <td><input type="radio" name="{{$uprpola[id].k}}" value="w" {{if $uprpola[id].w eq "w"}}checked{{/if}} > {{$lang.editrola_w}}</td>
								    </tr>
								    {{/section}}
								    </tbody>
								    </table>
								</div>


                                                                <div class="form-actions">
                                                                    <button class="btn btn-primary" type="submit">Zapisz zmiany</button>
                                                                    <button class="btn" id="cancel" type="button">Anuluj</button>
                                                                </div>
                                                                <input type="hidden" name="save" value="1" />
                                                            </fieldset>
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
                

                
               //NOTY
               $.noty.defaultOptions.theme = 'noty_theme_twitter';
               $('#cancel').click(function() {
		    window.location.replace('admin.php?a={{$activetab}}');
               });


            });
        </script>
        
        {{include file="views/parts/common.tpl.php"}}
        
    </body>
</html>
