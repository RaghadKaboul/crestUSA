@extends('frontEnd.layouts.master')

@section('content')
    <div>
{{--        @dd($Topic)--}}
        <?php
        $title_var = "title_" . @Helper::currentLanguage()->code;
        $title_var2 = "title_" . config('smartend.default_language');
        $details_var = "details_" . @Helper::currentLanguage()->code;
        $details_var2 = "details_" . config('smartend.default_language');
        if ($Topic->$title_var != "") {
            $title = $Topic->$title_var;
        } else {
            $title = $Topic->$title_var2;
        }
        if ($Topic->$details_var != "") {
            $details = $details_var;
        } else {
            $details = $details_var2;
        }
        $section = "";
        try {
            if ($Topic->section->$title_var != "") {
                $section = $Topic->section->$title_var;
            } else {
                $section = $Topic->section->$title_var2;
            }
        } catch (Exception $e) {
            $section = "";
        }


        $webmaster_section_title = "";
        $category_title = "";
        $page_title = "";
        $category_image = "";

        if (@$WebmasterSection != "none") {
            if (@$WebmasterSection->$title_var != "") {
                $webmaster_section_title = @$WebmasterSection->$title_var;
            } else {
                $webmaster_section_title = @$WebmasterSection->$title_var2;
            }
            $page_title = $webmaster_section_title;
            if (@$WebmasterSection->photo != "") {
                $category_image = URL::to('uploads/topics/' . @$WebmasterSection->photo);
            }
        }
        if (!empty($CurrentCategory)) {
            if (@$CurrentCategory->$title_var != "") {
                $category_title = @$CurrentCategory->$title_var;
            } else {
                $category_title = @$CurrentCategory->$title_var2;
            }
            $page_title = $category_title;
            if (@$CurrentCategory->photo != "") {
                $category_image = URL::to('uploads/sections/' . @$CurrentCategory->photo);
            }
        }

        $attach_file = @$Topic->attach_file;
        if (@$Topic->attach_file != "") {
            $file_ext = strrchr($Topic->attach_file, ".");
            $file_ext = strtolower($file_ext);
            if (in_array($file_ext, [".jpg", ".jpeg", ".png", ".gif", ".webp"])) {
                $category_image = URL::to('uploads/topics/' . @$Topic->attach_file);
                $attach_file = "";
            }
        }
        ?>
        @if($category_image !="")
            @include("frontEnd.topic.cover")
        @endif
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>{!! (@$WebmasterSection->id ==1)?$title:$page_title !!}</h2>
                    <ol>
                        <li><a href="{{ Helper::homeURL() }}">{{ __("backend.home") }}</a></li>
                        @if($webmaster_section_title !="")
                            <li class="active"><a
                                    href="{{ Helper::sectionURL(@$WebmasterSection->id) }}">{!! (@$WebmasterSection->id ==1)?$title:$webmaster_section_title !!}</a>
                            </li>
                        @else
                            <li class="active">{{ $title }}</li>
                        @endif
                        @if($category_title !="")
                            <li class="active"><a
                                    href="{{ Helper::categoryURL(@$CurrentCategory->id) }}">{{ $category_title }}</a>
                            </li>
                        @endif
                    </ol>
                </div>
            </div>
        </section>

        <section id="content" style="padding: 20px;">
            <div class="container topic-page"style="padding: 20px;"  >
                <div class="row" style="padding: 20px;" >
                    @if($Categories->count() >1)
                        @include('frontEnd.layouts.side')
                    @endif
                    <div
                        class="col-lg-{{($Categories->count()>1)? "9":"12"}} col-md-{{($Categories->count()>1)? "7":"12"}} col-sm-12 col-xs-12">
                        <article class="mb-5"   >
                            <div class=" d-flex align-items-stretch" style=" width: 100%">
                               @if($WebmasterSection->type==2 && $Topic->video_file!="")
                                   {{--                                video--}}
                                   <div class="post-video" style="align-items: center">

                                       @if($WebmasterSection->title_status)
                                           <div class="post-heading">
                                               <h1>
                                                   @if($Topic->icon !="")
                                                       <i class="fa {!! $Topic->icon !!} "></i>&nbsp;
                                                   @endif
                                                   {{ $title }}
                                               </h1>
                                           </div>
                                       @endif
                                       <div class="video-container" style="padding-bottom: 10%">
                                           @if($Topic->video_type ==1)
                                                   <?php
                                                   $Youtube_id = Helper::Get_youtube_video_id($Topic->video_file);
                                                   ?>
                                               @if($Youtube_id !="")
                                                   {{--                                                 Youtube Video--}}
                                                   <iframe allowfullscreen class="video-iframe"
                                                           src="https://www.youtube.com/embed/{{ $Youtube_id }}?autoplay=1&mute=1"
                                                           allow="autoplay">
                                                   </iframe>
                                               @endif
                                           @elseif($Topic->video_type ==2)
                                                   <?php
                                                   $Vimeo_id = Helper::Get_vimeo_video_id($Topic->video_file);
                                                   ?>
                                               @if($Vimeo_id !="")
                                                   {{--                                                 Vimeo Video--}}
                                                   <iframe allowfullscreen class="video-iframe"
                                                           src="https://player.vimeo.com/video/{{ $Vimeo_id }}?title=0&amp;byline=0">
                                                   </iframe>
                                               @endif

                                           @elseif($Topic->video_type ==3)
                                               @if($Topic->video_file !="")
                                                   {{--                                                 Embed Video--}}
                                                   {!! $Topic->video_file !!}
                                               @endif

                                           @else
                                               <video class="video-js" controls autoplay preload="auto" width="80%"
                                                      height="500"
                                                      poster="{{ URL::to('uploads/topics/'.$Topic->photo_file) }}"
                                                      data-setup="{}">
                                                   <source src="{{ URL::to('uploads/topics/'.$Topic->video_file) }}"
                                                           type="video/mp4"/>
                                                   <p class="vjs-no-js">
                                                       To view this video please enable JavaScript, and consider upgrading
                                                       to a
                                                       web browser that
                                                       <a href="https://videojs.com/html5-video-support/" target="_blank">supports
                                                           HTML5 video</a>
                                                   </p>
                                               </video>
                                           @endif

                                               <div  style=" font-size: 30px; color: #333;">
                                                   {!! str_replace('"#','"'.Request::url().'#',$Topic->$details) !!}
                                               </div>

                                       </div>

                                   </div>
                               @elseif($WebmasterSection->type==3 && $Topic->audio_file!="")
                                   {{--                                audio--}}
                                   <div class="post-audio">
                                       @if($WebmasterSection->title_status)
                                           <div class="post-heading">
                                               <h1>
                                                   @if($Topic->icon !="")
                                                       <i class="fa {!! $Topic->icon !!} "></i>&nbsp;
                                                   @endif
                                                   {{ $title }}
                                               </h1>
                                           </div>
                                       @endif
                                       @if($Topic->photo_file !="")
                                           <img src="{{ URL::to('uploads/topics/'.$Topic->photo_file) }}"  loading="lazy"
                                                alt="{{ $title }}"/>
                                       @endif
                                       <div class="audio-player">
                                           <audio crossorigin preload="none">
                                               <source
                                                   src="{{ URL::to('uploads/topics/'.$Topic->audio_file) }}"
                                                   type="audio/mpeg">
                                           </audio>
                                       </div>
                                           <div class="col-lg-6 col-md-6  align-items-stretch mb-3" style=" font-size: 30px; line-height: 1.6; color: #333;">

                                               {!! str_replace('"#','"'.Request::url().'#',$Topic->$details) !!}
                                           </div>
                                   </div>
                                   <br>
                               @elseif(count($Topic->photos)>0)
                                   {{--                                photo slider--}}
                                   <div style="padding: 10px">
                                       @if($WebmasterSection->title_status)
                                           <div class="post-heading">
                                               <h1>
                                                   @if($Topic->icon !="")
                                                       <i class="fa {!! $Topic->icon !!} "></i>&nbsp;
                                                   @endif
                                                   {{ $title }}
                                               </h1>
                                           </div>
                                       @endif
                                       @if($Topic->photo_file !="")
                                               <div class="container" style="height:100%;padding: 10px;">
                                                   <div class="row about-div section-bg" style="padding: 10px">
                                                       <div class="col-lg-6 col-md-6 d-flex align-items-stretch mb-3" style="padding: 10px; position: relative;">
                                                           <div class="post-image mb-2">
                                                               <a href="{{ URL::to('uploads/topics/'.$Topic->photo_file) }}"
                                                                  class="galelry-lightbox" title="{{ $title }}">
                                                                   <img  loading="lazy"
                                                                         src="{{ URL::to('uploads/topics/'.$Topic->photo_file) }}"
                                                                         alt="{{ $title }}" class="post-main-photo">
                                                               </a>

                                                           </div>
                                                       </div>
                                                       <div class="col-lg-6 col-md-6 align-items-stretch mb-3" style=" font-size: 30px; line-height: 1.6; color: #333;">
                                                           {!! str_replace('"#','"'.Request::url().'#',$Topic->$details) !!}
                                                       </div>
                                                   </div>
                                               </div>

                                       @endif

                                           <div class="container" style="height:100%;padding: 10px;">
                                               <div class="row about-div " style="padding: 10px;border-style: solid;border-color: #4a5568;border-radius:30px ;">
                                                   <div class="col-lg-6 col-md-6 d-flex align-items-stretch mb-3" style="padding: 10px; position: relative;">
                                                       <img id="slideshow" src="{{ URL::to('uploads/topics/'.$Topic->photos[0]->file) }}" loading="lazy"
                                                            alt="{{ $Topic->photos[0]->title }}" class="img-fluid" style="height:100%; border-radius: 20px; width: 100%;">
                                                       <button id="prevBtn" class="btn" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%);"><i class="fa fa-angle-left"></i></button>
                                                       <button id="nextBtn" class="btn" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%);"><i class="fa fa-angle-right"></i></button>
                                                   </div>
                                                   <div class="col-lg-6 col-md-6 align-items-stretch mb-3" style=" font-size: 30px; line-height: 1.6; color: #333;">
                                                       {!! str_replace('"#','"'.Request::url().'#',$Topic->$details) !!}
                                                   </div>
                                               </div>
                                           </div>


                                       @else
                                           {{--                                one photo--}}
                                           <div class="">
                                               @if($WebmasterSection->title_status)
                                                   <div class="post-heading" >
                                                       <h1>
                                                           @if($Topic->icon !="")
                                                               <i class="fa {!! $Topic->icon !!} "></i>&nbsp;
                                                           @endif
                                                           {{ $title }}
                                                       </h1>
                                                   </div>
                                               @endif
                                                   @if($Topic->photo_file !="")
                                                       <div class="container" style="padding: 10px;">
                                                           <div class="row about-div"  style="padding: 10px;background-color: lightskyblue;border-radius: 20px">
                                                               <div class="col-lg-6 col-md-6  align-items-stretch mb-3" style=" font-size: 30px; line-height: 1.6; color: #333;">

                                                                   {!! str_replace('"#','"'.Request::url().'#',$Topic->$details) !!}
                                                               </div>
                                                               <div class="col-lg-6 col-md-6 d-flex align-items-stretch mb-3" style="padding: 10px;">
                                                                   <img src="{{ URL::to('uploads/topics/'.$Topic->photo_file) }}" loading="lazy"
                                                                        alt="{{ $title }}" title="{{ $title }}" class="img-fluid" id="slideshow" style="width:100%;border-radius: 30px"/>
                                                               </div>

                                                           </div>

                                                       </div>
                                                   @endif
                                           </div>
                                   </div>
                                       @endif
                                   </div>
                            @include("frontEnd.topic.fields",["cols"=>6,"Fields"=>@$Topic->webmasterSection->customFields->where("in_page",true)])
                            @if($Topic->$details!=""&&$Topic->photo_file==""&&$Topic->photos->isEmpty())
                            <div style="font-size: 30px; line-height: 1.6; color: #333;">

                                {!! str_replace('"#','"'.Request::url().'#',$Topic->$details) !!}
                            </div>
                            @endif

                                    @if($attach_file !="")
                                    <?php
                                    $file_ext = strrchr($Topic->attach_file, ".");
                                    $file_ext = strtolower($file_ext);
                                    ?>
                                <div class="bottom-article">
                                    <a href="{{ URL::to('uploads/topics/'.$Topic->attach_file) }}" target="_blank">
                                        <strong>
                                            {!! Helper::GetIcon(URL::to('uploads/topics/'),$Topic->attach_file) !!}
                                            &nbsp;{{ __('frontend.downloadAttach') }}</strong>
                                    </a>
                                </div>
                            @endif
                        </article>

                        @include("frontEnd.otherpages.part1")
                        @include("frontEnd.otherpages.link")
                        @include("frontEnd.otherpages.part3")
                        @include("frontEnd.otherpages.video")
                        @include("frontEnd.topic.files")

                        @include("frontEnd.topic.maps")

                        @include("frontEnd.topic.tags")
                        @if($Topic->search_==1)

                                <div class="container topic-page d-flex justify-content-center align-items-center" style="padding-top: 5%">
                                    <form id="search-form" class="text-center" action="{{ route('search', ['certificateNumber']) }}" method="post">
                                        @csrf
                                    <input
                                            type="text"
                                            id="search-input"
                                            name="certificateNumber"
                                            placeholder="{{ __('frontend.valednum') }}"
                                            required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            style="padding: 10px; font-size: 16px; width: 250px; border: 2px solid #007bff; border-radius: 25px; text-align: center;"
                                        >
{{--                                    <a href="{{ route('search', ['certificateNumber']) }}">--}}
                                    <button
                                            type="submit"
                                            style="padding: 2% 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 25px; cursor: pointer; margin-left: 10px; transition: all 0.3s ease;"
                                        >
                                            {{ __('frontend.search') }}
                                        </button>
{{--                                        </a>--}}
                                    </form>

                                </div>


                            <style>
                                body {
                                        margin: 0;
                                        padding: 0;
                                        font-family: Arial, sans-serif;
                                        background-color: #f8f9fa;
                                    }

                                    #content {
                                        display: flex;
                                        justify-content: center;
                                        align-items: center;

                                    }

                                    button:hover {
                                        background-color: #0056b3;
                                        transform: scale(1.05);
                                    }
                                </style>

                        @endif


                        @if($WebmasterSection->type == 7)
                            <a href="{!! Helper::sectionURL($Topic->webmaster_id) !!}"
                               class="btn btn-lg btn-secondary"
                               style="width: 100%"><i
                                    class="fa-solid fa-reply"></i> {{ __('backend.clickToNewSearch') }}
                            </a>
                        @else
                                            <div style="padding: 10%">
                                                @include("frontEnd.topic.share")

                                            </div>
                                        @endif

                        @include("frontEnd.topic.comments")

                        @if(@$Topic->form_id >0)
                            <br>
                            @include('frontEnd.form',["FormSectionID"=>@$Topic->form_id])
                        @elseif($WebmasterSection->order_status)
                            @include("frontEnd.topic.order")
                        @endif

                        @include("frontEnd.topic.related")

                    </div>
                </div>
            </div>

        </section>
    </div>
    @include('frontEnd.layouts.popup',['Popup'=>@$Popup])
@endsection
@if (@in_array(@$WebmasterSection->type, [2]))
    @push('before-styles')
        <link rel="stylesheet"
              href="{{ URL::asset('assets/frontend/vendor/video-js/css/video-js.min.css') }}?v={{ Helper::system_version() }}"/>
    @endpush
    @push('after-scripts')
        <script
            src="{{ URL::asset('assets/frontend/vendor/video-js/js/video-js.min.css') }}?v={{ Helper::system_version() }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                GreenAudioPlayer.init({
                    selector: '.audio-player',
                    stopOthersOnPlay: true,
                    showTooltips: true,
                });
            });
        </script>
    @endpush
@endif
@if (@in_array(@$WebmasterSection->type, [3]))
    @push('before-styles')
        <link rel="stylesheet"
              href="{{ URL::asset('assets/frontend/vendor/green-audio-player/css/green-audio-player.min.css') }}?v={{ Helper::system_version() }}"/>
    @endpush
    @push('after-scripts')
        <script
            src="{{ URL::asset('assets/frontend/vendor/green-audio-player/js/green-audio-player.min.js') }}?v={{ Helper::system_version() }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                GreenAudioPlayer.init({
                    selector: '.audio-player',
                    stopOthersOnPlay: true,
                    showTooltips: true,
                });
            });
        </script>
    @endpush
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentIndex = 0;
        const photos = @json($Topic->photos);
        const slideshow = document.getElementById('slideshow');

        function showImage(index) {
            slideshow.src = `{{ URL::to('uploads/topics/') }}/${photos[index].file}`;
            slideshow.alt = photos[index].title;
        }

        function showNextImage() {
            currentIndex = (currentIndex + 1) % photos.length;
            showImage(currentIndex);
        }

        function showPrevImage() {
            currentIndex = (currentIndex - 1 + photos.length) % photos.length;
            showImage(currentIndex);
        }

        setInterval(showNextImage, 3000); // Change image every 3 seconds

        document.getElementById('nextBtn').addEventListener('click', showNextImage);
        document.getElementById('prevBtn').addEventListener('click', showPrevImage);


    });
</script>

<style>

    .btn {

        background-color: #fff; /* White background */
        border: 2px solid #f7741c; /* Black border */
        border-radius: 50%; /* Circular shape */
        width: 50px; /* Width of the button */
        height: 50px; /* Height of the button */
        /*display: flex; !* Flexbox for centering *!*/
        align-items: center; /* Center vertically */
        justify-content: center; /* Center horizontally */
        cursor: pointer; /* Pointer cursor on hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        transition: background-color 0.3s, transform 0.3s; /* Smooth transitions */
    }

    .btn:hover {
        background-color: #f0f0f0; /* Light grey background on hover */
        transform: scale(1.1); /* Slightly enlarge on hover */
    }

    .btn i {
        font-size: 24px; /* Icon size */
        color: #000; /* Icon color */
    }



    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }


</style>
