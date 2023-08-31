<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-4 d-flex justify-content-center">
        <div class="card border-secondary">
            <div class="card-body d-flex flex-column align-items-center">
                {!! QrCode::size(300)->generate('https://dashboard.textingdiscounts.com/live-signup/' . $tag) !!}
                <p class="mt-2 mb-0">Scan the QR code or click the link:</p>
                <a href="{{ 'https://dashboard.textingdiscounts.com/live-signup/' . $tag }}" target="_blank">{{ 'https://dashboard.textingdiscounts.com/live-signup/' . $tag }}</a>

            </div>

            <div class="card-body d-flex flex-column align-items-center">
                <form method="get" action="{{ route('qrcode.download', ['tag' => $tag]) }}">
                    @csrf
                    <div class="form-group py-2">
                        <button class="primary">Download</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>