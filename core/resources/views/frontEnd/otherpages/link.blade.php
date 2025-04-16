@if($Topic->pages_content_link != 0)
        <?php
        $contents = \App\Models\Topic::where('webmaster_id', 28)->where('id',$Topic->pages_content_link)->first();
        $section_url='';
        $lang_code = Helper::currentLanguage()->code;
        $link='link_'.$lang_code;
        if ($section_url == "") {
            $section_url = Helper::sectionURL($contents->$link);
        }
        ?>
    <style>

        button:before{
            animation: rotate 2s infinite linear;
            filter: blur(20px);
        }
        .about
        {
            text-align: center;
            /*border-style: solid;*/

            /*border-radius: 10px;*/
        }
        button {
            animation: rotate 2s infinite linear;
            background-color: #ffffff; /* Orange */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 50px; /* More rounded corners */
        }

        button:hover {
            background-color: #ff9200; /* Darker orange on hover */
        }


    </style>

    @if(!empty($contents))
        @if(@$contents->$details_var !="")
            <section class="content-row-no-bg home-welcome " style="padding: 5%;  margin-bottom:30px ; background-color: #00b3ff;height: 15%">

                <div style="text-align: center">
                    <div class="row about"  style="text-align:center;background-color: #00b3ff;align-items: center">
                        <div style="text-align:center;font-family: Roboto, sans-serif; font-size: 30px; line-height: 1.6; color: #ffffff;padding: 3px">
                            <p style="text-align: center">
                                {!! $contents->$details_var !!}
                            </p>

                        </div>
                        <div style="padding: 3px" >
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <div class="more-btn">

                                        <a href="{{$contents->$link}}"  class=" btn-theme" style="background-color: lightskyblue;cursor: grab">
                                            {{__('backend.click')}}
                                        </a>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </section>

        @endif
    @endif
@endif
