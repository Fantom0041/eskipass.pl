	  {{if $filters.pname != ""}}
		<h3>Filtr: <strong>{{$filters.pname|@urldecode}}</strong> <a href="{{$siteUrl}}{{$module}}/list" class="btn btn-sm btn-icon btn-pure btn-default" data-toggle="tooltip" data-original-title="Usuń filtr" ><i class="icon wb-close" aria-hidden="true"></i></a></h3>
	  {{/if}}
        
          <table class="editable-table table table-striped editableTable">
            <thead>
              <tr>
		<th><input type="checkbox" class="icheckbox-primary" id="checkAll" data-plugin="iCheck" data-checkbox-class="icheckbox_flat-blue" /></th>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Cena standardowa netto</th>
                <th>Cena standardowa brutto</th>
                <th>Cena Allegro netto</th>
                <th>Cena Allegro brutto</th>
                <th>Ilość w magazynie</th>
                <th><a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-default togrowall" data-showall="true" data-toggle="tooltip" data-original-title="Ceny specjalne" ><i class="icon wb-edit" aria-hidden="true"></i></a></th>
              </tr>
            </thead>
            <tbody>
	      
	      {{section name=id loop=$dane}}
              <tr>
		<td><input type="checkbox" class="icheckbox-primary rowcheck" name="rowcheck[{{$dane[id].id_product}}]" data-product="{{$dane[id].id_product}}" data-plugin="iCheck" data-checkbox-class="icheckbox_flat-blue" /></td>
                <td>{{$dane[id].id_product}}</td>
                <td>{{$dane[id].name}}</td>
                <td class="editable updatebrutto" data-product="{{$dane[id].id_product}}" data-field="price" data-tbl="pr" data-brutto="brutto-{{$dane[id].id_product}}">{{$dane[id].price}}</td>
                <td id="brutto-{{$dane[id].id_product}}">{{$dane[id].price_brutto}}</td>
                <td class="editable updatebrutto" data-product="{{$dane[id].id_product}}" data-field="price" data-tbl="al" data-brutto="brutto-al-{{$dane[id].id_product}}">{{$dane[id].al.price}}</td>
                <td id="brutto-al-{{$dane[id].id_product}}">{{$dane[id].al.price_brutto}}</td>
                <td class="editable" data-stockavailable="{{$dane[id].id_stock_available}}" data-field="quantity" data-tbl="qt">{{$dane[id].quantity}}</td>
                <td><a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-default togrow" data-togrow="#togrow{{$dane[id].id_product}}" data-toggle="tooltip" data-original-title="Ceny specjalne" ><i class="icon wb-edit" aria-hidden="true"></i></a></td>
              </tr>
              <tr class="hidden"></tr>
              <tr class="togrowh" id="togrow{{$dane[id].id_product}}">
                <td colspan="6">
		    
		    <table class="table table-condensed editable-table editableTable">
                    <thead>
                      <tr>
                        <th>Ilość od</th>
                        <th>Cena netto</th>
                        <th>Cena brutto</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody id="cspeccont{{$dane[id].id_product}}">
		      {{assign var=sp value=$dane[id].sp}}
		      {{section name=idp loop=$sp}}
                      <tr data-sp="{{$sp[idp].id_specific_price}}">
                        <td class="editable" data-sp="{{$sp[idp].id_specific_price}}" data-field="from_quantity" data-tbl="sp">{{$sp[idp].from_quantity}}</td>
                        <td class="editable updatebrutto" data-sp="{{$sp[idp].id_specific_price}}" data-field="price" data-tbl="sp" data-brutto="brutto-sp-{{$sp[idp].id_specific_price}}">{{$sp[idp].price}}</td>
                        <td id="brutto-sp-{{$sp[idp].id_specific_price}}">{{$sp[idp].price_brutto}}</td>
                        <td><a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-default delprice" data-toggle="tooltip" data-original-title="Usuń" ><i class="icon wb-close" aria-hidden="true"></i></a></td>
                      </tr>
                      {{/section}}
                    </tbody>
                  </table>
                  
                  <button type="button" class="btn btn-info btn-xs addprice" data-cont="cspeccont{{$dane[id].id_product}}" data-product="{{$dane[id].id_product}}"><i class="icon wb-plus" aria-hidden="true"></i> Dodaj wariant cenowy</button>
                  <br><br>
		    
                </td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              {{/section}}
              
            </tbody>
            <tfoot>
	      <tr>
		 <td colspan="9">
		      <div id="menuforselected">
		      Zaznaczone produkty: <button type="button"  class="btn btn-info btn-xs openzmiana" data-act="selected"><i class="icon wb-graph-up" aria-hidden="true"></i> Zmiana</button>
		      </div>
		      
		      <div id="menuforall">
		      Na tej stronie:  <button type="button"  class="btn btn-info btn-xs openzmiana"  data-act="allpage"><i class="icon wb-graph-up" aria-hidden="true"></i> Zmiana</button>
		      &nbsp;&nbsp;&nbsp;&nbsp;
		      Wszystkie strony: 
		      <button type="button" class="btn btn-info btn-xs openzmiana" data-act="all"><i class="icon wb-graph-up" aria-hidden="true"></i> Zmiana</button> 
		      <button type="button" class="btn btn-info btn-xs exportstanybtn"><i class="icon wb-print" aria-hidden="true"></i> Wydruk stanów</button> 
		      <button type="button" class="btn btn-info btn-xs exportcenybtn"><i class="icon wb-print" aria-hidden="true"></i> Wydruk cen</button>
		      </div>
		 </td>
	      </tr>
            </tfoot>
            
          </table>
          
          {{if $pages[1]}}
	  <nav>
	    <ul class="pagination">
	      <li{{if $s==1}} class="disabled"{{/if}}>
		<a href="{{$pagesurl}}s={{$s-1}}" aria-label="Previous">
		  <span aria-hidden="true">&laquo;</span>
		</a>
	      </li>
	      
	      {{section name=id loop=$pages}}
	      <li{{if $s == $pages[id]}} class="active"{{/if}}>
	      {{if $s == $pages[id]}}
		<span>{{$pages[id]}} <span class="sr-only">(current)</span></span>
	      {{else}}
		{{if $pages[id]=="..."}} <a href="#">...</a>
		{{else}}<a href="{{$pagesurl}}s={{$pages[id]}}" title="strona {{$pages[id]}}">{{$pages[id]}}</a>
		{{/if}}
	      {{/if}}
	      </li>
	      {{/section}}
	      
	      <li{{if $s==$smax}} class="disabled"{{/if}}>
		<a href="{{$pagesurl}}s={{$s+1}}" aria-label="Next">
		  <span aria-hidden="true">&raquo;</span>
		</a>
	      </li>
	    </ul>
	  </nav>
	  {{/if}}