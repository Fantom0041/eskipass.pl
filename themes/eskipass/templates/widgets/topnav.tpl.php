<div id="top-bar">
    <div class="container clearfix">
        <div class="col_half nobottommargin d-none d-md-block">
            <p class="nobottommargin"><strong>Tel:</strong> 661 599 991 | <strong>Email:</strong> biuro@e-skipass.pl</p>
        </div>
        <div class="col_half col_last fright nobottommargin">
            <!-- Top Links
            ============================================= -->
            {{*
            <div class="top-links">
                <ul>
                    <li><a href="#">PL</a>
                        <ul>
                        </ul>
                    </li>
                </ul>
            </div><!-- .top-links end -->
            *}}
        </div>
    </div>
</div><!-- #top-bar end -->

<!-- Header
============================================= -->
<header id="header" class="sticky-style-2">
    {{if $return_message}}
    <div class="return-message">
        {{$return_message}}
    </div>
    {{/if}}
    <div class="container clearfix">
        <!-- Logo
        ============================================= -->
        <div id="logo">
            <a href="{{$siteUrl}}#body" class="standard-logo"
               data-dark-logo="{{$themedir}}images/eskipass_logo_{{$theme_style}}.png"><img
                        src="{{$themedir}}images/eskipass_logo_{{$theme_style}}.png" alt="Eskipass Logo"></a>
            <a href="{{$siteUrl}}#body" class="retina-logo"
               data-dark-logo="{{$themedir}}images/eskipass_logo_{{$theme_style}}.png"><img
                        src="{{$themedir}}images/eskipass_logo_{{$theme_style}}.png" alt="Eskipass Logo"></a>
        </div><!-- #logo end -->
        <ul class="header-extras">
            <li>
                <i class="i-medium i-circled i-bordered icon-thumbs-up2 nomargin"></i>
                <div class="he-text">
                    Szybka płatność online
                    <span>z Przelewy24</span>
                </div>
            </li>
            <li>
                <i class="i-medium i-circled i-bordered icon-truck2 nomargin"></i>
                <div class="he-text">
                    Terminowa dostawa
                    <span>z DPD</span>
                </div>
            </li>
            <li>
                <i class="i-medium i-circled i-bordered icon-undo nomargin"></i>
                <div class="he-text">
                    Bezpieczne zwroty
                    <span>Tylko z E-skipass</span>
                </div>
            </li>
        </ul>
    </div>
    <div id="header-wrap">
        <!-- Primary Navigation
        ============================================= -->
        <nav id="primary-menu" class="style-2">
            <div class="container clearfix">
                <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
                <ul>
                    <li><a class="body-item" href="{{$siteUrl}}#body">
                            <div>Start</div>
                        </a></li>
                    <li><a class="kup-karnet-item" href="{{$siteUrl}}#kup-karnet">
                            <div>Kup karnet</div>
                        </a></li>
                    <li><a href="{{$siteUrl}}pages/page/83/dla-partnerow.html">
                            <div>Dla partnerów</div>
                        </a></li>
                    <li><a href="{{$siteUrl}}pages/page/84/jak-kupic-karnet.html">
                            <div>Jak kupić karnet?</div>
                        </a></li>
                    <li><a href="{{$siteUrl}}pages/page/86/ubezpieczenie.html">
                            <div>Ubezpieczenie</div>
                        </a></li>
                    <li><a href="{{$siteUrl}}pages/page/58/pomoc.html">
                            <div>Pomoc</div>
                        </a></li>
                    <li><a href="{{$siteUrl}}pages/page/85/kontakt.html">
                            <div>Kontakt</div>
                        </a></li>
                </ul>
            </div>
        </nav><!-- #primary-menu end -->
    </div>
</header><!-- #header end -->