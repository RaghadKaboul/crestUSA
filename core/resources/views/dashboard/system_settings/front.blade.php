<div
    class="tab-pane {{ ( Session::get('active_tab') == 'frontSettingsTab' || Session::get('active_tab') =="") ? 'active' : '' }}"
    id="tab-5">
    <div class="p-a-md"><h5>{!!  __('backend.frontSettings') !!}</h5></div>
    <div class="p-a-md col-md-12">
        <div class="col-md-6">

            <div class="form-group">
                <label>{{ __('backend.headerMenu') }} : </label>
                <select name="header_menu_id" id="header_menu_id" class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    <?php
                    $title_var = "title_" . @Helper::currentLanguage()->code;
                    $title_var2 = "title_" . config('smartend.default_language');

                    ?>
                    @foreach ($ParentMenus as $ParentMenu)

                            <?php
                            if ($ParentMenu->$title_var != "") {
                                $title = $ParentMenu->$title_var;
                            } else {
                                $title = $ParentMenu->$title_var2;
                            }
                            ?>
                        <option
                            value="{{ $ParentMenu->id  }}" {{ ($ParentMenu->id == $WebmasterSetting->header_menu_id) ? "selected='selected'":""  }}>{{ $title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>{{ __('backend.footerMenu') }} : </label>
                <select name="footer_menu_id" id="footer_menu_id" class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    <?php
                    $title_var = "title_" . @Helper::currentLanguage()->code;
                    $title_var2 = "title_" . config('smartend.default_language');
                    ?>
                    @foreach ($ParentMenus as $ParentMenu)
                            <?php
                            if ($ParentMenu->$title_var != "") {
                                $title = $ParentMenu->$title_var;
                            } else {
                                $title = $ParentMenu->$title_var2;
                            }
                            ?>
                        <option
                            value="{{ $ParentMenu->id  }}" {{ ($ParentMenu->id == $WebmasterSetting->footer_menu_id) ? "selected='selected'":""  }}>{{ $title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>{{ __('backend.homeSlideBanners') }} : </label>
                <select name="home_banners_section_id" id="home_banners_section_id"
                        class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    @foreach ($WebmasterBanners as $WebmasterBanner)
                            <?php
                            if ($WebmasterBanner->$title_var != "") {
                                $WBTitle = $WebmasterBanner->$title_var;
                            } else {
                                $WBTitle = $WebmasterBanner->$title_var2;
                            }
                            ?>
                        <option
                            value="{{ $WebmasterBanner->id  }}" {{ ($WebmasterBanner->id == $WebmasterSetting->home_banners_section_id) ? "selected='selected'":""  }}>{!! $WBTitle !!}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label>{{ __('backend.homeTextBanners') }} : </label>
                <select name="home_text_banners_section_id" id="home_text_banners_section_id"
                        class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    @foreach ($WebmasterBanners as $WebmasterBanner)
                            <?php
                            if ($WebmasterBanner->$title_var != "") {
                                $WBTitle = $WebmasterBanner->$title_var;
                            } else {
                                $WBTitle = $WebmasterBanner->$title_var2;
                            }
                            ?>
                        <option
                            value="{{ $WebmasterBanner->id  }}" {{ ($WebmasterBanner->id == $WebmasterSetting->home_text_banners_section_id) ? "selected='selected'":""  }}>{!! $WBTitle  !!}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>{{ __('backend.sideBanners') }} : </label>
                <select name="side_banners_section_id" id="side_banners_section_id"
                        class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    @foreach ($WebmasterBanners as $WebmasterBanner)
                            <?php
                            if ($WebmasterBanner->$title_var != "") {
                                $WBTitle = $WebmasterBanner->$title_var;
                            } else {
                                $WBTitle = $WebmasterBanner->$title_var2;
                            }
                            ?>
                        <option
                            value="{{ $WebmasterBanner->id  }}" {{ ($WebmasterBanner->id == $WebmasterSetting->side_banners_section_id) ? "selected='selected'":""  }}>{!! $WBTitle !!}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>{{ __('backend.newsletterGroup') }} : </label>
                <select name="newsletter_contacts_group" id="newsletter_contacts_group"
                        class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    @foreach ($ContactsGroups as $ContactsGroup)
                            <?php
                            ?>
                        <option
                            value="{{ $ContactsGroup->id  }}" {{ ($ContactsGroup->id == $WebmasterSetting->newsletter_contacts_group) ? "selected='selected'":""  }}>{!! $ContactsGroup->name   !!}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>{{ __('backend.topicsPerPage') }} : </label>
                {!! Form::number('home_contents_per_page',$WebmasterSetting->home_contents_per_page, array('id' => 'home_contents_per_page','class' => 'form-control')) !!}
            </div>

            <div class="form-group">
                <label>{{ __('backend.topicsOrderInFront') }} : </label>
                <select name="front_topics_order" id="front_topics_order"
                        class="form-control c-select">
                    <option
                        value="asc" {{ (config('smartend.frontend_topics_order') == "asc") ? "selected='selected'":""  }}>{!!  __('backend.topicsOrderInFrontAsc') !!}</option>
                    <option
                        value="desc" {{ (config('smartend.frontend_topics_order') == "desc") ? "selected='selected'":""  }}>{!!  __('backend.topicsOrderInFrontDesc') !!}</option>
                </select>
            </div>

            <div class="form-group">
                <label>{{ __('backend.commentsStatus') }} : </label>
                <div class="radio">
                    <div>
                        <label class="ui-check ui-check-md">
                            {!! Form::radio('new_comments_status','1',$WebmasterSetting->new_comments_status ? true : false , array('id' => 'new_comments_status1','class'=>'has-value')) !!}
                            <i class="dark-white"></i>
                            {{ __('backend.automaticPublish') }}
                        </label>
                    </div>
                    <div style="margin-top: 5px;">
                        <label class="ui-check ui-check-md">
                            {!! Form::radio('new_comments_status','0',$WebmasterSetting->new_comments_status ? false : true , array('id' => 'new_comments_status2','class'=>'has-value')) !!}
                            <i class="dark-white"></i>
                            {{ __('backend.manualByAdmin') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('backend.cookieAcceptMessage') }} : </label>
                <div class="radio">
                    <div>
                        <label class="ui-check ui-check-md">
                            {!! Form::radio('cookie_policy_status','1',$WebmasterSetting->cookie_policy_status ? true : false , array('id' => 'cookie_policy_status1','class'=>'has-value')) !!}
                            <i class="dark-white"></i>
                            {{ __('backend.active') }}
                        </label>
                    </div>
                    <div style="margin-top: 5px;">
                        <label class="ui-check ui-check-md">
                            {!! Form::radio('cookie_policy_status','0',$WebmasterSetting->cookie_policy_status ? false : true , array('id' => 'cookie_policy_status2','class'=>'has-value')) !!}
                            <i class="dark-white"></i>
                            {{ __('backend.notActive') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="form-group">
                <label>{{ __('backend.homeRow1') }} : </label>
                <select name="home_content4_section_id"
                        class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    @foreach ($SitePages as $SitePage)
                            <?php
                            if ($SitePage->$title_var != "") {
                                $title = $SitePage->$title_var;
                            } else {
                                $title = $SitePage->$title_var2;
                            }
                            ?>
                        <option
                            value="{{ $SitePage->id  }}" {{ ($SitePage->id == $WebmasterSetting->home_content4_section_id) ? "selected='selected'":""  }}>{{ $title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>{{ __('backend.homeRow2') }} : </label>
                <select name="home_content1_section_id" id="home_content1_section_id"
                        class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    @foreach ($GeneralWebmasterSections as $Webmaster_Section)
                        @if($Webmaster_Section->type !=4)
                                <?php
                                if ($Webmaster_Section->$title_var != "") {
                                    $WSectionTitle = $Webmaster_Section->$title_var;
                                } else {
                                    $WSectionTitle = $Webmaster_Section->$title_var2;
                                }
                                ?>

                            <option
                                value="{{ $Webmaster_Section->id  }}" {{ ($Webmaster_Section->id == $WebmasterSetting->home_content1_section_id) ? "selected='selected'":""  }}>{!! $WSectionTitle !!}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>{{ __('backend.video') }} : </label>
                <select name="home_video_section_id" id="home_video_section_id"
                        class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    @foreach ($Videos as $video)
                            <?php
                            if ($video->$title_var != "") {
                                $title = $video->$title_var;
                            } else {
                                $title = $video->$title_var2;
                            }
                            ?>
                        <option
                            value="{{ $video->id  }}" {{ ($video->id == $WebmasterSetting->home_video_section_id) ? "selected='selected'":""  }}>{{ $title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>{{ __('backend.homeRow_3') }} : </label>
                <select name="home_content5_section_id" id="home_content5_section_id"
                        class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    @foreach ($GeneralWebmasterSections as $Webmaster_Section)
                        @if($Webmaster_Section->type !=4)
                                <?php
                                if ($Webmaster_Section->$title_var != "") {
                                    $WSectionTitle = $Webmaster_Section->$title_var;
                                } else {
                                    $WSectionTitle = $Webmaster_Section->$title_var2;
                                }
                                ?>
                            <option
                                value="{{ $Webmaster_Section->id  }}" {{ ($Webmaster_Section->id == $WebmasterSetting->home_content5_section_id) ? "selected='selected'":""  }}>{!! $WSectionTitle !!}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>{{ __('backend.homeRow_4') }} : </label>
                <select name="home_content8_section_id" id="home_content8_section_id"
                        class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    @foreach ($Newses as $News)
                            <?php
                            if ($News->$title_var != "") {
                                $title = $News->$title_var;
                            } else {
                                $title = $News->$title_var2;
                            }
                            ?>
                        <option
                            value="{{ $News->id  }}" {{ ($News->id == $WebmasterSetting->home_content8_section_id) ? "selected='selected'":""  }}>{{ $title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>{{ __('backend.homeLink') }} : </label>
                <select name="home_link_section_id" id="home_link_section_id"
                        class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    @foreach ($Links as $Link)
                            <?php
                            if ($Link->$title_var != "") {
                                $title = $Link->$title_var;
                            } else {
                                $title = $Link->$title_var2;
                            }
                            ?>
                        <option
                            value="{{ $Link->id  }}" {{ ($Link->id == $WebmasterSetting->home_link_section_id) ? "selected='selected'":""  }}>{{ $title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>{{ __('backend.homeRow_5') }} : </label>
                <select name="home_content7_section_id" id="home_content7_section_id"
                        class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    @foreach ($GeneralWebmasterSections as $Webmaster_Section)
                        @if($Webmaster_Section->type !=4)
                                <?php
                                if ($Webmaster_Section->$title_var != "") {
                                    $WSectionTitle = $Webmaster_Section->$title_var;
                                } else {
                                    $WSectionTitle = $Webmaster_Section->$title_var2;
                                }
                                ?>
                            <option
                                value="{{ $Webmaster_Section->id  }}" {{ ($Webmaster_Section->id == $WebmasterSetting->home_content7_section_id) ? "selected='selected'":""  }}>{!! $WSectionTitle !!}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>{{ __('backend.homeRow_6') }} : </label>
                <select name="home_content6_section_id" id="home_content6_section_id"
                        class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    @foreach ($GeneralWebmasterSections as $Webmaster_Section)
                        @if($Webmaster_Section->type !=4)
                                <?php
                                if ($Webmaster_Section->$title_var != "") {
                                    $WSectionTitle = $Webmaster_Section->$title_var;
                                } else {
                                    $WSectionTitle = $Webmaster_Section->$title_var2;
                                }
                                ?>
                            <option
                                value="{{ $Webmaster_Section->id  }}" {{ ($Webmaster_Section->id == $WebmasterSetting->home_content6_section_id) ? "selected='selected'":""  }}>{!! $WSectionTitle !!}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>{{ __('backend.homeRow_7') }} : </label>
                <select name="home_content3_section_id" id="home_content3_section_id"
                        class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    @foreach ($GeneralWebmasterSections as $Webmaster_Section)
                        @if($Webmaster_Section->type !=4)
                                <?php
                                if ($Webmaster_Section->$title_var != "") {
                                    $WSectionTitle = $Webmaster_Section->$title_var;
                                } else {
                                    $WSectionTitle = $Webmaster_Section->$title_var2;
                                }
                                ?>
                            <option
                                value="{{ $Webmaster_Section->id  }}" {{ ($Webmaster_Section->id == $WebmasterSetting->home_content3_section_id) ? "selected='selected'":""  }}>{!! $WSectionTitle !!}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>{{ __('backend.contactPageId') }} : </label>
                <select name="contact_page_id" id="contact_page_id" class="form-control c-select">
                    <option value="0">- - {!!  __('backend.none') !!} - -</option>
                    <?php
                    $title_var = "title_" . @Helper::currentLanguage()->code;
                    $title_var2 = "title_" . config('smartend.default_language');
                    ?>
                    @foreach ($SitePages as $SitePage)
                            <?php
                            if ($SitePage->$title_var != "") {
                                $title = $SitePage->$title_var;
                            } else {
                                $title = $SitePage->$title_var2;
                            }
                            ?>
                        <option
                            value="{{ $SitePage->id  }}" {{ ($SitePage->id == $WebmasterSetting->contact_page_id) ? "selected='selected'":""  }}>{{ $title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>{{ __('backend.dashboardLink') }} : </label>
                <div class="radio">
                    <div>
                        <label class="ui-check ui-check-md">
                            {!! Form::radio('dashboard_link_status','1',$WebmasterSetting->dashboard_link_status ? true : false , array('id' => 'dashboard_link_status1','class'=>'has-value')) !!}
                            <i class="dark-white"></i>
                            {{ __('backend.active') }}
                        </label>
                    </div>
                    <div style="margin-top: 5px;">
                        <label class="ui-check ui-check-md">
                            {!! Form::radio('dashboard_link_status','0',$WebmasterSetting->dashboard_link_status ? false : true , array('id' => 'dashboard_link_status2','class'=>'has-value')) !!}
                            <i class="dark-white"></i>
                            {{ __('backend.notActive') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('backend.headerSearch') }} : </label>
                <div class="radio">
                    <div>
                        <label class="ui-check ui-check-md">
                            {!! Form::radio('header_search_status','1',$WebmasterSetting->header_search_status ? true : false , array('id' => 'header_search_status1','class'=>'has-value')) !!}
                            <i class="dark-white"></i>
                            {{ __('backend.active') }}
                        </label>
                    </div>
                    <div style="margin-top: 5px;">
                        <label class="ui-check ui-check-md">
                            {!! Form::radio('header_search_status','0',$WebmasterSetting->header_search_status ? false : true , array('id' => 'header_search_status2','class'=>'has-value')) !!}
                            <i class="dark-white"></i>
                            {{ __('backend.notActive') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
