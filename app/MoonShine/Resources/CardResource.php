<?php

namespace App\MoonShine\Resources;

use App\Models\Card;
use App\Models\User;
use App\Models\CardTransaction;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;

class CardResource extends ModelResource
{
    protected string $model = Card::class;
    protected string $title = 'Карты';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Select::make('Пользователь', 'user_id')
                ->options(User::pluck('name', 'id')->toArray()),
            Text::make('Номер', 'number'),
            Number::make('Баланс', 'balance')->sortable(),
            Select::make('Статус', 'status')->options([
                'creating' => 'Создаётся',
                'in_delivery' => 'В доставке',
                'active' => 'Активна',
                'blocked' => 'Заблокирована',
                'expired' => 'Истекла',
            ]),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                Select::make('Пользователь', 'user_id')
                    ->options(User::pluck('name', 'id')->toArray()),
                Text::make('Номер', 'number'),
                Number::make('Баланс', 'balance'),
                Select::make('Статус', 'status')->options([
                    'creating' => 'Создаётся',
                    'in_delivery' => 'В доставке',
                    'active' => 'Активна',
                    'blocked' => 'Заблокирована',
                    'expired' => 'Истекла',
                ]),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return $this->indexFields();
    }

    protected function rules(mixed $item): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'number' => ['required', 'unique:cards,number,' . ($item->id ?? 'null')],
            'status' => ['required', 'in:creating,in_delivery,active,blocked,expired'],
            'balance' => ['required', 'numeric'],
        ];
    }
}
