<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Despesa Registrada</title>
</head>
<body>
    <h1>Nova Despesa Registrada</h1>
    <p>Uma nova despesa foi registrada no sistema. Abaixo estão os detalhes:</p>

    <ul>
        <li><strong>Descrição:</strong> {{ $despesa['descricao'] }}</li>
        <li><strong>Valor:</strong> R$ {{ number_format($despesa['valor'], 2, ',', '.') }}</li>
        <li><strong>Data:</strong> {{ \Carbon\Carbon::parse($despesa['data'])->format('d/m/Y') }}</li>
    </ul>

    <p>Atenciosamente,<br>Equipe Financeira</p>
</body>
</html>