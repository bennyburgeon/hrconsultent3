<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\FavouriteCompany;

class FavouriteCompanyTable extends LivewireTableComponent
{
    protected $model = FavouriteCompany::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setThAttributes(function (Column $column) {
            return [
                'class' => 'text-center',
            ];
        });

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '4') {
                return [
                    'class' => 'text-center',
                    'width' => '14%'
                ];
            }
            return [];
        });


//        $this->setTableAttributes([
//            'default' => false,
//            'class' => 'table table-default',
//        ]);

        $this->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.company.name'), "company.user.first_name")
                ->sortable()
                ->searchable()
                ->view('candidate.favourite_companies.table_components.name'),

            Column::make(__('messages.company.offices'), "company.no_of_offices")
                ->sortable()
                ->searchable()
                ->view('candidate.favourite_companies.table_components.offices'),

            Column::make(__('messages.user.phone'), "company.user.phone")
                ->sortable()
                ->searchable()
                ->view('candidate.favourite_companies.table_components.phone'),

            Column::make(__('messages.company.industry'), "company.industry.name")
                ->sortable()
                ->searchable()
                ->view('candidate.favourite_companies.table_components.industry'),

            Column::make(__('messages.common.action'), "id")
                ->view('candidate.favourite_companies.table_components.action_button'),
        ];
    }
    public function builder(): Builder
    {
        $query = FavouriteCompany::with(['company.user', 'company.industry'])->where('favourite_companies.user_id',
            getLoggedInUserId())->select('favourite_companies.*');

        return $query;
    }
}
