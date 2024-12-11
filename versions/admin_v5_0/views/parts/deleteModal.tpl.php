<!-- Modals -->
<div class="modal fade in" role="dialog" id="delete-modal">
    <div class="modal-dialog modal-danger">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Potwierdzenie usuwania</h4>
            </div>
            <div class="modal-body">
                Czy na pewno chcesz usunąć wpis "<span id="object-name"></span>"?
            </div>
            <div class="modal-footer">
                <form id="confirm-remove-form" method="post">
                    <input id="id-input" name="id" hidden value="">
                    <button type="button" class="btn btn-default" id="modal-dismiss" data-dismiss="modal">Nie</button>
                    <button type="submit" class="btn btn-danger">Tak</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- End Modals -->