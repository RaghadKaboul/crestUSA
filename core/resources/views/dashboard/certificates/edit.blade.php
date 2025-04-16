@extends('dashboard.layouts.master')
@section('title', 'تعديل شهادة')
@push('after-styles')
    <style>
        .form-container {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 40px auto; /* Spacing from the top */
        }
        .form-container h2 {
            margin-bottom: 30px;
            font-size: 26px;
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px; /* Larger spacing between fields */
        }
        .form-group label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px; /* Better alignment for field labels */
            display: block;
        }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 12px; /* Increase input field size */
            font-size: 16px; /* Enlarge text */
            transition: border-color 0.3s ease-in-out; /* Field hover effect */
        }
        .form-control:focus {
            border-color: #80bdff; /* Highlighted color */
            outline: none;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
        }
        .bb {
            width: 100%;
            padding: 12px;
            font-size: 18px; /* Larger button */
            background-color: #5D8AA8; /* Calm blue color */
            border-radius: 5px;
            border: none;
            color: #FFFFFF; /* White text */
            transition: background-color 0.3s ease-in-out; /* Button hover effect */
        }
        .bb:hover {
            background-color: #1E4F75; /* Slightly darker blue on hover */
        }
    </style>
@endpush

@section('content')
    <!-- Include Flatpickr Library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <div class="form-container">
        <h2>{{ __('frontend.edit_certificate') }}</h2>
        <form action="{{ route('certificates.update', $certificate->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Use PUT method -->
            <div class="form-group">
                <label for="certificate_number">{{ __('frontend.Certificate_Number') }}</label>
                <input type="text" name="certificate_number" id="certificate_number" class="form-control" value="{{ $certificate->certificate_number }}" required>
            </div>
            <div class="form-group">
                <label for="certificate_holders_name">{{ __('frontend.Holder_Name') }}</label>
                <input type="text" name="certificate_holders_name" id="certificate_holders_name" class="form-control" value="{{ $certificate->certificate_holders_name }}" required>
            </div>
            <div class="form-group">
                <label for="releas_date">{{ __('frontend.Release') }}</label>
                <input
                    type="text"
                    name="releas_date"
                    id="releas_date"
                    class="form-control"
                    value="{{ $certificate->releas_date }}"
                    required
                    placeholder="YYYY-MM-DD">
            </div>
            <div class="form-group">
                <label for="Expiry_date">{{ __('frontend.Expiry') }}</label>
                <input
                    type="text"
                    name="Expiry_date"
                    id="Expiry_date"
                    class="form-control"
                    value="{{ $certificate->Expiry_date }}"
                    placeholder="YYYY-MM-DD">
            </div>
            <div class="form-group">
                <label for="Issuing_authority">{{ __('frontend.Issuing') }}</label>
                <input type="text" name="Issuing_authority" id="Issuing_authority" class="form-control" value="{{ $certificate->Issuing_authority }}" required>
            </div>
            <div class="form-group">
                <label for="status">{{__('frontend.status')}}</label>
                <select name="status" id="status" class="form-control" required style="height: 5%">
                    <option value="معتمدة" {{ $certificate->status == 'معتمدة' ? 'selected' : '' }}>{{ __('frontend.approved') }}</option>
                    <option value="غير معتمدة" {{ $certificate->status == 'غير معتمدة' ? 'selected' : '' }}>{{ __('frontend.Not_approved') }}</option>
                    <option value="منتهية الصلاحية" {{ $certificate->status == 'منتهية الصلاحية' ? 'selected' : '' }}>{{ __('frontend.Expired') }}</option>
                </select>
            </div>
            <button type="submit" class="bb">{{ __('frontend.Edit') }}</button>
        </form>
    </div>

    <script>
        // Initialize Flatpickr for English Date Formatting
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#releas_date", {
                dateFormat: "Y-M-d", // Format as YYYY-MM-DD
                locale: "en" // Set English locale
            });

            flatpickr("#Expiry_date", {
                dateFormat: "Y-M-d", // Format as YYYY-MM-DD
                locale: "en" // Set English locale
            });
        });
    </script>


@endsection
