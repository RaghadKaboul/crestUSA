@extends('dashboard.layouts.master')
@section('title', Helper::GeneralSiteSettings("site_title_".@Helper::currentLanguage()->code))

<?php $lan=@Helper::currentLanguage()->code; ?>

@push("after-styles")
    <style>
        body {
            background-color: #f4f7f9; /* لون خلفية لطيف */
        }
        .certificate-container {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 90%;
            margin: 40px auto;
        }
        .certificate-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .table {
            margin-top: 20px;
            border-collapse: separate;
            border-spacing: 0 10px;
            width: 100%;
        }
        .table th {
            background-color: #f7f7f7;
            color: #555;
            font-weight: bold;
            text-align: center;
            padding: 15px;
        }
        .table td {
            background-color: #fff;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
        }
        .table tr:hover {
            background-color: #eaf2f8; /* تأثير hover */
        }
        .table-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .bb {
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;

        }
        .btn-warning {
            background-color: #ffc107;
            border: none;
            width: 30%;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;

        }
        .pagination {
            margin-top: 20px;
            justify-content: center;
        }
    </style>
@endpush

@section('content')
    <html lang="<?php echo $lan; ?>" dir="<?php echo $lan === 'ar' ? 'rtl' : 'ltr'; ?>">

    <div class="certificate-container">
    <h2 style="
        font-size: 30px;
        color: #2c3e50;
        text-align: center;
        font-weight: bold;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); /* تأثير الظل */
    ">{{__('frontend.certificate')}}</h2>
        <div class="table-actions">
            <a href="{{ route('certificates.create') }}" class="bb btn btn-primary">{{__('frontend.new_certificate')}}</a>
            <div class="form-group">
                <label for=" Issuing_authority">{{__('frontend.certificatescount')}} :</label>
                <a  class="btn primary ">{{$certificatescount}}</a>
            </div>
        </div>



        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ __('frontend.Certificate_Number') }}</th>
                <th>{{ __('frontend.Holder_Name') }}</th>
                <th>{{ __('frontend.Release') }}</th>
                <th>{{ __('frontend.Expiry') }}</th>
                <th>{{ __('frontend.Issuing') }}</th>
                <th>{{ __('frontend.status') }}</th>
                <th>{{ __('frontend.option') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($certificates as $key => $certificate)
                <tr>
                    <td>{{ $key + 1 + (($certificates->currentPage() - 1) * $certificates->perPage()) }}</td>
                    <td>{{ $certificate->certificate_number }}</td>
                    <td>{{ $certificate->certificate_holders_name }}</td>
                    <td>{{ $certificate->releas_date }}</td>
                    <td>{{ $certificate->Expiry_date ?: '-' }}</td>
                    <td>{{ $certificate->Issuing_authority }}</td>
                    <td>
                        @if($certificate->status == 'معتمدة')
                            {{ __('frontend.approved') }}
                        @elseif($certificate->status == 'غير معتمدة')
                            {{ __('frontend.Not_approved') }}
                        @else
                            {{ __('frontend.Expired') }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('certificates.edit', $certificate->id) }}" class="bb btn btn-warning">{{__('frontend.Edit')}}</a>
                        <form action="{{ route('certificates.destroy', $certificate->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bb btn btn-danger" onclick="return confirm('هل أنت متأكد؟')">{{__('frontend.Delete')}}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">{{__('frontend.noCertificates')}}</td>
                </tr>
            @endforelse
            </tbody>

        </table>

        <div class="d-flex pagination">
            {{ $certificates->links('pagination::bootstrap-4') }}

        </div>

    </div>
    </html>
@endsection
