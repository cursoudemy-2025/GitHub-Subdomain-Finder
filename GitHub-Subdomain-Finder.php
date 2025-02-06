<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GitHub Subdomain Finder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .subdomains {
            margin-top: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
        }
        .subdomains div {
            margin-bottom: 5px;
        }
        .download-link {
            margin-top: 10px;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>GitHub Subdomain Finder</h1>

    <?php
    // Token de acesso pessoal do GitHub (coloque seu token real aqui)
    $token = ''; // ⚠️ Substitua pelo seu token pessoal

    // Função para buscar subdomínios nos repositórios do GitHub
    function buscarSubdominiosGitHub($dominio, $token, $org) {
        $url = "https://api.github.com/search/code?q=$dominio+in:file+org:$org";
        $headers = [
            'Authorization: token ' . $token,
            'User-Agent: PHP-Subdomain-Scraper'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            return "Erro ao acessar a API do GitHub.";
        }

        $json = json_decode($response, true);
        if (!isset($json['items']) || empty($json['items'])) {
            return [];
        }

        $subdominios = [];
        foreach ($json['items'] as $item) {
            $contents_url = $item['url'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $contents_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $file_response = curl_exec($ch);
            curl_close($ch);

            if ($file_response === false) {
                continue;
            }

            $file_data = json_decode($file_response, true);
            if ($file_data['encoding'] === 'base64') {
                $file_content = base64_decode($file_data['content']);

                preg_match_all('/(?:http[s]?:\/\/)?([a-zA-Z0-9\-\.]+)\.' . preg_quote($dominio, '/') . '/i', $file_content, $matches);

                foreach ($matches[1] as $match) {
                    $subdominio = strtolower($match);
                    $subdominio_completo = "https://$subdominio.$dominio";
                    if (!in_array($subdominio_completo, $subdominios)) {
                        $subdominios[] = $subdominio_completo;
                    }
                }
            }
        }

        file_put_contents('subdominios.txt', implode("\n", $subdominios));
        return $subdominios;
    }

    // Definir domínio e organização a serem buscados
    $dominio = 'facebook.com';
    $organizacao = 'Facebook';

    if (!empty($token)) {
        $subdominios = buscarSubdominiosGitHub($dominio, $token, $organizacao);
    } else {
        $subdominios = "Erro: Token de API não definido!";
    }

    $num_subdominios = is_array($subdominios) ? count($subdominios) : 0;
    ?>

    <div class="subdomains">
        <h2>Subdomínios encontrados para <?php echo $dominio; ?> na organização <?php echo $organizacao; ?> (<?php echo $num_subdominios; ?>):</h2>
        
        <?php if (is_array($subdominios) && !empty($subdominios)): ?>
            <div>
                <?php foreach ($subdominios as $subdominio): ?>
                    <div><?php echo htmlspecialchars($subdominio); ?></div>
                <?php endforeach; ?>
            </div>
            <a class="download-link" href="subdominios.txt" download>📥 Baixar lista de subdomínios (TXT)</a>
        <?php elseif (is_string($subdominios)): ?>
            <p style="color: red;"><?php echo $subdominios; ?></p>
        <?php else: ?>
            <p>Nenhum subdomínio encontrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
