<?php

$HomePage = Helper::Topic(Helper::GeneralWebmasterSettings("home_content8_section_id"));
//dd($HomePage)
$section_url = "";

if ($section_url == "") {
    $section_url = Helper::sectionURL($HomePage->webmaster_id);
}
?>
?>
@if(!empty($HomePage))
    @if(@$HomePage->$details_var !="")
        <section class="content-row-no-bg home-welcome " style=" padding: 4%;  margin-bottom:30px">
            <div class="section-title">
                <h2>{{__('frontend.whatNew')}}</h2>
            </div>
            <div class="container " style="padding: 10px ">
                <div class="row about-div section-bg"  style="padding: 10px">
                    <div class="col-lg-6 col-md-6 d-flex align-items-stretch mb-3" style="padding: 10px">
                        <img src="{{ url('uploads/topics/'. $HomePage->photo_file) }}" alt="computer photo" loading="lazy" alt="attach_file" class="img-fluid" style="max-width: 100%; height: auto; border-radius: 10px;"/>
                    </div>
                    <div class="col-lg-6 col-md-6  align-items-stretch mb-3 " style=" font-size: 18px; line-height: 1.6; color: #333;padding: 3%">
                       <p style="line-height: 200px"> {!! $HomePage->$details_var !!}</p>
                    </div>
                </div>

                @if(!empty($page_form))
                        <?php
                        $form_url = Helper::sectionURL($page_form->id);
                        ?>
                    <div class="text-center mt-3">
                        <a href="{{ $form_url }}" class="btn btn-lg btn-primary">
                            <i class="fa-solid fa-send-o"></i> {{ __('backend.submit') }} {!!  $page_form->{"title_".@Helper::currentLanguage()->code} !!}
                        </a>
                    </div>
                @endif
            </div>

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="more-btn">
                        <a href="{{ url($section_url) }}" class="btn btn-theme"><i
                                class="fa fa-angle-left"></i>&nbsp; {{ __('frontend.viewMore') }}
                            &nbsp;<i
                                class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </section>

    @endif
@endif
