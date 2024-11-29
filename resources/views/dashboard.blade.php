<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<a href="{{ route('business.index') }}" class="btn btn-primary">
    Ver Business Profile
</a>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        @if(auth()->check())
                            <p>Bem vindo, {{ auth()->user()->name }}!</p>
                            <p>Seu email: {{ auth()->user()->email }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>