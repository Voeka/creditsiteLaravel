<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Loan;
use App\Models\User;
use App\Models\Card;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;

/**
 * @extends ModelResource<Loan>
 */
class LoanResource extends ModelResource
{
    protected string $model = Loan::class;

    protected string $title = 'Loans';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),

            Select::make('User', 'user_id')
                ->options(User::pluck('name', 'id')->toArray()),

            Select::make('Card', 'card_id')
                ->options(Card::pluck('number', 'id')->toArray()),

            Number::make('Amount', 'amount'),

            Number::make('Term (months)', 'term'),

            Select::make('Status', 'status')->options([
                'active' => 'Active',
                'closed' => 'Closed',
                'overdue' => 'Overdue',
            ]),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                Select::make('User', 'user_id')
                    ->options(User::pluck('name', 'id')->toArray()),

                Select::make('Card', 'card_id')
                    ->options(Card::pluck('number', 'id')->toArray()),

                Number::make('Amount', 'amount'),

                Number::make('Term (months)', 'term'),

                Select::make('Status', 'status')->options([
                    'active' => 'Active',
                    'closed' => 'Closed',
                    'overdue' => 'Overdue',
                ]),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),

            Select::make('User', 'user_id')
                ->options(User::pluck('name', 'id')->toArray()),

            Select::make('Card', 'card_id')
                ->options(Card::pluck('number', 'id')->toArray()),

            Number::make('Amount', 'amount'),

            Number::make('Term (months)', 'term'),

            Select::make('Status', 'status')->options([
                'active' => 'Active',
                'closed' => 'Closed',
                'overdue' => 'Overdue',
            ]),
        ];
    }

    protected function rules(mixed $item): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'card_id' => ['required', 'exists:cards,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'term' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:active,closed,overdue'],
        ];
    }
}
