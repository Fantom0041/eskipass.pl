<!-- Modals -->
<div class="modal fade in" role="dialog" id="glyph-picker">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Wybierz ikonkę</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label">Szukaj</label>
                    <input id="icons-search" class="form-control">
                </div>
                <div class="content" id="glyphs">
                    {{foreach $glyphs as $glyph}}
                    {{if $glyph['glyph-name']}}
                    <i class="pick-glyph icon-{{$glyph['glyph-name']}}" title="{{(string)$glyph['glyph-name']}}"
                       data-name="{{(string)$glyph['glyph-name']}}"></i>
                    {{/if}}
                    {{/foreach}}
                </div>
            </div>
            <div class="modal-footer" id='action'>
                <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                <button type="button" class="btn btn-primary" id="btn-congirm-glyph">Wybierz</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- End Modals -->