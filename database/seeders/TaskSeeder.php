<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            ['title' => 'Configurar ambiente de desenvolvimento', 'description' => 'Instalar Docker, PHP 8.4 e dependências necessárias', 'completed' => true],
            ['title' => 'Criar estrutura do projeto Laravel', 'description' => 'Inicializar projeto Laravel 12 com Repository Pattern', 'completed' => true],
            ['title' => 'Implementar sistema de tasks', 'description' => 'CRUD completo com validações e camada de serviço', 'completed' => true],
            ['title' => 'Adicionar testes unitários', 'description' => 'Criar testes para Service e Repository layers', 'completed' => false],
            ['title' => 'Implementar autenticação JWT', 'description' => 'Sistema de login com tokens JWT e refresh tokens', 'completed' => false],
            ['title' => 'Criar documentação da API', 'description' => 'Documentar endpoints com Swagger/OpenAPI', 'completed' => false],
            ['title' => 'Configurar CI/CD', 'description' => 'Pipeline com GitHub Actions para testes e deploy', 'completed' => false],
            ['title' => 'Adicionar sistema de notificações', 'description' => 'Notificações por email para tasks importantes', 'completed' => false],
            ['title' => 'Implementar filtros avançados', 'description' => 'Busca por título, status e ordenação customizada', 'completed' => false],
            ['title' => 'Criar dashboard administrativo', 'description' => 'Painel com estatísticas e gráficos de produtividade', 'completed' => false],
            ['title' => 'Otimizar queries do banco', 'description' => 'Adicionar índices e eager loading onde necessário', 'completed' => false],
            ['title' => 'Implementar rate limiting', 'description' => 'Proteger API contra abuso com throttling', 'completed' => false],
            ['title' => 'Adicionar logs estruturados', 'description' => 'Sistema de logging com contexto e rastreabilidade', 'completed' => false],
            ['title' => 'Criar seeds para desenvolvimento', 'description' => 'Dados de exemplo para testar funcionalidades', 'completed' => true],
            ['title' => 'Configurar backup automático', 'description' => 'Rotina diária de backup do banco de dados', 'completed' => false],
            ['title' => 'Implementar versionamento de API', 'description' => 'Suporte para múltiplas versões da API (v1, v2)', 'completed' => false],
            ['title' => 'Adicionar cache de respostas', 'description' => 'Redis para cache de queries mais pesadas', 'completed' => false],
            ['title' => 'Criar webhooks para integrações', 'description' => 'Sistema de webhooks para notificar sistemas externos', 'completed' => false],
            ['title' => 'Implementar soft deletes', 'description' => 'Permitir recuperação de tasks excluídas', 'completed' => false],
            ['title' => 'Adicionar suporte a anexos', 'description' => 'Upload de arquivos vinculados às tasks', 'completed' => false],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
