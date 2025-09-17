<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Property;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Página de ações administrativas
     */
    public function acoes()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('email_verified_at', '!=', null)->count(),
            'total_properties' => Property::count(),
            'active_properties' => Property::active()->count(),
            'total_contacts' => Contact::count(),
            'pending_contacts' => Contact::where('status', Contact::STATUS_SENT)->count(),
            'total_categories' => Category::count(),
            'active_categories' => Category::active()->count(),
        ];

        return view('admin.acoes', compact('stats'));
    }

    /**
     * Gerenciar usuários
     */
    public function usuarios(Request $request)
    {
        $query = User::withCount(['properties']);

        // Filtros
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            if ($request->status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15);

        return view('admin.usuarios', compact('users'));
    }

    /**
     * Gerenciar categorias
     */
    public function categorias()
    {
        $categories = Category::withCount(['properties'])->ordered()->get();

        return view('admin.categorias', compact('categories'));
    }

    /**
     * Gerenciar imóveis
     */
    public function imoveis(Request $request)
    {
        $query = Property::with(['user', 'category', 'images']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $properties = $query->paginate(15);
        $categories = Category::active()->ordered()->get();

        return view('admin.imoveis', compact('properties', 'categories'));
    }

    /**
     * Relatórios administrativos
     */
    public function relatorios()
    {
        $stats = [
            // Usuários
            'total_users' => User::count(),
            'users_by_role' => User::selectRaw('role, COUNT(*) as count')->groupBy('role')->get(),
            'new_users_last_30' => User::where('created_at', '>=', now()->subDays(30))->count(),

            // Imóveis
            'total_properties' => Property::count(),
            'properties_by_status' => Property::selectRaw('status, COUNT(*) as count')->groupBy('status')->get(),
            'properties_by_type' => Property::selectRaw('type, COUNT(*) as count')->groupBy('type')->get(),
            'properties_by_state' => Property::selectRaw('state, COUNT(*) as count')->groupBy('state')->get(),
            'new_properties_last_30' => Property::where('created_at', '>=', now()->subDays(30))->count(),

            // Contatos
            'total_contacts' => Contact::count(),
            'contacts_by_status' => Contact::selectRaw('status, COUNT(*) as count')->groupBy('status')->get(),
            'new_contacts_last_30' => Contact::where('created_at', '>=', now()->subDays(30))->count(),

            // Visitas (se habilitadas)
            'total_visits' => Visit::count(),
            'new_visits_last_30' => Visit::where('created_at', '>=', now()->subDays(30))->count(),

            // Categorias
            'categories_usage' => Category::withCount(['properties'])->orderBy('properties_count', 'desc')->get(),

            // Estatísticas de performance
            'avg_properties_per_user' => User::where('role', 'corretor')->withCount('properties')->get()->avg('properties_count'),
            'most_active_users' => User::withCount(['properties', 'receivedContacts'])
                ->orderByRaw('(properties_count + received_contacts_count) desc')
                ->limit(10)->get(),
        ];

        return view('admin.relatorios', compact('stats'));
    }

    /**
     * Configurações do sistema
     */
    public function configuracoes()
    {
        $config = [
            'app_name' => config('app.name'),
            'app_url' => config('app.url'),
            'timezone' => config('app.timezone'),
            'locale' => config('app.locale'),
            'maintenance_mode' => app()->isDownForMaintenance(),
        ];

        return view('admin.configuracoes', compact('config'));
    }

    /**
     * Salvar configurações do sistema
     */
    public function salvarConfiguracoes(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_url' => 'required|url',
            'timezone' => 'required|string',
            'locale' => 'required|string',
            'maintenance_mode' => 'nullable|boolean',
        ]);

        // Atualizar arquivo .env
        $envFile = base_path('.env');
        $envContent = File::get($envFile);

        $envUpdates = [
            'APP_NAME' => '"' . $validated['app_name'] . '"',
            'APP_URL' => $validated['app_url'],
            'APP_TIMEZONE' => $validated['timezone'],
            'APP_LOCALE' => $validated['locale'],
        ];

        foreach ($envUpdates as $key => $value) {
            $envContent = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $envContent);
        }

        File::put($envFile, $envContent);

        // Modo de manutenção
        if (isset($validated['maintenance_mode']) && $validated['maintenance_mode']) {
            Artisan::call('down');
        } else {
            Artisan::call('up');
        }

        return back()->with('success', 'Configurações salvas com sucesso!');
    }

    /**
     * Página de backup
     */
    public function backup()
    {
        // Listar backups existentes
        $backupPath = storage_path('backups');
        $backups = [];

        if (File::exists($backupPath)) {
            $files = File::files($backupPath);
            foreach ($files as $file) {
                if (str_contains($file->getFilename(), '.sql') || str_contains($file->getFilename(), '.zip')) {
                    $backups[] = [
                        'name' => $file->getFilename(),
                        'size' => $file->getSize(),
                        'date' => $file->getMTime(),
                        'path' => $file->getPathname(),
                    ];
                }
            }
            // Ordenar por data (mais recente primeiro)
            usort($backups, function($a, $b) {
                return $b['date'] <=> $a['date'];
            });
        }

        return view('admin.backup', compact('backups'));
    }

    /**
     * Criar backup
     */
    public function createBackup(Request $request)
    {
        $type = $request->get('type', 'database');

        try {
            $timestamp = now()->format('Y-m-d_H-i-s');
            $backupPath = storage_path('backups');

            // Criar diretório se não existir
            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }

            if ($type === 'database') {
                // Backup do banco de dados SQLite
                $dbPath = database_path('database.sqlite');
                $backupFile = $backupPath . "/backup_database_{$timestamp}.sqlite";

                if (File::exists($dbPath)) {
                    File::copy($dbPath, $backupFile);
                    Log::info("Backup do banco criado: {$backupFile}");
                }
            } elseif ($type === 'files') {
                // Backup dos arquivos enviados
                $filesPath = storage_path('app/public');
                $backupFile = $backupPath . "/backup_files_{$timestamp}.zip";

                // Criar ZIP dos arquivos
                $zip = new \ZipArchive();
                if ($zip->open($backupFile, \ZipArchive::CREATE) === TRUE) {
                    $files = File::allFiles($filesPath);
                    foreach ($files as $file) {
                        $relativePath = str_replace($filesPath . '/', '', $file->getPathname());
                        $zip->addFile($file->getPathname(), $relativePath);
                    }
                    $zip->close();
                    Log::info("Backup de arquivos criado: {$backupFile}");
                }
            }

            return back()->with('success', 'Backup criado com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao criar backup: ' . $e->getMessage());
            return back()->with('error', 'Erro ao criar backup: ' . $e->getMessage());
        }
    }

    /**
     * Página de logs
     */
    public function logs()
    {
        $logFile = storage_path('logs/laravel.log');

        $logs = [];
        if (File::exists($logFile)) {
            $logContent = File::get($logFile);
            $logLines = explode("\n", $logContent);
            $logLines = array_reverse(array_filter($logLines)); // Reverter e filtrar linhas vazias

            // Pegar apenas as últimas 100 linhas
            $logs = array_slice($logLines, 0, 100);
        }

        return view('admin.logs', compact('logs'));
    }

    /**
     * Download dos logs
     */
    public function downloadLogs()
    {
        $logFile = storage_path('logs/laravel.log');

        if (!File::exists($logFile)) {
            return back()->with('error', 'Arquivo de log não encontrado.');
        }

        return response()->download($logFile, 'laravel_' . now()->format('Y-m-d_H-i-s') . '.log');
    }

    /**
     * Limpar cache do sistema
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            return response()->json([
                'success' => true,
                'message' => 'Cache limpo com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao limpar cache: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualizar role do usuário
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:cliente,corretor,admin'
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'Role do usuário atualizado com sucesso!');
    }

    /**
     * Excluir usuário
     */
    public function deleteUser(User $user)
    {
        // Não permitir excluir admin
        if ($user->role === 'admin') {
            return back()->with('error', 'Não é possível excluir usuários administradores.');
        }

        $user->delete();

        return back()->with('success', 'Usuário excluído com sucesso!');
    }

    /**
     * Criar categoria
     */
    public function storeCategoria(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
            'icon' => 'nullable|string|max:10',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        Category::create($validated);

        return back()->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Atualizar categoria
     */
    public function updateCategoria(Request $request, Category $categoria)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $categoria->id,
            'icon' => 'nullable|string|max:10',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $categoria->update($validated);

        return back()->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Alternar status da categoria
     */
    public function toggleCategoria(Category $categoria)
    {
        $categoria->update(['is_active' => !$categoria->is_active]);

        return back()->with('success', 'Status da categoria alterado com sucesso!');
    }

    /**
     * Excluir categoria
     */
    public function deleteCategoria(Category $categoria)
    {
        if ($categoria->properties()->count() > 0) {
            return back()->with('error', 'Não é possível excluir categoria que possui imóveis.');
        }

        $categoria->delete();

        return back()->with('success', 'Categoria excluída com sucesso!');
    }

    /**
     * Atualizar status do imóvel
     */
    public function updatePropertyStatus(Request $request, Property $property)
    {
        $request->validate([
            'status' => 'required|in:ativo,inativo,vendido,alugado'
        ]);

        $property->update(['status' => $request->status]);

        return back()->with('success', 'Status do imóvel atualizado com sucesso!');
    }
}
