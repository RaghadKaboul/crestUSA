<?php $lan=@Helper::currentLanguage()->code;

{{-- تحقق من وجود السجل --}}
    ?>
@if(!$certificate)
    <!DOCTYPE html>
<html lang="<?php echo $lan; ?>" dir="<?php echo $lan === 'ar' ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('frontend.Certificate_Details') }}</title>
    <link rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>{{ __('frontend.Certificate_Details') }}</h1>
    <div id="details-card">

      <p id="nodetailes">{{__('frontend.nodata')}}</p>
    </div>
    <button id="go-back-button" onclick="history.back()" style="margin-top: 20px; padding: 10px 20px; background-color: #1e3c6e; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
        {{ __('frontend.Go_Back') }}
    </button>
</div>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f7f9fc;
        margin: 0;
        padding: 0;
    }
    #nodetailes{
        color: red;
        text-align: center;
    }
    .container {
        max-width: 600px;
        margin: 2rem auto;
        padding: 1.5rem;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h1 {
        color: #333;
        margin-bottom: 20px;
    }

    #details-card {
        margin-top: 20px;
        text-align: left;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e6e9ef;
    }

    .label {
        font-weight: bold;
        color: #6c757d;
    }

    .value {
        color: #2d3436;
    }

    .status-tag {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;

    }
</style>

<script src="script.js"></script>
</body>
</html>
@else
    <!DOCTYPE html>
    <html lang="<?php echo $lan; ?>" dir="<?php echo $lan === 'ar' ? 'rtl' : 'ltr'; ?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ __('frontend.Certificate_Details') }}</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f7f9fc;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 2rem auto;
                padding: 1.5rem;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            h1 {
                color: #333;
                margin-bottom: 20px;
            }
            .detail-item {
                display: flex;
                justify-content: space-between;
                padding: 10px 0;
                border-bottom: 1px solid #e6e9ef;
            }
            .label {
                font-weight: bold;
                color: #6c757d;
            }
            .value {
                color: #2d3436;
            }
            .status-tag {
                display: inline-block;
                padding: 5px 10px;
                border-radius: 5px;
                font-weight: bold;
                color: #fff;
            }
            .status-tag.approved {
                background-color: #2ecc71; /* أخضر للحالة المعتمدة */
            }
            .status-tag.expired {
                background-color: #e74c3c; /* أحمر للحالة منتهية الصلاحية */
            }
            .status-tag.pending {
                background-color: #f1c40f; /* أصفر للحالة قيد الانتظار */
            }
        </style>
    </head>
    <body>
    <div class="container">
        <h1>{{ __('frontend.Certificate_Details') }}</h1>
        <div id="details-card">
            @if($certificate)
                <div class="detail-item">
                    <span class="label">{{__('frontend.Certificate_Number')}} :</span>
                    <span class="value" id="certificate-number">{{ $certificate->certificate_number }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">{{__('frontend.Holder_Name')}} :</span>
                    <span class="value" id="holder-name">{{ $certificate->certificate_holders_name }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">{{__('frontend.Release')}} :</span>
                    <span class="value" id="release-date">{{ $certificate->releas_date }}</span>
                </div>
                <div class="detail-item">
                    <span class="label"> {{__('frontend.Expiry')}} :</span>
                    <span class="value" id="expiry-date">{{ $certificate->Expiry_date ?: '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">{{__('frontend.Issuing')}} :</span>
                    <span class="value" id="issuing-authority">{{ $certificate->Issuing_authority }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">{{__('frontend.status')}} :</span>
                    <span
                        class="status-tag
                    {{
                        $certificate->status === 'معتمدة'
                        ? 'approved'
                        : ($certificate->status === 'غير معتمدة'
                            ? 'expired'
                            : ($certificate->status === 'منتهية الصلاحية'
                                ? 'pending'
                                : '')
                          )
                    }}"
                    >
        {{ $certificate->status }}
    </span>
                </div>


        </div>
            @else
                <p id="nodetailes">{{__('frontend.nodata')}}</p>
            @endif
        <button id="go-back-button" onclick="history.back()" style="margin-top: 20px; padding: 10px 20px; background-color: #1e3c6e; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
            {{ __('frontend.Go_Back') }}
        </button>
        </div>
    </div>

    </body>
    </html>



@endif

