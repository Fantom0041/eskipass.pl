var menuItems = $('#primary-menu-trigger').siblings('ul').find('li');

$('a').on('click', function () {
    if($(this).attr('href').indexOf('#kup-karnet') >= 0){
        $.each(menuItems.find('a'),function(){
            if($(this).attr('href').indexOf('#kup-karnet') >= 0){
                menuItems.removeClass('current');
                $(this).parent().addClass('current');
            }
        });
        $('html, body').animate({
            scrollTop: $("#boksy-sort").offset().top - 80
        }, 1000);
    }
    if($(this).attr('href').indexOf('#body') >= 0){
        $.each(menuItems.find('a'),function(){
            if($(this).attr('href').indexOf('#body') >= 0){
                menuItems.removeClass('current');
                $(this).parent().addClass('current');
            }
        });
        $('html, body').animate({
            scrollTop: $("body").offset().top
        }, 1000);
    }
    if($(this).attr('href').indexOf('#contact') >= 0){
        $.each(menuItems.find('a'),function(){
            if($(this).attr('href').indexOf('#contact') >= 0){
                menuItems.removeClass('current');
                $(this).parent().addClass('current');
            }
        });
        $('html, body').animate({
            scrollTop: $("#contact").offset().top - 100
        }, 1000);
    }
});

window.onload = hashDetect;

function hashDetect() {
    var url = document.location.toString();
    $('#url-input').val(url);
    if (url.match('#')) {
        $('.' + url.split('#')[1] + '-item').click();
    }
    var item = $('a[href="' + url + '"');
    menuItems.removeClass('current');
    item.parent().addClass('current');
};

$('.return-message').fadeIn(1500);
setTimeout(function () {
    $('.return-message').fadeOut(1500);
}, 8000);

$('.panel-heading a').on('click', function () {
    $(this).toggleClass('open');
});

$(function () {
    $('.resize_img').each(function (i, v) {
        var format = $(this).attr('data-format').split(':');
        ResizeImg(v, format);
    });

    var $flexSliderEl = $('.fslider:not(.customjs)').find('.flexslider');
    if ($flexSliderEl.length > 0) {
        $flexSliderEl.each(function () {
            var $flexsSlider = $(this),
                flexsAnimation = $flexsSlider.parent('.fslider').attr('data-animation'),
                flexsEasing = $flexsSlider.parent('.fslider').attr('data-easing'),
                flexsDirection = $flexsSlider.parent('.fslider').attr('data-direction'),
                flexsReverse = $flexsSlider.parent('.fslider').attr('data-reverse'),
                flexsSlideshow = $flexsSlider.parent('.fslider').attr('data-slideshow'),
                flexsPause = $flexsSlider.parent('.fslider').attr('data-pause'),
                flexsSpeed = $flexsSlider.parent('.fslider').attr('data-speed'),
                flexsVideo = $flexsSlider.parent('.fslider').attr('data-video'),
                flexsPagi = $flexsSlider.parent('.fslider').attr('data-pagi'),
                flexsArrows = $flexsSlider.parent('.fslider').attr('data-arrows'),
                flexsThumbs = $flexsSlider.parent('.fslider').attr('data-thumbs'),
                flexsHover = $flexsSlider.parent('.fslider').attr('data-hover'),
                flexsSheight = $flexsSlider.parent('.fslider').attr('data-smooth-height'),
                flexsTouch = $flexsSlider.parent('.fslider').attr('data-touch'),
                flexsUseCSS = false;

            if (!flexsAnimation) {
                flexsAnimation = 'slide';
            }
            if (!flexsEasing || flexsEasing == 'swing') {
                flexsEasing = 'swing';
                flexsUseCSS = true;
            }
            if (!flexsDirection) {
                flexsDirection = 'horizontal';
            }
            if (flexsReverse == 'true') {
                flexsReverse = true;
            } else {
                flexsReverse = false;
            }
            if (!flexsSlideshow) {
                flexsSlideshow = true;
            } else {
                flexsSlideshow = false;
            }
            if (!flexsPause) {
                flexsPause = 5000;
            }
            if (!flexsSpeed) {
                flexsSpeed = 600;
            }
            if (!flexsVideo) {
                flexsVideo = false;
            }
            if (flexsSheight == 'false') {
                flexsSheight = false;
            } else {
                flexsSheight = true;
            }
            if (flexsDirection == 'vertical') {
                flexsSheight = false;
            }
            if (flexsPagi == 'false') {
                flexsPagi = false;
            } else {
                flexsPagi = true;
            }
            if (flexsThumbs == 'true') {
                flexsPagi = 'thumbnails';
            } else {
                flexsPagi = flexsPagi;
            }
            if (flexsArrows == 'false') {
                flexsArrows = false;
            } else {
                flexsArrows = true;
            }
            if (flexsHover == 'false') {
                flexsHover = false;
            } else {
                flexsHover = true;
            }
            if (flexsTouch == 'false') {
                flexsTouch = false;
            } else {
                flexsTouch = true;
            }

            $flexsSlider.flexslider({
                selector: ".slider-wrap > .slide",
                animation: flexsAnimation,
                easing: flexsEasing,
                direction: flexsDirection,
                reverse: flexsReverse,
                slideshow: flexsSlideshow,
                slideshowSpeed: Number(flexsPause),
                animationSpeed: Number(flexsSpeed),
                pauseOnHover: flexsHover,
                video: flexsVideo,
                controlNav: flexsPagi,
                directionNav: flexsArrows,
                smoothHeight: flexsSheight,
                useCSS: flexsUseCSS,
                touch: flexsTouch,
                start: function (slider) {
                    SEMICOLON.widget.animations();
                    SEMICOLON.initialize.verticalMiddle();
                    slider.parent().removeClass('preloader2');
                    var t = setTimeout(function () {
                        $('.grid-container').isotope('layout');
                    }, 1200);
                    SEMICOLON.initialize.lightbox();
                    $('.flex-prev').html('<i class="icon-angle-left"></i>');
                    $('.flex-next').html('<i class="icon-angle-right"></i>');
                    SEMICOLON.portfolio.portfolioDescMargin();
                    $flexsSliderImages = $flexsSlider.find('.resize_img');
                    $flexsSliderImages.each(function (i, v) {
                        var format = $(this).attr('data-format').split(':');
                        ResizeImg(v, format, $flexsSlider);

                    });
                },
                after: function () {
                    if ($('.grid-container').hasClass('portfolio-full')) {
                        $('.grid-container.portfolio-full').isotope('layout');
                        SEMICOLON.portfolio.portfolioDescMargin();
                    }
                    if ($('.post-grid').hasClass('post-masonry-full')) {
                        $('.post-grid.post-masonry-full').isotope('layout');
                    }
                }
            });
        });
    }

    $('#boksy-sort').on('click', function () {
        var item = $(this);
        if (item.attr('data-dir') == 'asc') {
            item.attr('data-dir', 'desc');
            $('#boksy-states-clear-all').show();
            boksySort('desc');
        } else if (item.attr('data-dir') == 'desc') {
            item.attr('data-dir', 'none');
            $('#boksy-states-clear-all').hide();
            boksySort('none');
        } else {
            item.attr('data-dir', 'asc');
            $('#boksy-states-clear-all').show();
            boksySort('asc');
        }
    });

    $('body').on('click', function (e) {
        if ($('#boksy-states-list').css('display') === 'block' && !$(e.target).is('li') && !$(e.target).hasClass('label') && !$(e.target).hasClass('icon-chevron-down')) {
            $('#boksy-states-list').hide();
            $('#boksy-state').removeClass('collapsed');
        }
        if ($('#boksy-search').css('display') === 'block' && !$(e.target).is('input') && !$(e.target).hasClass('icon-search')) {
            $('#boksy-search').hide();
        }
    });

    $('#boksy-state .label').on('click', function () {
        $('#boksy-state').toggleClass('collapsed');
        $('#boksy-states-list').toggle();
    });

    $('.boksy-filters .icon-search').on('click', function () {
        $('#boksy-search').toggle();
        $('#boksy-search input').focus();
    });

    searchTimer = '';
    $('#boksy-search input').on('keyup', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(boksyFilter(), 500);
    });

    $('#boksy-states-list li').on('click', function () {
        var tab = '<span class="tab">' + $(this).text() + '<span class="icon icon-remove"></span></span>';
        $(this).addClass('selected');
        $('#boksy-states-tabs').append(tab);
        boksyFilter();
    });

    $('#boksy-states-tabs').on('click', '.tab', function () {
        if ($(this).attr('id') == 'boksy-states-clear-all') {
            $('#boksy-sort').attr('data-dir', 'none');
            boksySort('none');
            $('#boksy-states-list li.selected').each(function (i, v) {
                $(this).removeClass('selected');
            });
            $('#boksy-states-tabs .tab').each(function (i, v) {
                if ($(this).attr('id') != 'boksy-states-clear-all') {
                    $(this).remove();
                }
            });
            $('#boksy-search input').val('');
        } else {
            var tab = $(this);
            $('#boksy-states-list li.selected').each(function (i, v) {
                if ($(this).text() == tab.text()) {
                    $(this).removeClass('selected');
                }
            });
            tab.remove();
        }
        boksyFilter();
    });

    $('.boks').on('click', function () {
        var url = $(this).find('a').attr('href');
        if(url){
            window.location = url;
        }
    })

});

function boksySort(order) {
    var $elements = $('#boksy').find('.boks');
    $elements.each(function (i, v) {
        v.style.order = 1;
    });
    $elements.each(function (i, a) {
        $elements.each(function (j, b) {
            var an = a.getAttribute('data-name').toUpperCase(),
                bn = b.getAttribute('data-name').toUpperCase(),
                aOrder = a.style.order,
                bOrder = b.style.order;
            if (order == "desc") {
                console.log(an, ',', bn, an > bn);
                if (an > bn) {
                    b.style.order = +bOrder + 1;
                    return 1;
                }
                if (an < bn) {
                    a.style.order = +aOrder + 1;
                    return 1;
                }
            } else if (order == "asc") {
                if (an < bn) {
                    b.style.order = +bOrder + 1;
                    return 1;
                }
                if (an > bn) {
                    a.style.order = +aOrder + 1;
                    return 1;
                }
            }
        });
    });
}

$(window).on('resize', function () {
    setTimeout(function () {
        $('.resize_img').each(function (i, v) {
            var format = $(this).attr('data-format').split(':');
            if ($(this).parent().parent().hasClass('slide')) {
                ResizeImg(v, format, $('.flexslider'));
            } else {
                ResizeImg(v, format);
            }
        });
    }, 100);
});

function boksyFilter() {
    const searchValue = document.getElementById('boksy-search-input').value.toLowerCase();
    const $elements = $('#boksy').find('.boks');
    const $tabs = $('#boksy-states-tabs').find('.tab');
    
    if ($('#boksy-states-tabs .tab').length > 1) {
        $('#boksy-states-clear-all').show();
        $elements.each(function() {
            const $boks = $(this);
            let flag = 0;
            
            $tabs.each(function() {
                if ($(this).text() === $boks.attr('data-state')) {
                    flag = 1;
                }
            });
            
            if (flag === 1 && searchValue) {
                const name = $boks.attr('data-name').toLowerCase();
                if (!name.includes(searchValue)) {
                    flag = 0;
                }
            }
            
            if (flag === 1) {
                if ($boks.hasClass('hide')) {
                    $boks.removeClass('hide')
                         .addClass('show')
                         .fadeIn(function() {
                             $(this).delay(110).removeClass('show');
                         });
                }
            } else {
                if (!$boks.hasClass('hide')) {
                    $boks.addClass('hide')
                         .removeClass('show')
                         .delay(110)
                         .fadeOut();
                }
            }
        });
    } else {
        $('#boksy-states-clear-all').hide();
        $elements.each(function() {
            const $boks = $(this);
            let flag = 1;
            
            if (searchValue) {
                const name = $boks.attr('data-name').toLowerCase();
                if (!name.includes(searchValue)) {
                    flag = 0;
                }
            }
            
            if (flag === 1) {
                if ($boks.hasClass('hide')) {
                    $boks.removeClass('hide')
                         .addClass('show')
                         .fadeIn(function() {
                             $(this).delay(110).removeClass('show');
                         });
                }
            } else {
                if (!$boks.hasClass('hide')) {
                    $boks.addClass('hide')
                         .removeClass('show')
                         .delay(110)
                         .fadeOut();
                }
            }
        });
    }
}

function ResizeImg(img, format, slider) {
    var width = img.width;
    var height = (width / format[0]) * format[1];
    img.height = height;
    img.style.height = height + 'px';
    if (slider) {
        slider.css('height', height + 'px');
        slider.find('.flex-viewport').css('height', height + 'px');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Pobierz elementy
    const searchInput = document.getElementById('boksy-search-input');
    const statesList = document.getElementById('boksy-states-list');
    const sortButton = document.getElementById('boksy-sort');
    const clearButton = document.getElementById('boksy-states-clear-all');

    // Przywróć zapisane filtry przy ładowaniu strony
    const savedFilters = JSON.parse(localStorage.getItem('boksyFilters') || '{}');
    
    let filtersApplied = false;
    
    if (savedFilters.search) {
        searchInput.value = savedFilters.search;
        filtersApplied = true;
    }
    if (savedFilters.state) {
        const stateItems = statesList.getElementsByTagName('li');
        for (let item of stateItems) {
            if (item.getAttribute('value') === savedFilters.state) {
                item.setAttribute('selected', '');
                const tab = document.createElement('span');
                tab.className = 'tab';
                tab.textContent = savedFilters.state;
                document.getElementById('boksy-states-tabs').insertBefore(tab, clearButton);
                filtersApplied = true;
            }
        }
    }
    if (savedFilters.sortDir) {
        sortButton.setAttribute('data-dir', savedFilters.sortDir);
        updateSortIcon();
        filtersApplied = true;
    }

    // Jeśli były jakieś zapisane filtry, zastosuj je od razu
    if (filtersApplied) {
        boksyFilter();
    }

    // Zapisz filtry przy każdej zmianie
    function saveFilters() {
        const filters = {
            search: searchInput.value,
            state: getSelectedState(),
            sortDir: sortButton.getAttribute('data-dir')
        };
        localStorage.setItem('boksyFilters', JSON.stringify(filters));
    }

    // Podpięcie eventów zapisywania
    searchInput.addEventListener('input', saveFilters);
    statesList.addEventListener('click', saveFilters);
    sortButton.addEventListener('click', saveFilters);
    
    // Czyszczenie filtrów
    clearButton.addEventListener('click', function() {
        localStorage.removeItem('boksyFilters');
    });

    // Pomocnicze funkcje
    function getSelectedState() {
        const selected = statesList.querySelector('li[selected]');
        return selected ? selected.getAttribute('value') : '';
    }

    function updateSortIcon() {
        const icon = sortButton.querySelector('.icon');
        icon.className = 'icon icon-arrow-' + 
            (sortButton.getAttribute('data-dir') === 'desc' ? 'down' : 'up');
    }
});

function filterBoxes() {
    const searchValue = document.getElementById('boksy-search-input').value.toLowerCase();
    const selectedState = getSelectedState();
    const boxes = document.querySelectorAll('.boks');
    
    boxes.forEach(box => {
        const name = box.getAttribute('data-name').toLowerCase();
        const state = box.getAttribute('data-state');
        const matchesSearch = name.includes(searchValue);
        const matchesState = !selectedState || state === selectedState;
        
        box.style.display = (matchesSearch && matchesState) ? '' : 'none';
    });
}