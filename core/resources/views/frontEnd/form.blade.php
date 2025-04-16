@if(Session::has('doneMessage'))
    <div class="padding p-b-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! Session::get('doneMessage') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif
@if(Session::has('errorMessage'))
    <div class="padding p-b-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! Session::get('errorMessage') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif
@if(!empty(@$errors))
    @if(@$errors->any())
        <div class="padding p-b-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <ul class="m-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
@if(@$FormSectionID >0)
    <?php
    // Get banners list array by settings ID (You can get settings ID from Webmaster >> Banners settings)
    $WebmasterSection = Helper::WebmasterSection($FormSectionID);
    $fatherSections = Helper::SectionCategories($FormSectionID);
    $PhoneFieldsIds = [];
    ?>
    @if(!empty($WebmasterSection))
        <div class="form-block" >
            <h4 class="pt-3 text-muted form-title" style="text-align: center;padding: 10px" >
                {{ __('backend.submit') }} {!!  $WebmasterSection->{"title_".@Helper::currentLanguage()->code} !!}
            </h4>
            <div class="bottom-article" style="background-color: #6597b0;margin: 40px;padding: 3%">
                {{Form::open(['route'=>['formSubmit'],'method'=>'POST', 'files' => true ])}}
                <div class="form-group row">
                    @if($WebmasterSection->date_status)
                        <div class="col-lg-4 col-md-12" >
                            <label for="form_date" class="form-control-label">{!!  __('backend.topicDate') !!}</label>
                            <div class="form-group">
                                <div class='input-group date'>
                                    {!! Form::text('date',Helper::formatDate(date("Y-m-d")), array('placeholder' => '','autocomplete' => 'off','class' => 'form-control','id'=>'form_date','required'=>'')) !!}
                                    <span class="input-group-addon">
                  <span class="fa fa-calendar"></span>
              </span>
                                </div>
                            </div>

                        </div>
                    @else
                        {!! Form::hidden('date',date("Y-m-d"), array('placeholder' => '','class' => 'form-control form_date','id'=>'form_date')) !!}
                    @endif

                    @if($WebmasterSection->expire_date_status)
                        <div class="col-lg-4 col-md-12" >
                            <label for="form_expire_date" class="form-control-label">{!!  __('backend.expireDate') !!}
                            </label>
                            {!! Form::text('expire_date','', array('placeholder' => '','autocomplete' => 'off','class' => 'form-control form_date','id'=>'form_expire_date')) !!}
                        </div>
                    @endif

                    @if($WebmasterSection->sections_status!=0)
                        <div class="col-lg-4 col-md-12">
                            <label for="section_id"
                                   class="form-control-label">{!!  __('backend.categories') !!} </label>
                            <select name="section_id" id="section_id" class="form-control c-select" required>
                                <option value=""> - - {!!  __('backend.select') !!} - -</option>
                                <?php
                                $title_var = "title_" . @Helper::currentLanguage()->code;
                                $title_var2 = "title_" . config('smartend.default_language');
                                $t_arrow = "&raquo;";
                                ?>
                                @foreach ($fatherSections as $fatherSection)
                                    <?php
                                    if ($fatherSection->$title_var != "") {
                                        $ftitle = $fatherSection->$title_var;
                                    } else {
                                        $ftitle = $fatherSection->$title_var2;
                                    }
                                    ?>
                                    <option value="{{ $fatherSection->id  }}">{!! $ftitle !!}</option>
                                    @foreach ($fatherSection->fatherSections as $subFatherSection)
                                        <?php
                                        if ($subFatherSection->$title_var != "") {
                                            $title = $subFatherSection->$title_var;
                                        } else {
                                            $title = $subFatherSection->$title_var2;
                                        }
                                        ?>
                                        <option
                                                value="{{ $subFatherSection->id  }}">{!! $ftitle !!} {!! $t_arrow !!} {!! $title !!}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    @else
                        {!! Form::hidden('section_id','0') !!}
                    @endif

                    @if($WebmasterSection->title_status)
                        <div class="col-lg-4 col-md-12">
                            <label for="form_title"
                                   class="form-control-label">{!!  __('backend.topicName') !!}
                            </label>
                            {!! Form::text('title','', array('placeholder' => '','autocomplete' => 'off','id' => 'form_title','class' => 'form-control','required'=>'')) !!}
                        </div>
                    @endif

                    @if($WebmasterSection->longtext_status)
                        <div class="col-sm-12">
                            <label class="form-control-label" for="form_details">{!!  __('backend.bannerDetails') !!}
                            </label>
                            {!! Form::textarea('details','', array('placeholder' => '','autocomplete' => 'off','id'=>'form_details','class' => 'form-control','rows'=>'8')) !!}
                        </div>
                    @endif

                    @if($WebmasterSection->photo_status)
                        <div class="col-lg-4 col-md-12" >
                            <label for="form_photo_file"
                                   class="form-control-label">{!!  __('backend.topicPhoto') !!}</label>
                            {!! Form::file('photo_file', array('class' => 'form-control','autocomplete' => 'off','id' => 'form_photo_file','accept'=>'image/*')) !!}
                            <small>
                                {!!  __('backend.imagesTypes') !!}
                            </small>
                        </div>
                    @endif

                    @if($WebmasterSection->attach_file_status)
                        <div class="col-lg-4 col-md-12">
                            <label for="form_attach_file"
                                   class="form-control-label">{!!  __('backend.topicAttach') !!}</label>
                            {!! Form::file('attach_file', array('class' => 'form-control','autocomplete' => 'off','id'=>'form_attach_file')) !!}
                            <small>
                                {!!  __('backend.attachTypes') !!}
                            </small>
                        </div>
                    @endif

                    {{--Additional Feilds--}}
                    @if(count($WebmasterSection->customFields) >0)
                        <?php
                        $cf_title_var = "title_" . @Helper::currentLanguage()->code;
                        $cf_title_var2 = "title_" . config('smartend.default_language');
                        ?>
                        @foreach($WebmasterSection->customFields as $customField)
                            <?php
                            // check permission
                            $add_permission_groups = [];
                            if ($customField->add_permission_groups != "") {
                                $add_permission_groups = explode(",", $customField->add_permission_groups);
                            }
                            // have permission & continue
                            if ($customField->$cf_title_var != "") {
                                $cf_title = $customField->$cf_title_var;
                            } else {
                                $cf_title = $customField->$cf_title_var2;
                            }

                            // check field language status
                            $cf_lang_identifier = "";
                            $cf_land_active = false;
                            $cf_land_dir = @Helper::currentLanguage()->direction;
                            if ($customField->lang_code != "all") {
                                $ct_language = @Helper::LangFromCode($customField->lang_code);
                                $cf_lang_identifier = @Helper::languageName($ct_language);
                                $cf_land_dir = $ct_language->direction;
                                if ($ct_language->box_status) {
                                    $cf_land_active = true;
                                }
                            }
                            if ($customField->lang_code == "all") {
                                $cf_land_active = true;
                            }

                            if (@count($add_permission_groups) > 0) {
                                if (!in_array(0, $add_permission_groups)) {
                                    $cf_land_active = false;
                                }
                            }

                            // required Status
                            $cf_required = '';
                            $cf_required_star = '';
                            if ($customField->required) {
                                $cf_required = 'required';
                                $cf_required_star = '<span class="text-danger">*</span>';
                            }
                            if (@old('customField_' . $customField->id) != "") {
                                $customField->default_value = @old('customField_' . $customField->id);
                            }

                            ?>

                            @if($cf_land_active)
                                @if($customField->type ==99)



                                @elseif($customField->type ==13)
                                    {{--Radio--}}
                                    <div class="col-lg-4 col-md-12">
                                        <label for="{{'customField_'.$customField->id}}"
                                               class="form-control-label">{!!  $cf_title !!} {!! $cf_required_star !!}
                                            {!! $cf_lang_identifier !!}</label>
                                        <?php
                                        $cf_details_var = "details_" . @Helper::currentLanguage()->code;
                                        $cf_details_var2 = "details_" . config('smartend.default_language');
                                        if ($customField->$cf_details_var != "") {
                                            $cf_details = $customField->$cf_details_var;
                                        } else {
                                            $cf_details = $customField->$cf_details_var2;
                                        }
                                        $cf_details_lines = preg_split('/\r\n|[\r\n]/', $cf_details);
                                        $line_num = 1;
                                        ?>
                                        <div class="mb-3">
                                            @foreach ($cf_details_lines as $cf_details_line)
                                                <div class="m-t-sm">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                               value="{{ $line_num }}"
                                                               name="{{'customField_'.$customField->id}}"
                                                               {{$cf_required}}
                                                               id="{{'customField_'.$customField->id}}_{{$line_num}}" {{ ($customField->default_value == $line_num) ? "checked":""  }}>
                                                        <label class="form-check-label"
                                                               for="{{'customField_'.$customField->id}}_{{$line_num}}">
                                                            {{ $cf_details_line }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                                $line_num++;
                                                ?>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif($customField->type ==14)
                                    {{--Checkbox--}}
                                    <div class="col-sm-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                   name="{{'customField_'.$customField->id}}"
                                                   id="{{'customField_'.$customField->id}}" {{$cf_required}} value="1">
                                            <label class="form-check-label"
                                                   for="{{'customField_'.$customField->id}}">{!!  $cf_title !!}
                                                {!! $cf_lang_identifier !!}</label>
                                        </div>
                                    </div>
                                @elseif($customField->type ==12)
                                    {{--Vimeo Video Link--}}
                                    <div class="col-lg-4 col-md-12">
                                        <label for="{{'customField_'.$customField->id}}"
                                               class="form-control-label">{!!  $cf_title !!} {!! $cf_required_star !!}
                                            {!! $cf_lang_identifier !!} <i class="fa fa-vimeo"></i>
                                        </label>
                                        {!! Form::text('customField_'.$customField->id,$customField->default_value, array('placeholder' => '','autocomplete' => 'off','class' => 'form-control','id'=>'customField_'.$customField->id,$cf_required=>'', 'dir'=>'ltr')) !!}
                                    </div>
                                @elseif($customField->type ==11)
                                    {{--Youtube Video Link--}}
                                    <div class="col-lg-4 col-md-12">
                                        <label for="{{'customField_'.$customField->id}}"
                                               class="form-control-label">{!!  $cf_title !!} {!! $cf_required_star !!}
                                            {!! $cf_lang_identifier !!} <i class="fa fa-youtube"></i>
                                        </label>
                                        {!! Form::text('customField_'.$customField->id,$customField->default_value, array('placeholder' => '','autocomplete' => 'off','class' => 'form-control','id'=>'customField_'.$customField->id,$cf_required=>'', 'dir'=>'ltr')) !!}
                                    </div>
                                @elseif($customField->type ==10)
                                    {{--Video File--}}
                                    <div class="col-lg-4 col-md-12">
                                        <label for="{{'customField_'.$customField->id}}"
                                               class="form-control-label">{!!  $cf_title !!} {!! $cf_required_star !!}
                                            {!! $cf_lang_identifier !!}</label>
                                        {!! Form::file('customField_'.$customField->id, array('class' => 'form-control','autocomplete' => 'off','id'=>'customField_'.$customField->id,$cf_required=>'','accept'=>'*')) !!}
                                    </div>
                                @elseif($customField->type ==9)
                                    {{--Attach File--}}
                                    <div class="col-lg-4 col-md-12">
                                        <label for="{{'customField_'.$customField->id}}"
                                               class="form-control-label">{!!  $cf_title !!} {!! $cf_required_star !!}
                                            {!! $cf_lang_identifier !!}</label>
                                        {!! Form::file('customField_'.$customField->id, array('class' => 'form-control','autocomplete' => 'off','id'=>'customField_'.$customField->id,$cf_required=>'','accept'=>'*')) !!}
                                    </div>
                                @elseif($customField->type ==8)
                                    {{--Photo File--}}
                                    <div class="col-lg-4 col-md-12">
                                        <label for="{{'customField_'.$customField->id}}"
                                               class="form-control-label">{!!  $cf_title !!} {!! $cf_required_star !!}
                                            {!! $cf_lang_identifier !!}</label>
                                        {!! Form::file('customField_'.$customField->id, array('class' => 'form-control','autocomplete' => 'off','id'=>'customField_'.$customField->id,$cf_required=>'','accept'=>'image/*')) !!}
                                    </div>
                                @elseif($customField->type ==7)
                                    {{--Multi Check--}}
                                    <div class="col-lg-4 col-md-12">
                                        <label for="{{'customField_'.$customField->id}}"
                                               class="form-control-label">{!!  $cf_title !!} {!! $cf_required_star !!}
                                            {!! $cf_lang_identifier !!}</label>
                                        <select name="{{'customField_'.$customField->id}}[]"
                                                id="{{'customField_'.$customField->id}}"
                                                class="form-control select2-multiple" multiple {{$cf_required}}>
                                            <?php
                                            $cf_details_var = "details_" . @Helper::currentLanguage()->code;
                                            $cf_details_var2 = "details_" . config('smartend.default_language');
                                            if ($customField->$cf_details_var != "") {
                                                $cf_details = $customField->$cf_details_var;
                                            } else {
                                                $cf_details = $customField->$cf_details_var2;
                                            }
                                            $cf_details_lines = preg_split('/\r\n|[\r\n]/', $cf_details);
                                            $line_num = 1;
                                            ?>
                                            @foreach ($cf_details_lines as $cf_details_line)
                                                <option
                                                        value="{{ $line_num  }}" {{ ($customField->default_value == $line_num) ? "selected='selected'":""  }}>{{ $cf_details_line }}</option>
                                                <?php
                                                $line_num++;
                                                ?>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif($customField->type ==6)
                                    {{--Select--}}
                                    <div class="col-lg-4 col-md-12">
                                        <label for="{{'customField_'.$customField->id}}"
                                               class="form-control-label">{!!  $cf_title !!} {!! $cf_required_star !!}
                                            {!! $cf_lang_identifier !!}</label>
                                        <select name="{{'customField_'.$customField->id}}"
                                                id="{{'customField_'.$customField->id}}"
                                                class="form-control select2" {{$cf_required}}>
                                            <option value="">- - {!!  $cf_title !!} - -</option>
                                            <?php
                                            $cf_details_var = "details_" . @Helper::currentLanguage()->code;
                                            $cf_details_var2 = "details_" . config('smartend.default_language');
                                            if ($customField->$cf_details_var != "") {
                                                $cf_details = $customField->$cf_details_var;
                                            } else {
                                                $cf_details = $customField->$cf_details_var2;
                                            }
                                            $cf_details_lines = preg_split('/\r\n|[\r\n]/', $cf_details);
                                            $line_num = 1;
                                            ?>
                                            @foreach ($cf_details_lines as $cf_details_line)
                                                <option
                                                        value="{{ $line_num  }}" {{ ($customField->default_value == $line_num) ? "selected='selected'":""  }}>{{ $cf_details_line }}</option>
                                                <?php
                                                $line_num++;
                                                ?>
                                            @endforeach
                                        </select>
                                    </div>
                                    @elseif($customField->type == 16)
                                            <?php
                                            $country = \App\Models\Country::all(); ?>
                                        <div class="col-lg-4 col-md-12">
                                            <label for="{{ 'customField_' . $customField->id }}" class="form-control-label">
                                                {!! $cf_title !!} {!! $cf_required_star !!} {!! $cf_lang_identifier !!}
                                            </label>
                                            <select name="{{ 'customField_' . $customField->id }}" id="{{ 'customField_' . $customField->id }}" class="form-control select2" {{ $cf_required }} onchange="validateCountrySelection(this)">
                                                <option value="">none</option>
                                                @foreach($country as $c)
                                                    <option value="{{ $c->id }}" data-phone="{{ $c->phone_length }}"  country-code="{{ $c->tel }}">
                                                        {{ $c->$title_var }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    @elseif($customField->type == 15)
                                            <?php $PhoneFieldsIds[] = $customField->id; ?>
                                        <div class="col-lg-4 col-md-12" id="phone-number-div" style="display: none;">
                                            <label for="{{ 'customField_' . $customField->id }}" class="form-control-label">
                                                {!! $cf_title !!} {!! $cf_required_star !!} {!! $cf_lang_identifier !!}
                                            </label>
                                            {{-- Add code country --}}
                                            <label>+
                                                <span id="countryCodeDisplay"></span>
                                            </label>
                                            <input type="hidden" name="country_code" id="countryCode" value="">
                                            {!! Form::text('customField_' . $customField->id, $customField->default_value, array(
                                                'placeholder' => '',
                                                'autocomplete' => 'off',
                                                'class' => 'form-control',
                                                'id' => 'customField_' . $customField->id,
                                                $cf_required => '',
                                                'dir' => 'ltr',
                                                'oninput' => 'isNumberKey(this); validatePhoneInput(this); updateCountryCode();'
                                            )) !!}
                                            <small hidden>Minimum length: <span id="minLengthDisplay"></span>, Maximum length: <span id="maxLengthDisplay"></span></small>
                                        </div>

                                        <script>
                                            function updateCountryCode() {
                                                var countryCode = document.getElementById('countryCodeDisplay').innerText;
                                                document.getElementById('countryCode').value = countryCode;
                                            }

                                            document.addEventListener('DOMContentLoaded', function() {
                                                updateCountryCode();
                                            });

                                            function isNumberKey(input) {
                                                input.value = input.value.replace(/[^0-9]/g, '');
                                                validatePhoneInput(input); // Validate every time the input changes
                                            }

                                            function validateCountrySelection(selectElement) {
                                                var phoneDiv = document.getElementById('phone-number-div');
                                                var countryCodeDisplay = document.getElementById('countryCodeDisplay');
                                                var maxLengthDisplay = document.getElementById('maxLengthDisplay');
                                                var minLengthDisplay = document.getElementById('minLengthDisplay');
                                                var phoneInput = document.getElementById('customField_' + {{ $customField->id }});

                                                if (selectElement.value) {
                                                    // Show the phone input field
                                                    phoneDiv.style.display = 'block';

                                                    // Get the country code and max/min length
                                                    var selectedOption = selectElement.options[selectElement.selectedIndex];
                                                    var countryCode = selectedOption.getAttribute('country-code');
                                                    var maxLength = selectedOption.getAttribute('data-phone');
                                                    var minLength = selectedOption.getAttribute('data-phone-min');

                                                    // Update the UI elements
                                                    countryCodeDisplay.textContent = countryCode + " ";
                                                    phoneInput.maxLength = maxLength;
                                                    phoneInput.minLength = minLength; // Set the minimum length
                                                    maxLengthDisplay.textContent = maxLength;
                                                    minLengthDisplay.textContent = minLength;

                                                    // Validate the phone input immediately after a country is selected
                                                    validatePhoneInput(phoneInput);
                                                } else {
                                                    // Hide the input field when no country is selected
                                                    phoneDiv.style.display = 'none';
                                                    phoneInput.value = '';
                                                    countryCodeDisplay.textContent = '';
                                                    maxLengthDisplay.textContent = '';
                                                    minLengthDisplay.textContent = '';
                                                }
                                            }
                                            function validatePhoneInput(input) {
                                                var phoneDiv = document.getElementById('phone-number-div');
                                                var minLength = parseInt(phoneDiv.querySelector('#minLengthDisplay').textContent, 10);
                                                var currentLength = input.value.length;

                                                // Change border color if less than required length
                                                if (currentLength < minLength) {
                                                    input.style.borderColor = 'red';
                                                } else {
                                                    input.style.borderColor = ''; // Reset to default if condition is met
                                                }
                                            }
                                        </script>

                                        <script>
                                            function isNumberKey(input) {
                                                input.value = input.value.replace(/[^0-9]/g, '');
                                                validatePhoneInput(input); // Validate every time the input changes
                                            }

                                            function validateCountrySelection(selectElement) {
                                                var phoneDiv = document.getElementById('phone-number-div');
                                                var countryCodeDisplay = document.getElementById('countryCodeDisplay');
                                                var maxLengthDisplay = document.getElementById('maxLengthDisplay');
                                                var minLengthDisplay = document.getElementById('minLengthDisplay');
                                                var phoneInput = document.getElementById('customField_' + {{ $customField->id }});

                                                if (selectElement.value) {
                                                    // Show the phone input field
                                                    phoneDiv.style.display = 'block';

                                                    // Get the country code and max/min length
                                                    var selectedOption = selectElement.options[selectElement.selectedIndex];
                                                    var countryCode = selectedOption.getAttribute('country-code');
                                                    var maxLength = selectedOption.getAttribute('data-phone');
                                                    var minLength = selectedOption.getAttribute('data-phone');

                                                    // Update the UI elements
                                                    countryCodeDisplay.textContent = countryCode + " ";
                                                    phoneInput.maxLength = maxLength;
                                                    phoneInput.minLength = minLength; // Set the minimum length
                                                    maxLengthDisplay.textContent = maxLength;
                                                    minLengthDisplay.textContent = minLength;

                                                    // Validate the phone input immediately after a country is selected
                                                    validatePhoneInput(phoneInput);
                                                } else {
                                                    // Hide the input field when no country is selected
                                                    phoneDiv.style.display = 'none';
                                                    phoneInput.value = '';
                                                    countryCodeDisplay.textContent = '';
                                                    maxLengthDisplay.textContent = '';
                                                    minLengthDisplay.textContent = '';
                                                }
                                            }
                                            function validatePhoneInput(input) {
                                                var phoneDiv = document.getElementById('phone-number-div');
                                                var minLength = phoneDiv.querySelector('#minLengthDisplay').textContent;
                                                var minLengthNum = parseInt(minLength, 10);
                                                var currentLength = input.value.length;

                                                // Change border color if less than required length
                                                if (currentLength < minLengthNum) {
                                                    input.style.borderColor = 'red';
                                                } else {
                                                    input.style.borderColor = ''; // Reset to default if condition is met
                                                }
                                            }

                                        </script>



                                @elseif($customField->type ==5)
                                    {{--Date & Time--}}
                                    <div class="col-lg-4 col-md-12">
                                        <label for="{{'customField_'.$customField->id}}"
                                               class="form-control-label">{!!  $cf_title !!} {!! $cf_required_star !!}
                                            {!! $cf_lang_identifier !!}
                                        </label>
                                        {!! Form::text('customField_' . $customField->id, $customField->default_value, array('placeholder' => '', 'autocomplete' => 'off', 'class' => 'form-control', 'id' => 'customField_' . $customField->id, $cf_required => '', 'dir' => 'ltr',  'onkeypress' => 'return isNumberKey(event)')) !!}
                                    </div>
                                @elseif($customField->type ==4)
                                    {{--Date--}}
                                    <div class="col-lg-4 col-md-12">
                                        <label for="{{'customField_'.$customField->id}}"
                                               class="form-control-label">{!!  $cf_title !!} {!! $cf_required_star !!}
                                            {!! $cf_lang_identifier !!}
                                        </label>
                                        {!! Form::text('customField_'.$customField->id,Helper::formatDate($customField->default_value), array('placeholder' => '','autocomplete' => 'off','class' => 'form-control form_date','id'=>'customField_'.$customField->id,$cf_required=>'', 'dir'=>$cf_land_dir)) !!}

                                    </div>
                                @elseif($customField->type ==3)
                                    {{--Email Address--}}
                                    <div class="col-lg-4 col-md-12">
                                        <label for="{{'customField_'.$customField->id}}"
                                               class="form-control-label">{!!  $cf_title !!} {!! $cf_required_star !!}
                                            {!! $cf_lang_identifier !!}
                                        </label>
                                        {!! Form::email('customField_'.$customField->id,$customField->default_value, array('placeholder' => '','autocomplete' => 'off','class' => 'form-control','id'=>'customField_'.$customField->id,$cf_required=>'', 'dir'=>$cf_land_dir)) !!}
                                    </div>
                                @elseif($customField->type ==2)
                                    {{--Number--}}
                                    <div class="col-lg-4 col-md-12">
                                        <label for="{{'customField_'.$customField->id}}"
                                               class="form-control-label">{!!  $cf_title !!} {!! $cf_required_star !!}
                                            {!! $cf_lang_identifier !!}
                                        </label>
                                        {!! Form::number('customField_'.$customField->id,$customField->default_value, array('placeholder' => '','autocomplete' => 'off','class' => 'form-control','id'=>'customField_'.$customField->id,$cf_required=>'','min'=>0, 'dir'=>$cf_land_dir,'onkeypress'=>'return isNumberKey(event)')) !!}
                                    </div>
                                @elseif($customField->type ==1)
                                    {{--Text Area--}}
                                    <div class="col-sm-12" >
                                        <label for="{{'customField_'.$customField->id}}"
                                               class="form-control-label" >{!!  $cf_title !!} {!! $cf_required_star !!}
                                            {!! $cf_lang_identifier !!}
                                        </label>
                                     <div>
                                         {!! Form::textarea('customField_'.$customField->id,$customField->default_value, array('placeholder' => '','autocomplete' => 'off','id' => 'customField_'.$customField->id,'class' => 'form-control',$cf_required=>'', 'dir'=>$cf_land_dir,'rows'=>'5')) !!}
                                     </div>
                                    </div>
                                @else
                                    {{--Text Box--}}
                                    <div class="col-lg-4 col-md-12">
                                        <label for="{{'customField_'.$customField->id}}"
                                               class="form-control-label">{!!  $cf_title !!} {!! $cf_required_star !!}
                                            {!! $cf_lang_identifier !!}
                                        </label>
                                        {!! Form::text('customField_'.$customField->id,$customField->default_value, array('placeholder' => '','autocomplete' => 'off','class' => 'form-control','id'=>'customField_'.$customField->id,$cf_required=>'', 'dir'=>$cf_land_dir)) !!}
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @endif
                    {{--End of -- Additional Feilds--}}


                    <div class="col-lg-4 col-md-12">
                        @if(config('smartend.nocaptcha_status'))
                            <div class="form-group mb-3">
                                {!! NoCaptcha::renderJs(@Helper::currentLanguage()->code) !!}
                                {!! NoCaptcha::display() !!}
                            </div>
                        @endif
                    </div>
                </div>
                <input type="hidden" name="TopicID" value="{{ @$Topic->id }}">
                <input type="hidden" name="WebmasterSectionId" value="{{ encrypt($WebmasterSection->id) }}">
                <button type="submit"
                        class="btn btn-lg submit-btn btn-theme"><i
                            class="fa-solid fa-paper-plane"></i> {{ __('backend.submit') }}</button>
                {{Form::close()}}
            </div>
        </div>

        @push('after-styles')
            <link rel="stylesheet"
                  href="{{ URL::asset('assets/frontend/vendor/datetime-picker/css/bootstrap-datetimepicker.min.css') }}?v={{ Helper::system_version() }}"/>
            <link rel="stylesheet"
                  href="{{ URL::asset('assets/frontend/vendor/select2/css/select2.min.css') }}?v={{ Helper::system_version() }}"/>
            @if(count($PhoneFieldsIds) >0)
                <link rel="stylesheet"
                      href="{{ URL::asset('assets/frontend/vendor/intl-tel-input/css/intlTelInput.min.css') }}?v={{ Helper::system_version() }}"/>
            @endif
        @endpush
        @push('after-scripts')
            <script
                    src="{{ URL::asset('assets/frontend/vendor/datetime-picker/js/bootstrap-datetimepicker.min.js') }}?v={{ Helper::system_version() }}"></script>
            <script
                    src="{{ URL::asset('assets/frontend/vendor/datetime-picker/js/locales/bootstrap-datetimepicker.'.@Helper::currentLanguage()->code.'.js') }}?v={{ Helper::system_version() }}"></script>
            <script
                    src="{{ URL::asset('assets/frontend/vendor/select2/js/select2.min.js') }}?v={{ Helper::system_version() }}"></script>
            @if(count($PhoneFieldsIds) >0)
                <script
                        src="{{ URL::asset('assets/frontend/vendor/intl-tel-input/js/intlTelInput.min.js') }}?v={{ Helper::system_version() }}"></script>
            @endif

            <script type="text/javascript">


                $(function () {
                    $(".select2").select2();
                    $(".select2-multiple").select2({
                        tags: true
                    });
                    $(".form_datetime").datetimepicker({
                        language: '{{ @Helper::currentLanguage()->code }}',
                        rtl: {{ (@Helper::currentLanguage()->direction=="rtl")?"true":"false" }},
                        autoclose: true,
                        todayHighlight: false,
                        showMeridian: true,
                        pickerPosition: 'bottom-{{ @Helper::currentLanguage()->right }}',
                    });
                    $(".form_date").datetimepicker({
                        format: 'yyyy-mm-dd',
                        language: '{{ @Helper::currentLanguage()->code }}',
                        rtl: {{ (@Helper::currentLanguage()->direction=="rtl")?"true":"false" }},
                        autoclose: true,
                        todayHighlight: false,
                        pickerPosition: 'bottom-right',
                        viewSelect: 2,
                        startView: 2,
                        maxView: 0,
                    }).on('changeDate', function (ev) {
                        $('.form_date').datetimepicker('hide');
                    });
                });

            </script>
        @endpush
    @endif
@endif
