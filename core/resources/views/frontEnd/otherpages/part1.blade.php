@if($Topic->pages_content1 != 0)
        <?php
        $sect=\App\Models\WebmasterSection::findOrFail($Topic->pages_content1);

        $contents = \App\Models\Topic::where('webmaster_id', $Topic->pages_content1)->take(4)->get();
        $section_url='';
        if ($section_url == "") {
            $section_url = Helper::sectionURL($Topic->webmaster_id);
        }
        ?>
    @if($contents)
        <section style="width: 100%;padding: 20px; text-align: center;">
            <div class="section-title">
                <h2>{!! $sect->$title_var !!}</h2>
            </div>
            <div class="col-lg-6" style="display: inline-block;padding:4% ;width:80%">
                <div class="row g-4 align-items-center">
                    <div class="col-md-6">
                        <div class="row g-4">

                            <div class="col-12 wow fadeIn" data-wow-delay="0.3s" >
                                @if ($contents[0])
                                    <div class="feature-box border rounded p-4" id="features">
                                        <i class="fa fa-check fa-3x text-primary mb-3"></i>
                                        <h4 class="mb-3">{!! $contents[0][$title_var] !!}</h4>
                                        <p class="mb-3">{!! $contents[0][$details_var] !!}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 wow fadeIn" data-wow-delay="0.3s">
                                @if ($contents[1])
                                    <div class="feature-box border rounded p-4" id="features">
                                        <i class="fa fa-check fa-3x text-primary mb-3"></i>
                                        <h4 class="mb-3">{!! $contents[1][$title_var] !!}</h4>
                                        <p class="mb-3">{!! $contents[1][$details_var] !!}</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                    @if ($contents[2])
                        <div class="col-md-6 wow fadeIn" data-wow-delay="0.7s" id="features">
                            <div class="feature-box border rounded p-4" style="margin: 0 auto;">
                                <i class="fa fa-check fa-3x text-primary mb-3"></i>
                                <h4 class="mb-3">{!! $contents[2][$title_var] !!}</h4>
                                <p class="mb-3">{!! $contents[2][$details_var] !!}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
        <style>
            .rounded {

                transition: background-color 1s ease; /* Set the duration and easing function for the transition */
            }

            .rounded:hover {
                color: #FFFFFF;
                background-color: blue; /* Change the background color on hover */
            }
        </style>
    @endif
@endif
