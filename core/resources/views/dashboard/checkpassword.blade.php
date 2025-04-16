@section('title', Helper::GeneralSiteSettings("site_title_".@Helper::currentLanguage()->code))


<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('backend.Verify_password')}}</title>


        <link rel="icon" type="image/png" href="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings('style_logo_' . @Helper::currentLanguage()->code)) }}">

        <meta property="og:image" content="{{ URL::to('uploads/settings/'.Helper::GeneralSiteSettings('style_logo_' . @Helper::currentLanguage()->code)) }}">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #3498db, #8e44ad);
            color: white;
            font-family: 'Arial', sans-serif;
        }
        .card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
        }
        .btn-primary:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first('password') }}
    </div>
@endif

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card text-center">
        <h3>{{__('backend.Verify_password')}}</h3>
        <form method="POST" action="{{ route('backup.check') }}">
            @csrf
            <div class="mb-3">
                <label for="password" class="form-label">{{__('backend.password')}}</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">{{__('backend.Verify_password2')}}</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">{{__('backend.check')}}</button>
        </form>
        <div id="error-message" class="mt-3 text-danger" style="display: none;">{{__('backend.Passwordsdonotmatch')}}</div>
    </div>
</div>

<script>
    document.querySelector("form").addEventListener("submit", function(event) {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;

        if (password !== confirmPassword) {
            event.preventDefault();
            document.getElementById("error-message").style.display = "block";
        }
    });
</script>
</body>

</html>
