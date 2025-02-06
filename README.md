
# GitHub Subdomain Finder

Este é um script PHP para buscar subdomínios de um domínio específico nos repositórios do GitHub. Ele faz uso da API do GitHub para procurar arquivos contendo subdomínios relacionados a um domínio em uma organização específica.

## Requisitos

Antes de executar o script, você precisa garantir que tenha os seguintes requisitos:

- **PHP**: O script é escrito em PHP. Certifique-se de ter o PHP instalado no seu ambiente local.
- **Token de Acesso Pessoal do GitHub**: Para acessar a API do GitHub, você precisará de um token de acesso pessoal (PAT). [Saiba como criar um token de acesso pessoal aqui](https://docs.github.com/en/github/authenticating-to-github/creating-a-personal-access-token).
- **Servidor Local (opcional)**: Para rodar o script localmente, você pode usar o XAMPP ou qualquer outro servidor local que suporte PHP.

## Como Configurar

1. **Clone o repositório**

   Se você ainda não tem o repositório clonado em sua máquina, use o seguinte comando no terminal:

   ```bash
   git clone https://github.com/usuario/gh-subdomain-finder.git
   ```

2. **Obtenha o Token de Acesso Pessoal do GitHub**

   - Acesse sua conta do GitHub.
   - Vá para [Settings > Developer settings > Personal access tokens](https://github.com/settings/tokens).
   - Clique em "Generate new token".
   - Selecione as permissões que deseja conceder ao token (pelo menos `repo` para acessar repositórios privados, se necessário).
   - Copie o token gerado, você precisará dele mais tarde.

3. **Configuração do Token no Script**

   Abra o arquivo `index.php` e substitua a variável `$token` pelo seu token pessoal do GitHub:

   ```php
   $token = 'SEU_TOKEN_AQUI';
   ```

4. **Configuração do Domínio e Organização**

   No mesmo arquivo (`index.php`), defina o domínio e a organização que você deseja pesquisar:

   ```php
   $dominio = 'facebook.com';  // Substitua pelo domínio desejado
   $organizacao = 'Facebook';  // Substitua pela organização desejada
   ```

5. **Configuração do Servidor Local**

   Se você estiver utilizando o XAMPP, siga os passos abaixo:

   - Instale o XAMPP [aqui](https://www.apachefriends.org/pt_br/index.html).
   - Abra o XAMPP e inicie o Apache.
   - Coloque o script PHP no diretório `htdocs` dentro do diretório onde o XAMPP foi instalado.
   - Acesse o script através do navegador, indo até `http://localhost/nome_do_repositorio/index.php`.

## Como Funciona

O script realiza os seguintes passos:

1. Faz uma pesquisa no GitHub por arquivos que contêm links para o domínio especificado, dentro da organização que você escolher.
2. Busca todos os subdomínios que aparecem nos arquivos de código, verificando se os links seguem o padrão de subdomínio do domínio fornecido.
3. Exibe a lista de subdomínios encontrados e oferece a opção de fazer o download da lista em um arquivo `.txt`.

## Exemplo de Saída

Se você usar `facebook.com` como domínio e `Facebook` como organização, o script pode retornar algo assim:

```
Subdomínios encontrados para facebook.com na organização Facebook (3):
https://sub1.facebook.com
https://sub2.facebook.com
https://sub3.facebook.com
```

Você também pode fazer o download da lista de subdomínios:

[Nome do arquivo (TXT)](subdominios.txt)

## Problemas Conhecidos

- Certifique-se de que seu token de acesso do GitHub tem permissões suficientes para acessar os repositórios da organização.
- O script pode não funcionar corretamente se não houver subdomínios encontrados ou se a organização não contiver repositórios com o domínio especificado.

## Contribua

Sinta-se à vontade para contribuir com melhorias ou sugestões para este projeto! Basta abrir um **pull request** ou **issue**.
