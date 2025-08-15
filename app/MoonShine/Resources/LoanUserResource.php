<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Loan;
use App\Models\User;
use App\Models\Card;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;

class LoanUserResource extends ModelResource
{
    protected string $model = Loan::class;

    protected string $title = 'Ваши кредиты';

    protected function indexFields(): iterable
    {
        return [
            ID::make(),
            Select::make('User', 'user_id')->options(User::pluck('name','id')->toArray())->readonly(),
            Select::make('Card', 'card_id')->options(Card::pluck('number','id')->toArray())->readonly(),
            Number::make('Amount', 'amount')->readonly(),
            Number::make('Term', 'term')->readonly(),
            Select::make('Status', 'status')->options([
                'active'=>'Active',
                'closed'=>'Closed',
                'overdue'=>'Overdue',
            ])->readonly(),
        ];
    }

    protected function formFields(): iterable
    {
        return [];
    }

    protected function detailFields(): iterable
    {
        return $this->indexFields();
    }
}
