@extends('dashboard.layouts.master')
@section('title', 'إضافة شهادة جديدة')
<?php $lan=@Helper::currentLanguage()->code;

{{-- تحقق من وجود السجل --}}
?>

@push('after-styles')
    <style>
        .form-container {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 40px auto; /* مسافة من الأعلى */
        }
        .form-container h2 {
            margin-bottom: 30px;
            font-size: 26px;
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px; /* مسافة أكبر بين الحقول */
        }
        .form-group label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px; /* تنسيق أفضل لعنوان الحقل */
            display: block;
        }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 12px; /* تكبير الحقول */
            font-size: 16px; /* تكبير النص */
            transition: border-color 0.3s ease-in-out; /* تأثير عند التفاعل مع الحقل */
        }
        .form-control:focus {
            border-color: #80bdff; /* لون مميز عند التركيز */
            outline: none;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
        }
        .bb {
            width: 100%;
            padding: 12px;
            font-size: 18px; /* تكبير زر الإضافة */
            background-color: #5D8AA8; /* لون أزرق هادئ */
            border-radius: 5px;
            border: none;
            color: #FFFFFF; /* لون النص الأبيض */
            transition: background-color 0.3s ease-in-out; /* تأثير التفاعل */
        }
        .bb:hover {
            background-color: #1E4F75; /* لون أقرب للكحلي عند التفاعل */
        }

    </style>
@endpush

@section('content')
    <html lang="<?php echo $lan; ?>" dir="<?php echo $lan === 'ar' ? 'rtl' : 'ltr'; ?>">

    <div class="form-container">
        <h2>{{__('frontend.new_certificate')}}</h2>
        <form action="{{ route('certificates.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="certificate_number">{{__('frontend.Certificate_Number')}}</label>
                <input type="text" name="certificate_number" id="certificate_number" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="certificate_holders_name">{{__('frontend.Holder_Name')}}</label>
                <input type="text" name="certificate_holders_name" id="certificate_holders_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="releas_date">{{__('frontend.Release')}}</label>
                <input type="date" name="releas_date" id="releas_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="Expiry_date">{{__('frontend.Expiry')}}</label>
                <input type="date" name="Expiry_date" id="Expiry_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="Issuing_authority">{{__('frontend.Issuing')}}</label>
                <input type="text" name="Issuing_authority" id="Issuing_authority" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="status">{{__('frontend.status')}}</label>
                <select name="status" id="status" class="form-control" required style="height: 5%">
                    <option value="معتمدة">{{__('frontend.approved')}}</option>
                    <option value="غير معتمدة"> {{__('frontend.Not_approved')}}</option>
                    <option value="منتهية الصلاحية"> {{__('frontend.Expired')}}</option>
                </select>
            </div>
            <button type="submit" class="  bb" style="  justify-content: center;">{{__('frontend.add')}}</button>

        </form>
    </div>
    </html>
@endsection
