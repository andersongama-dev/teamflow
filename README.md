[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)


# <img width="32" height="32" alt="image" src="https://github.com/user-attachments/assets/9d1859b6-87f1-49a6-9cd7-2ee5066231ec" /> TeamFlow

Sistema de Gestão Escolar desenvolvido com Laravel 12 como projeto acadêmico da disciplina de PWIII.

## Sobre o Projeto

O TeamFlow é um sistema de gestão escolar que permite o gerenciamento de alunos, professores, matérias, turmas, matrículas, notas e frequência através de uma interface moderna e responsiva.

O objetivo do projeto foi ir além do escopo inicial proposto em sala de aula, implementando recursos encontrados em sistemas acadêmicos reais.

## Tecnologias Utilizadas

- PHP 8+
- Laravel 12
- MySQL
- Tailwind CSS
- Flux UI
- Chart.js
- Laravel Eloquent ORM
- Spatie Laravel Permission

## Funcionalidades

### Autenticação e Segurança

- Login de usuários
- Controle de acesso por níveis
- Middleware de autorização
- Gerenciamento de permissões com Spatie Permission

### Perfis de Usuário

- Administrador
- Professor
- Aluno

### Gestão Acadêmica

- Cadastro de alunos
- Cadastro de professores
- Cadastro de matérias
- Cadastro de turmas
- Matrícula de alunos
- Lançamento de notas
- Controle de frequência

### Dashboard

- Estatísticas gerais do sistema
- Total de alunos
- Total de professores
- Total de matérias
- Total de turmas
- Gráficos utilizando Chart.js

### Auditoria

- Registro de ações do sistema
- Histórico de atividades

## Estrutura do Banco de Dados

### Tabelas Principais

| Tabela         | Descrição           |
| -------------- | ------------------- |
| users          | Usuários do sistema |
| roles          | Perfis de acesso    |
| students       | Alunos              |
| teachers       | Professores         |
| subjects       | Matérias            |
| school_classes | Turmas              |
| enrollments    | Matrículas          |
| grades         | Notas               |
| attendances    | Frequências         |
| activity_logs  | Histórico de ações  |

> Observação: durante o desenvolvimento a entidade `classes` foi substituída por `school_classes` para evitar conflitos com palavras reservadas e melhorar a organização do projeto.

## Relacionamentos

```txt
User
├── Student
└── Teacher

Teacher
├── Subjects
└── SchoolClasses

Student
├── Enrollments
├── Grades
└── Attendances

Subject
└── SchoolClasses

SchoolClasses
├── Enrollments
├── Grades
└── Attendances
```

## Recursos Implementados

- CRUD completo de alunos
- CRUD completo de professores
- CRUD completo de matérias
- CRUD completo de turmas
- CRUD completo de matrículas
- CRUD completo de notas
- CRUD completo de frequências
- CRUD completo de logs
- Relacionamentos Eloquent
- Factories
- Seeders
- Validação de formulários
- Controle de permissões
- Dashboard com indicadores

## Instalação

Clone o projeto:

```bash
git clone https://github.com/andersongama-dev/teamflow.git
```

Acesse a pasta:

```bash
cd teamflow
```

Atualize o Composer:

```bash
composer self-update
```

Instale as dependências:

```bash
composer install
```

Copie o arquivo de ambiente:

```bash
cp .env.example .env
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

Configure o banco de dados no arquivo `.env`.

Execute as migrations:

```bash
php artisan migrate
```

Popule o banco com dados de teste:

```bash
php artisan db:seed
```

Inicie o servidor:

```bash
php artisan serve
```

## Usuários de Teste

Os usuários de demonstração podem ser criados através dos Seeders configurados no projeto.

Perfis disponíveis:

- Administrador
- Professor
- Aluno

## Estrutura do Projeto

```txt
app/
├── Http/
├── Models/
├── Policies/
├── Providers/

database/
├── factories/
├── migrations/
├── seeders/

resources/
├── views/
├── css/

routes/
├── web.php
```

## Aprendizados Aplicados

Durante o desenvolvimento foram utilizados conceitos de:

- Arquitetura MVC
- Relacionamentos de banco de dados
- Eloquent ORM
- Middleware
- Controle de acesso baseado em papéis
- Validação de dados
- Seeders e Factories
- Dashboards administrativos
- Componentização de interfaces

## Licença

Este projeto é disponibilizado sob a licença MIT.

Consulte o arquivo `LICENSE` para mais informações.

---

Desenvolvido com Laravel 12.
