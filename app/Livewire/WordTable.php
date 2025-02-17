<?php

namespace App\Livewire;

use App\Models\Word;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class WordTable extends PowerGridComponent
{

    public string $tableName = 'word-table-rggimm-table';
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::exportable('word')
                ->striped()
                ->columnWidth([
                    2 => 30,
                ])
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount()
        ];
    }

    public function datasource(): Builder
    {
        return Word::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('word')
            ->add('created_at_formatted', function ($dish) {
                return Carbon::parse($dish->created_at)->format('M d, Y'); //20/01/2024 10:05
            })
            ->add('created_at');;
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->visibleInExport(visible: true),
            Column::make('Word', 'word')
                ->sortable()
                ->searchable()
                ->visibleInExport(visible: true),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable()
                ->visibleInExport(visible: true),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('created_at_formatted', 'created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function actions(Word $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: ' . $row->id)
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id]),
            Button::add('view')
                ->slot('View: ' . $row->id)
                ->class('')
                ->route('word.view', ['id' => $row->id]) // Route to the view page
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
