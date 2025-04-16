@if($Topic->pages_content3 != 0)
        <?php
        $sect=\App\Models\WebmasterSection::findOrFail($Topic->pages_content3);
        $contents = \App\Models\Topic::where('webmaster_id', $Topic->pages_content3)->get();
        $section_url='';
        $lang_code = Helper::currentLanguage()->code;
        $link='seo_url_slug_'.$lang_code;
        if ($section_url == "") {
            $section_url = Helper::sectionURL($sect->$link);
        }
//                                dd($contents)
        ?>
<div style="padding: 5%">

    <div class="container-xxl py-5">
        <div class="container">
            <div class="section-title">
                <h2>{!! $sect->$title_var !!}</h2>
            </div>
            <div class="row g-4 align-items-end mb-4">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    @if($sect->attach_file)
                        <img class="img-fluid rounded" src="{{ url('uploads/topics/'.$sect->attach_file) }}">
                    @else
                        <div style="align-items: center">
                            <h3 style="text-align: center">No Photo</h3>
                        </div>
                    @endif
                </div>
                @if($contents->count() >= 3)

                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                        <p class="mb-4">{!! $sect->$details_var !!}</p>
                        <div class="border rounded p-4">
                            <nav>
                                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                    <button class="nav-link fw-semi-bold active" id="nav-story-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-story" type="button" role="tab" aria-controls="nav-story"
                                            aria-selected="true">{!! $contents[0][$title_var] !!}</button>
                                    <button class="nav-link fw-semi-bold" id="nav-mission-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-mission" type="button" role="tab" aria-controls="nav-mission"
                                            aria-selected="false">{!! $contents[1][$title_var] !!}</button>
                                    <button class="nav-link fw-semi-bold" id="nav-vision-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-vision" type="button" role="tab" aria-controls="nav-vision"
                                            aria-selected="false">{!! $contents[2][$title_var] !!}</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-story" role="tabpanel"
                                     aria-labelledby="nav-story-tab">
                                    <p>{!! $contents[0][$title_var] !!}</p>
                                    <p class="mb-0">{!! $contents[0][$details_var] !!}</p>
                                </div>
                                <div class="tab-pane fade" id="nav-mission" role="tabpanel"
                                     aria-labelledby="nav-mission-tab">
                                    <p>{!! $contents[1][$title_var] !!}</p>
                                    <p class="mb-0">{!! $contents[1][$details_var] !!}</p>
                                </div>
                                <div class="tab-pane fade" id="nav-vision" role="tabpanel" aria-labelledby="nav-vision-tab">
                                    <p>{!! $contents[2][$title_var] !!}.</p>
                                    <p class="mb-0">{!! $contents[2][$details_var] !!}</p>
                                </div>
                            </div>

                            @elseif($contents->count() >= 2)
                                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                                    <p class="mb-4">{!! $sect->$details_var !!}</p>
                                    <div class="border rounded p-4">
                                        <nav>
                                            <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                                <button class="nav-link fw-semi-bold active" id="nav-story-tab" data-bs-toggle="tab"
                                                        data-bs-target="#nav-story" type="button" role="tab" aria-controls="nav-story"
                                                        aria-selected="true">{!! $contents[0][$title_var] !!}</button>
                                                <button class="nav-link fw-semi-bold" id="nav-mission-tab" data-bs-toggle="tab"
                                                        data-bs-target="#nav-mission" type="button" role="tab" aria-controls="nav-mission"
                                                        aria-selected="false">{!! $contents[1][$title_var] !!}</button>
                                            </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-story" role="tabpanel"
                                                 aria-labelledby="nav-story-tab">
                                                <p>{!! $contents[0][$title_var] !!}</p>
                                                <p class="mb-0">{!! $contents[0][$details_var] !!}</p>
                                            </div>
                                            <div class="tab-pane fade" id="nav-mission" role="tabpanel"
                                                 aria-labelledby="nav-mission-tab">
                                                <p>{!! $contents[1][$title_var] !!}</p>
                                                <p class="mb-0">{!! $contents[1][$details_var] !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($contents->count() >= 1)
                                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                                    <p class="mb-4">{!! $sect->$details_var !!}</p>
                                    <div class="border rounded p-4">
                                        <nav>
                                            <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                                <button class="nav-link fw-semi-bold active" id="nav-story-tab" data-bs-toggle="tab"
                                                        data-bs-target="#nav-story" type="button" role="tab" aria-controls="nav-story"
                                                        aria-selected="true">{!! $contents[0][$title_var] !!}</button>
                                            </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-story" role="tabpanel"
                                                 aria-labelledby="nav-story-tab">
                                                <p>{!! $contents[0][$title_var] !!}</p>
                                                <p class="mb-0">{!! $contents[0][$details_var] !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    </div>
@endif
