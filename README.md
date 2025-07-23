# README - Sistema de Biblioteca Virtual em PHP

## 📚 Descrição do Projeto
Sistema completo de biblioteca virtual desenvolvido em PHP para gerenciamento de acervo de livros digitais, com funcionalidades de cadastro, busca e visualização.

## 🛠️ Pré-requisitos
- Servidor web (XAMPP/LAMPP recomendado)
- PHP 7.0 ou superior
- Extensão fileinfo habilitada no PHP

## 📥 Instalação

1. Clone o repositório:
```bash
git clone https://github.com/kaitotsubaki/biblioteca-alvaro.git
```

2. Mova para o diretório do servidor web:
```bash
sudo mv biblioteca-alvaro /opt/lampp/htdocs/
```

3. Configure as permissões:
```bash
cd /opt/lampp/htdocs/biblioteca-alvaro
sudo chmod -R 755 .
sudo chmod 777 capas livros
sudo chmod 666 banco.txt
```

## 🚀 Como Usar

1. Inicie o servidor XAMPP:
```bash
sudo /opt/lampp/lampp start
```

2. Acesse no navegador:
```
http://localhost/biblioteca-alvaro/
```

## 🧩 Funcionalidades

✔️ **Cadastro de Livros**  
- Título, autor, editora, ano e descrição  
- Upload de capa (imagem) e arquivo do livro (PDF/EPUB)  

✔️ **Sistema de Busca**  
- Pesquisa por título ou autor  
- Exibição de resultados  

✔️ **Visualização Detalhada**  
- Informações completas do livro  
- Download do arquivo  

✔️ **Gerenciamento**  
- Exclusão de livros  

## 🗂️ Estrutura de Arquivos
```
biblioteca-alvaro/
├── index.php         # Página principal
├── cadastro.php      # Formulário de cadastro
├── livro.php         # Visualização do livro
├── funcoes.php       # Funções auxiliares
├── banco.txt         # Armazenamento dos dados
├── capas/            # Pasta para capas dos livros
└── livros/           # Pasta para arquivos dos livros
```

## 🔧 Solução de Problemas

### Erros de Permissão
```bash
sudo chown -R $USER:$USER /opt/lampp/htdocs/biblioteca-alvaro
```

### Verificar Logs
```bash
tail -f /opt/lampp/logs/php_error_log
```

### Configuração PHP
Edite `/opt/lampp/etc/php.ini` e verifique:
```ini
file_uploads = On
upload_max_filesize = 10M
post_max_size = 12M
display_errors = On
error_reporting = E_ALL
```

## ♻️ Atualizando o Projeto
Para atualizar quando novas versões forem disponibilizadas:
```bash
cd /opt/lampp/htdocs/biblioteca-alvaro
git pull
```

## 📝 Licença
Este projeto está disponível como código aberto. Sinta-se à vontade para utilizar e modificar conforme suas necessidades.

## ✉️ Contato
Para dúvidas ou sugestões, abra uma issue no repositório ou entre em contato com o mantenedor.
