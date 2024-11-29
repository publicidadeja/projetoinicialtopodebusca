<!DOCTYPE html>
<html>
<head>
    <title>Business Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1>Suas Contas do Business Profile</h1>

                @if(isset($accounts['error']))
                    <div class="alert alert-danger">
                        @if(is_array($accounts['error']))
                            @if(isset($accounts['error']['message']))
                                {{ $accounts['error']['message'] }}
                            @else
                                {{ json_encode($accounts['error']) }}
                            @endif
                        @else
                            {{ $accounts['error'] }}
                        @endif
                        <br><br>
                        <a href="{{ url('auth/google') }}" class="btn btn-primary">
                            Reconectar com Google
                        </a>
                    </div>
                @else
                    <div class="list-group">
                        @if(!empty($accounts['accounts']))
                            @foreach($accounts['accounts'] as $account)
                                <div class="list-group-item">
                                    <h5 class="mb-1">{{ $account['accountName'] ?? 'Sem nome' }}</h5>
                                    <p class="mb-1">Nome: {{ $account['name'] ?? 'Não especificado' }}</p>
                                    @if(isset($account['organizationInfo']))
                                        <p class="mb-1">Organização: {{ $account['organizationInfo']['name'] ?? 'Não especificado' }}</p>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                Nenhuma conta encontrada. Você precisa ter um perfil empresarial configurado no Google.
                                <br><br>
                                <a href="https://business.google.com" target="_blank" class="btn btn-primary">
                                    Criar Perfil Empresarial
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>