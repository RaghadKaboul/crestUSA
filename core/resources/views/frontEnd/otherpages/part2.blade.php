@if($Topic->pages_content2 != 0)
<?php
$sect=\App\Models\WebmasterSection::findOrFail($Topic->pages_content2);
$contents = \App\Models\Topic::where('webmaster_id', $Topic->pages_content2)->take(3)->get();
$section_url='';
$lang_code = Helper::currentLanguage()->code;
$link='seo_url_slug_'.$lang_code;
if ($section_url == "") {
    $section_url = Helper::sectionURL($sect->$link);
}
//                                dd($contents)
?>
<div class="container-xxl service py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px; padding: 5%">
            <div class="section-title">
                <h2>{!! $sect->$title_var !!}</h2>
            </div>
        </div>
        <div class="row g-4 wow fadeInUp" data-wow-delay="0.3s">
            <div class="col-lg-4">
                <div class="nav nav-pills d-flex justify-content-between w-100 h-100 me-4">
                    <button class="nav-link w-100 d-flex align-items-center text-start border p-4 mb-4 active"
                            data-bs-toggle="pill" data-bs-target="#tab-pane-1" type="button">
                        <h5 class="m-0"><i class="fa fa-bars text-primary me-3"></i>{!! $contents[0][$title_var] !!}</h5>
                    </button>
                    <button class="nav-link w-100 d-flex align-items-center text-start border p-4 mb-4"
                            data-bs-toggle="pill" data-bs-target="#tab-pane-2" type="button">
                        <h5 class="m-0"><i class="fa fa-bars text-primary me-3"></i>{!! $contents[1][$title_var] !!}</h5>
                    </button>
                    <button class="nav-link w-100 d-flex align-items-center text-start border p-4 mb-4"
                            data-bs-toggle="pill" data-bs-target="#tab-pane-3" type="button">
                        <h5 class="m-0"><i class="fa fa-bars text-primary me-3"></i>{!! $contents[2][$title_var] !!}</h5>
                    </button>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="tab-content w-100">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <div class="row g-4">
                            <div class="col-md-6" style="min-height: 350px;">
                                <div class="position-relative h-100">
                                    @if($contents[0]->attach_file)
                                    <img class="position-absolute rounded w-100 h-100" src="{{ url('uploads/topics/'.$contents[0]->attach_file) }}"
                                         style="object-fit: cover;" alt="photo 1">
                                    @else
                                    <div style="align-items: center">
                                        <h3 style="text-align: center">No Photo</h3>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3 class="mb-4">{!! $contents[0][$title_var] !!}</h3>
                                <p class="mb-4">{!! $contents[0][$details_var] !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <div class="row g-4">
                            <div class="col-md-6" style="min-height: 350px;">
                                <div class="position-relative h-100">
                                    @if($contents[1]->attach_file)
                                    <img class="position-absolute rounded w-100 h-100" src="{{ url('uploads/topics/'.$contents[1]->attach_file) }}"
                                         style="object-fit: cover;" alt="photo 2">
                                    @else
                                    <div style="align-items: center">
                                        <h3 style="text-align: center">No Photo</h3>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3 class="mb-4">{!! $contents[1][$title_var] !!}</h3>
                                <p class="mb-4">{!! $contents[1][$details_var] !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row g-4">
                            <div class="col-md-6" style="min-height: 350px;">
                                <div class="position-relative h-100">
                                    @if($contents[2]->attach_file)
                                    <img class="position-absolute rounded w-100 h-100" src="{{ url('uploads/topics/'.$contents[2]->attach_file) }}"
                                         style="object-fit: cover;" alt="photo 3">
                                    @else
                                    <div style="align-items: center">
                                        <h3 style="text-align: center">No Photo</h3>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3 class="mb-4">{!! $contents[2][$title_var] !!}</h3>
                                <p class="mb-4">{!! $contents[2][$details_var] !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="more-btn">
                    <a href="{{ url($section_url) }}" class="btn btn-theme" style="width: 200px"> {{ __('frontend.viewMore') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endif
