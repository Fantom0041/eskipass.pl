$('#glyphs i').on('click', function () {
    _this = $(this);
    if (!_this.hasClass('glyph-selected')) {
        $('.glyph-selected').removeClass('glyph-selected');
        _this.addClass('glyph-selected');
    } else {
        $('.glyph-selected').removeClass('glyph-selected');
        _this.removeClass('glyph-selected');
    }
});

$('#btn-congirm-glyph').on('click', function () {
    glyph = $('.glyph-selected');
    if (glyph.length === 1) {
        $('#input-glyph').val(glyph.attr('data-name'));
        icon = $('#icon-glyph');
        icon.removeAttr('class');
        icon.addClass('icon-' + glyph.attr('data-name'));

    }
    $('#glyph-picker').modal('hide');
});

$('.pick-glyph').tooltip();

searchTimer = '';
$('#icons-search').on('keyup', function () {
    search = $(this);
    clearTimeout(searchTimer);
    searchTimer = setTimeout(function () {
        icons = $('#glyphs i');
        icons.each(function () {
            icon = $(this);
            if (search.val()) {
                var name = icon.attr('data-name').toLowerCase();
                if (name.indexOf(search.val().toLowerCase()) < 0) {
                    icon.hide();
                } else {
                    icon.show();
                }
            } else {
                icon.show();
            }
        })
    }, 200);
});
console.log('dzień dobry');