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
									    <i class="icon-th icon-white"></i> <span class="divider-vertical"></span>  Edycja użytkownika <i class="icon-chevron-down icon-white pull-right"></i>
									</a>
								    </div>
								    <div id="notification" class="accordion-body collapse in">
									<div class="accordion-inner paddind">
									    <a class="btn data-original-title" href="admin.php?a={{$activetab}}_add"><i class="icon-edit"></i> Utwórz nowy</a>
									    <a class="btn data-original-title" href="admin.php?a={{$activetab}}"><i class="icon-list"></i> Przeglądaj</a>
									    <br /><br />
									</div>
								    </div>
								</div>
							</div>
                                    
                                    


							<form class="form-horizontal" name="edit" id="edit" action="admin.php?a=users{{if $postback.id>0}}_edit&id={{$postback.id}}{{else}}_add{{/if}}" method="POST">
                                                            <fieldset>
                          
                                                                <div class="control-group">
                                                                    <label for="nazwa_uzytkownika" class="control-label">{{$lang.edituser_name}}:</label>
                                                                    <div class="controls">
                                                                        <input type="text" id="nazwa_uzytkownika" class="input-xlarge" name="nazwa_uzytkownika" value="{{$postback.nazwa_uzytkownika}}" required>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <label for="newpwd" class="control-label">{{$lang.edituser_pwd}}:</label>
                                                                    <div class="controls">
                                                                        <input type="password" id="newpwd" class="input-medium" name="newpwd">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <label for="newpwd2" class="control-label">{{$lang.edituser_pwd2}}:</label>
                                                                    <div class="controls">
                                                                        <input type="password" id="newpwd2" class="input-medium" name="newpwd2">
                                                                    </div>
                                                                </div>
                                                                
                                                                
                                                                <div class="control-group">
                                                                    <label for="uprawnienia" class="control-label">{{$lang.edituser_grupa}}:</label>
                                                                    <div class="controls">
                                                                        <select name="uprawnienia" id="uprawnienia" class="span3">
									  {{section name=id loop=$dataUpr}}
									  <option value="{{$dataUpr[id].id}}" {{if $dataUpr[id].id==$postback.uprawnienia}}selected{{/if}}>{{$dataUpr[id].nazwa}}</option>
									  {{/section}}
									</select>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <label for="email" class="control-label">{{$lang.edituser_email}}:</label>
                                                                    <div class="controls">
                                                                        <input type="text" id="email" class="input-xlarge" name="email" value="{{$postback.email}}" required>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <label for="imie" class="control-label">{{$lang.edituser_fn}}:</label>
                                                                    <div class="controls">
                                                                        <input type="text" id="imie" class="input-xlarge" name="imie" value="{{$postback.imie}}">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <label for="nazwisko" class="control-label">{{$lang.edituser_ln}}:</label>
                                                                    <div class="controls">
                                                                        <input type="text" id="nazwisko" class="input-xlarge" name="nazwisko" value="{{$postback.nazwisko}}">
                                                                    </div>
                                                                </div>
                                                                
                                                                
                                                                <div class="form-actions">
                                                                    <button class="btn btn-primary" type="submit">Zapisz zmiany</button>
                                                                    {{if $postback.id > 0}}<button class="btn btn-danger" type="button" id="delbtn">Usuń rekord</button>{{/if}}
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
                
                
               


		$('#meta_title').keyup(function() {
		  $('#meta_title_edited').val('1');
		});
		$('#meta_desc').keyup(function() {
		  $('#meta_desc_edited').val('1');
		});
		$('#meta_kw').keyup(function() {
		  $('#meta_kw_edited').val('1');
		});

                
               //NOTY
               $.noty.defaultOptions.theme = 'noty_theme_twitter';
               $('#cancel').click(function() {
		    window.location.replace('admin.php?a={{$activetab}}');
               });
               $('#delbtn').click(function() {
		noty({
			text: 'Czy chcesz kontynuować usuwanie?', 
			buttons: [
		    {type: 'btn btn-primary', text: 'Ok', click: function($noty) {
				$noty.close();
				window.location.replace('admin.php?a=edit{{$activetab}}&del={{$postback.id}}');
		    	}
		    },
		    {type: 'btn btn-danger', text: 'Anuluj', click: function($noty) {
		    		$noty.close();
		    	}
		    }
		    ],
		  closable: false,
		  timeout: false
		});
		return false;
	});
	
		  
		    
		    

            });
        </script>
        
        {{include file="views/parts/common.tpl.php"}}
        
        
        
    </body>
</html>
