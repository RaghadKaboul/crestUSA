<div class="tab-pane {{ ( Session::get('active_tab') == 'otherPagesTab') ? 'active' : '' }}" id="tab-16" style="padding: 2%">
    <div class="p-a-md"><h5>{!! __('backend.otherPages') !!}</h5></div>

    <style>
        /* Your existing styles */
        h5 {
            color: #2d3748;
        }
    </style>

    <!-- Single Form for all pages -->


        @foreach($Pages as $page)
                <?php $rowpage = \App\Models\Topic::find($page->id); ?>
            <div class="con">
                <div class="col-md-" id="contentdiv">
                    <div>
                        <h5 class='colored'>{!! $page->$title_var !!} :</h5>
                    </div>
                    <div class="select-group">
                        <div class="form-group">
                            <label>{{ __('backend.pages_Row1') }} : </label>
                            <select name="pages[{{ $page->id }}][content1]" class="form-control select">
                                <option value="0">- - {!! __('backend.none') !!} - -</option>
                                @foreach ($Topics as $Topic)
                                        <?php $title = $Topic->$title_var ?: $Topic->$title_var2; ?>
                                    <option value="{{ $Topic->id }}" {{ ($rowpage->pages_content1 == $Topic->id) ? "selected='selected'" : "" }}>{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('backend.pages_Row2') }} : </label>
                            <select name="pages[{{ $page->id }}][content2]" class="form-control select">
                                <option value="0">- - {!! __('backend.none') !!} - -</option>
                                @foreach ($Topics as $Topic)
                                        <?php $title = $Topic->$title_var ?: $Topic->$title_var2; ?>
                                    <option value="{{ $Topic->id }}" {{ ($rowpage->pages_content2 == $Topic->id) ? "selected='selected'" : "" }}>{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('backend.pages_video') }} : </label>
                            <select name="pages[{{ $page->id }}][content_video]" class="form-control select">
                                <option value="0">- - {!! __('backend.none') !!} - -</option>
                                @foreach ($Videos as $video)
                                        <?php $title = $video->$title_var ?: $video->$title_var2; ?>
                                    <option value="{{ $video->id }}" {{ ($rowpage->pages_content_video == $video->id) ? "selected='selected'" : "" }}>{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="select-group">
                        <div class="form-group">
                            <label>{{ __('backend.pages_Row3') }} : </label>
                            <select name="pages[{{ $page->id }}][content3]" class="form-control select">
                                <option value="0">- - {!! __('backend.none') !!} - -</option>
                                @foreach ($Topics as $Topic)
                                        <?php $title = $Topic->$title_var ?: $Topic->$title_var2; ?>
                                    <option value="{{ $Topic->id }}" {{ ($rowpage->pages_content3 == $Topic->id) ? "selected='selected'" : "" }}>{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('backend.pages_Link') }} : </label>
                            <select name="pages[{{ $page->id }}][content_link]" class="form-control select">
                                <option value="0">- - {!! __('backend.none') !!} - -</option>
                                @foreach ($Links as $Link)
                                        <?php $title = $Link->$title_var ?: $Link->$title_var2; ?>
                                    <option value="{{ $Link->id }}" {{ ($rowpage->pages_content_link == $Link->id) ? "selected='selected'" : "" }}>{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

</div>
