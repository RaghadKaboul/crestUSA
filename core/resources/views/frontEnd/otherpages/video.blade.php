@if($Topic->pages_content_video != 0)
        <?php
        $contents = \App\Models\Topic::where('webmaster_id', 5)->where('id',$Topic->pages_content_video)->first();
        ?>
    <style>
        .content {
            padding: 2%;
            display: flex;
            flex-direction: row;
            background-color: #fff;
            border-color: #fff;
            border-radius: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .video-container {
            padding: 2%;
            flex: 1;
            position: relative;
            top:40%;
            right: 2%;
        }

        .video-container video {
            width: 100%;
            height: 70%;

        }

        .text-container {
            flex: 1;

            word-wrap: break-word;
            overflow-y: auto;
        }


        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }

            .video-container {
                order: 1;
            }

            .text-container {
                margin-top: 20px;
                text-align: left;
            }
        }

    </style>

    <section  class="content-row-no-bg home-welcome section-bg" style=" padding: 2%;  margin-bottom: 10px;width: 100% ">
        <div class="section-title">
            <h2>{{__('frontend.app')}}</h2>
            <p> {{__('frontend.appDes')}}</p>
        </div>
        <div class="content" >

            <div class="video-container"  >
                <video controls>
                    <source src="{{ url('uploads/topics/'. $contents['video_file']) }}"   type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>

            <div class="text-container" style=" text-align: center;padding: 10px ">
                <div style="padding: 10px">
                                                                <h3>{!!  $contents->$title_var !!}</h3>
                </div>
                                                      <p style="letter-spacing: 150px">  {!! $contents->$details_var !!} </p>
            </div>
        </div>

    </section>

@endif
