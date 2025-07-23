# Sistema de Biblioteca Virtual em PHP

Este é um sistema completo de biblioteca virtual desenvolvido em PHP.

## Funcionalidades
- Cadastro de livros
- Upload de capas e arquivos
- Busca por título/autor
- Visualização detalhada

## Requisitos
- XAMPP/LAMPP
- PHP 7.0+
- Extensão fileinfo habilitada no PHP

## Instalação
1. Clone este repositório para /opt/lampp/htdocs/
2. Configure as permissões:
   ```bash
   chmod -R 755 biblio
   chmod 777 biblio/capas biblio/livros
   chmod 666 biblio/banco.txt
   ```

