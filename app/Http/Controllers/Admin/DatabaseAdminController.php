<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class DatabaseAdminController extends Controller
{
    public function index(string $locale)
    {
        $tables = collect($this->tableNames())
            ->map(function (string $table) {
                return [
                    'name' => $table,
                    'rows' => $this->safeCount($table),
                    'columns' => count($this->columnNames($table)),
                    'primary_key' => $this->primaryKey($table),
                ];
            })
            ->sortBy('name', SORT_NATURAL)
            ->values();

        return view('admin.database.index', [
            'tables' => $tables,
            'adminActive' => 'database',
        ]);
    }

    public function show(string $locale, Request $request, string $table)
    {
        $this->abortIfUnknownTable($table);

        $columns = $this->columns($table);
        $columnNames = collect($columns)->pluck('name')->all();
        $primaryKey = $this->primaryKeyFromColumns($columns);
        $search = trim((string) $request->query('q', ''));
        $sort = (string) $request->query('sort', '');
        $direction = strtolower((string) $request->query('direction', 'desc')) === 'asc' ? 'asc' : 'desc';
        $perPage = min(max((int) $request->query('per_page', 25), 10), 100);

        $query = DB::table($table);

        if ($search !== '') {
            $query->where(function ($sub) use ($columnNames, $search) {
                foreach ($columnNames as $column) {
                    $sub->orWhere($column, 'like', '%'.$search.'%');
                }
            });
        }

        if (in_array($sort, $columnNames, true)) {
            $query->orderBy($sort, $direction);
        } elseif ($primaryKey !== null) {
            $query->orderByDesc($primaryKey);
        } elseif ($columnNames !== []) {
            $query->orderBy($columnNames[0]);
        }

        $rows = $query->paginate($perPage)->withQueryString();

        return view('admin.database.table', [
            'table' => $table,
            'tables' => collect($this->tableNames())->sort(SORT_NATURAL)->values(),
            'columns' => $columns,
            'columnNames' => $columnNames,
            'primaryKey' => $primaryKey,
            'rows' => $rows,
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
            'adminActive' => 'database',
        ]);
    }

    public function store(string $locale, Request $request, string $table)
    {
        $this->abortIfUnknownTable($table);

        $columns = $this->columns($table);
        $payload = $this->payloadFromRequest($request, $columns, true);

        if ($payload === []) {
            return back()->withErrors(['database' => 'Aucune valeur à enregistrer.'])->withInput();
        }

        try {
            DB::table($table)->insert($payload);
        } catch (QueryException $exception) {
            return back()
                ->withErrors(['database' => $this->queryErrorMessage($exception)])
                ->withInput();
        }

        return redirect()
            ->route('admin.database.table', ['table' => $table])
            ->with('ok', 'Ligne ajoutée dans la table '.$table.'.');
    }

    public function update(string $locale, Request $request, string $table, string $record)
    {
        $this->abortIfUnknownTable($table);

        $columns = $this->columns($table);
        $primaryKey = $this->primaryKeyFromColumns($columns);
        abort_unless($primaryKey !== null, 422, 'Cette table ne possède pas de clé primaire simple.');

        $payload = $this->payloadFromRequest($request, $columns, false, $primaryKey);

        if ($payload === []) {
            return back()->withErrors(['database' => 'Aucune valeur à modifier.'])->withInput();
        }

        try {
            DB::table($table)->where($primaryKey, $record)->update($payload);
        } catch (QueryException $exception) {
            return back()
                ->withErrors(['database' => $this->queryErrorMessage($exception)])
                ->withInput();
        }

        return redirect()
            ->route('admin.database.table', ['table' => $table])
            ->with('ok', 'Ligne mise à jour dans la table '.$table.'.');
    }

    public function destroy(string $locale, string $table, string $record)
    {
        $this->abortIfUnknownTable($table);

        $columns = $this->columns($table);
        $primaryKey = $this->primaryKeyFromColumns($columns);
        abort_unless($primaryKey !== null, 422, 'Cette table ne possède pas de clé primaire simple.');

        try {
            DB::table($table)->where($primaryKey, $record)->delete();
        } catch (QueryException $exception) {
            return back()->withErrors(['database' => $this->queryErrorMessage($exception)]);
        }

        return redirect()
            ->route('admin.database.table', ['table' => $table])
            ->with('ok', 'Ligne supprimée de la table '.$table.'.');
    }

    private function abortIfUnknownTable(string $table): void
    {
        abort_unless(in_array($table, $this->tableNames(), true), 404);
    }

    private function tableNames(): array
    {
        $driver = DB::connection()->getDriverName();

        return match ($driver) {
            'sqlite' => collect(DB::select("select name from sqlite_master where type = 'table' and name not like 'sqlite_%' order by name"))
                ->pluck('name')
                ->map(fn ($name) => (string) $name)
                ->values()
                ->all(),
            'mysql' => collect(DB::select("select table_name as name from information_schema.tables where table_schema = database() and table_type = 'BASE TABLE' order by table_name"))
                ->pluck('name')
                ->map(fn ($name) => (string) $name)
                ->values()
                ->all(),
            'pgsql' => collect(DB::select("select tablename as name from pg_catalog.pg_tables where schemaname = current_schema() order by tablename"))
                ->pluck('name')
                ->map(fn ($name) => (string) $name)
                ->values()
                ->all(),
            default => $this->fallbackTableNames(),
        };
    }

    private function fallbackTableNames(): array
    {
        try {
            return collect(Schema::getConnection()->getSchemaBuilder()->getTables())
                ->pluck('name')
                ->map(fn ($name) => (string) $name)
                ->filter()
                ->values()
                ->all();
        } catch (Throwable) {
            return [];
        }
    }

    private function columns(string $table): array
    {
        $driver = DB::connection()->getDriverName();

        $columns = match ($driver) {
            'sqlite' => collect(DB::select('pragma table_info('.$this->quoteIdentifier($table).')'))
                ->map(fn ($column) => [
                    'name' => (string) $column->name,
                    'type' => (string) ($column->type ?: 'text'),
                    'nullable' => ! (bool) $column->notnull,
                    'default' => $column->dflt_value,
                    'primary' => ((int) $column->pk) > 0,
                    'auto_increment' => ((int) $column->pk) > 0 && strtolower((string) $column->type) === 'integer',
                ]),
            'mysql' => collect(DB::select(
                "select
                    column_name as name,
                    data_type as type,
                    column_type as full_type,
                    is_nullable as nullable_value,
                    column_default as default_value,
                    column_key as key_value,
                    extra as extra_value
                from information_schema.columns
                where table_schema = database() and table_name = ?
                order by ordinal_position",
                [$table]
            ))->map(fn ($column) => [
                'name' => (string) $column->name,
                'type' => (string) ($column->full_type ?: $column->type),
                'nullable' => strtoupper((string) $column->nullable_value) === 'YES',
                'default' => $column->default_value,
                'primary' => strtoupper((string) $column->key_value) === 'PRI',
                'auto_increment' => str_contains(strtolower((string) $column->extra_value), 'auto_increment'),
            ]),
            'pgsql' => collect(DB::select(
                "select c.column_name as name, c.data_type as type, c.is_nullable as nullable_value, c.column_default as default_value,
                    exists (
                        select 1
                        from information_schema.table_constraints tc
                        join information_schema.key_column_usage kcu
                          on tc.constraint_name = kcu.constraint_name
                         and tc.table_schema = kcu.table_schema
                        where tc.constraint_type = 'PRIMARY KEY'
                          and tc.table_schema = c.table_schema
                          and tc.table_name = c.table_name
                          and kcu.column_name = c.column_name
                    ) as is_primary
                from information_schema.columns c
                where c.table_schema = current_schema() and c.table_name = ?
                order by c.ordinal_position",
                [$table]
            ))->map(fn ($column) => [
                'name' => (string) $column->name,
                'type' => (string) ($column->type ?: 'text'),
                'nullable' => strtoupper((string) $column->nullable_value) === 'YES',
                'default' => $column->default_value,
                'primary' => (bool) $column->is_primary,
                'auto_increment' => str_contains(strtolower((string) $column->default_value), 'nextval('),
            ]),
            default => collect($this->columnNames($table))->map(fn (string $column) => [
                'name' => $column,
                'type' => 'text',
                'nullable' => true,
                'default' => null,
                'primary' => $column === 'id',
                'auto_increment' => $column === 'id',
            ]),
        };

        return $columns->values()->all();
    }

    private function columnNames(string $table): array
    {
        try {
            return Schema::getColumnListing($table);
        } catch (Throwable) {
            return collect($this->columns($table))->pluck('name')->all();
        }
    }

    private function primaryKey(string $table): ?string
    {
        return $this->primaryKeyFromColumns($this->columns($table));
    }

    private function primaryKeyFromColumns(array $columns): ?string
    {
        $primaryColumns = collect($columns)
            ->where('primary', true)
            ->pluck('name')
            ->values();

        if ($primaryColumns->count() === 1) {
            return (string) $primaryColumns->first();
        }

        return collect($columns)->contains(fn (array $column) => $column['name'] === 'id') ? 'id' : null;
    }

    private function payloadFromRequest(Request $request, array $columns, bool $isInsert, ?string $primaryKey = null): array
    {
        $values = $request->input('values', []);
        if (! is_array($values)) {
            return [];
        }

        $payload = [];

        foreach ($columns as $column) {
            $name = $column['name'];

            if (! array_key_exists($name, $values)) {
                continue;
            }

            if (! $isInsert && $name === $primaryKey) {
                continue;
            }

            if ($isInsert && (bool) ($column['auto_increment'] ?? false) && trim((string) $values[$name]) === '') {
                continue;
            }

            $payload[$name] = $this->normalizeValue($values[$name], (bool) ($column['nullable'] ?? true));
        }

        return $payload;
    }

    private function normalizeValue(mixed $value, bool $nullable): mixed
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        if (is_string($value)) {
            $value = trim($value);
        }

        if ($nullable && $value === '') {
            return null;
        }

        return $value;
    }

    private function safeCount(string $table): ?int
    {
        try {
            return DB::table($table)->count();
        } catch (Throwable) {
            return null;
        }
    }

    private function quoteIdentifier(string $identifier): string
    {
        return '"'.str_replace('"', '""', $identifier).'"';
    }

    private function queryErrorMessage(QueryException $exception): string
    {
        return 'Opération impossible : '.$exception->getMessage();
    }
}
