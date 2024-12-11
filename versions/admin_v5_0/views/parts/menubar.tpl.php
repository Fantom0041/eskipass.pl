<div class="site-menubar">
    <div class="site-menubar-body">
      <div>
        <div>
          <ul class="site-menu">
            <li class="site-menu-category">Magazyn</li>
            <li class="site-menu-item {{if $module=="home"}}active{{/if}}">
              <a href="{{$siteUrl}}admin.php" data-slug="dashboard">
                <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                <span class="site-menu-title">Pulpit</span>
              </a>
            </li>

            <li class="site-menu-item {{if $module=="slider"}}active{{/if}}">
              <a href="{{$siteUrl}}slider" data-slug="slider">
                <i class="site-menu-icon wb-image" aria-hidden="true"></i>
                <span class="site-menu-title">Slider główny</span>
              </a>
            </li>
            <li class="site-menu-category">
                Boksy
            </li>
            <li class="site-menu-item {{if $module=="boksy"}}active{{/if}}">
              <a href="{{$siteUrl}}boksy" data-slug="boksy">
                <i class="site-menu-icon wb-image" aria-hidden="true"></i>
                <span class="site-menu-title">Strona główna</span>
              </a>
            </li>

            <li class="site-menu-item {{if $module=="boksypartners"}}active{{/if}}">
              <a href="{{$siteUrl}}boksypartners" data-slug="boksypartners">
                <i class="site-menu-icon wb-image" aria-hidden="true"></i>
                <span class="site-menu-title">Dla Partnerów</span>
              </a>
            </li>

            <li class="site-menu-item {{if $module=="boksyhowtobuy"}}active{{/if}}">
              <a href="{{$siteUrl}}boksyhowtobuy" data-slug="boksyhowtobuy">
                <i class="site-menu-icon wb-image" aria-hidden="true"></i>
                <span class="site-menu-title">Jak Kupić</span>
              </a>
            </li>

            <li class="site-menu-item {{if $module=="boksyinsurance"}}active{{/if}}">
              <a href="{{$siteUrl}}boksyinsurance" data-slug="boksyinsurance">
                <i class="site-menu-icon wb-image" aria-hidden="true"></i>
                <span class="site-menu-title">Ubezpieczenia</span>
              </a>
            </li>
          </ul>


        </div>
      </div>
    </div>

    <div class="site-menubar-footer">
    </div>
  </div>