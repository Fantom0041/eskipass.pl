<div id="contact" class="container clearfix contact bottommargin-lg">
    <div class="row">
        <div class="col-lg-8 col-md-6 col-sm-12">
            <div class="fancy-title title-dotted-border">
                <h3>Skontaktuj się z Nami</h3>
            </div>
            <div class="contact-widget">
                <div class="contact-form-result"></div>
                <form class="nobottommargin" id="template-contactform" name="template-contactform" action="{{$siteUrl}}mail/mail.html" method="post">
                    <div class="form-process"></div>
                    <div class="col_full">
                        <label for="template-contactform-email">Email <small>*</small></label>
                        <input type="email" id="template-contactform-email" name="template-contactform-email" value="" class="required email sm-form-control" required/>
                    </div>

                    <div class="clear"></div>
                    <div class="col_full">
                        <label for="template-contactform-message">Wiadomosć <small>*</small></label>
                        <textarea class="required sm-form-control" id="template-contactform-message" name="template-contactform-message" rows="12" cols="30" required></textarea>
                    </div>
                    <div class="col_full hidden">
                        <input type="hidden" id="url-input" name="mail_back">
                        <input type="text" id="template-contactform-botcheck" name="template-contactform-botcheck" value="" class="lg-form-control" />
                    </div>
                    <div class="col_full" style="font-size: 10px;">
                        <input type="checkbox" style="margin-right: 5px" required/> Niniejszym wyrażam zgodę na przetwarzanie moich danych osobowych przez E-skipass Sp. z o.o. z siedzibą w Woli Filipowskiej (Administrator) w celu udzielenia odpowiedzi na złożone zapytanie, w tym za pomocą środków komunikacji elektronicznej, w tym drogą mailową, telefoniczną, listownie. Otrzymałem/otrzymałam informację, iż mam prawo w dowolnym momencie wycofać zgodę, - wycofanie zgody nie wpływa na zgodność z prawem przetwarzania, którego dokonano na podstawie zgody przed jej wycofaniem.

                        Więcej informacji na temat przetwarzania Państwa danych osobowych znajduje się w Polityce Prywatności.
                    </div>
                    <input class="g-recaptcha button button-border button-dark button-rounded nomargin" tabindex="5"  data-sitekey="6LeOpMQUAAAAAKrzE7E4XunyC2dkqrukOstkGLEa" data-callback='onSubmit' type="submit" value="Wyślij wiadomość">
                </form>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="row">
                <div class="col-md-9 col-sm-12 clearfix bottommargin-sm" style="margin-left: auto">
                    <div class="feature-box fbox-center fbox-bg fbox-plain">
                        <div class="fbox-icon">
                            <a href="mailto:biuro@e-skipass.pl"><i class="icon-mail"></i></a>
                        </div>
                        <h3>Napisz do nas<span class="subtitle">biuro@e-skipass.pl</span></h3>
                    </div>
                </div>
                {{*
                <div class="col-md-9 col-sm-12 clearfix bottommargin-sm" style="margin-left: auto" >
                    <div class="feature-box fbox-center fbox-bg fbox-plain">
                        <div class="fbox-icon">
                            <a href="tel:661-599-991"><i class="icon-phone3"></i></a>
                        </div>
                        <h3>Zadzwoń<span class="subtitle">661 599 991</span></h3>
                    </div>
                </div>
                *}}
                <div class="col-md-9 col-sm-12 clearfix" style="margin-left: auto">
                    <div class="feature-box fbox-center fbox-bg fbox-plain">
                        <div class="fbox-icon">
                            <a target="_blank" href="https://www.google.pl/maps/place/Wola+Filipowska/@50.1364282,19.5292882,12.5z/data=!4m5!3m4!1s0x4716f1aeb663c023:0xaa3c587733c2835a!8m2!3d50.1340006!4d19.5797138"><i class="icon-map-marker2"></i></a>
                        </div>
                        <h3>Lokalizacja<span class="subtitle">WOLA FILIPOWSKA, Polska</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>