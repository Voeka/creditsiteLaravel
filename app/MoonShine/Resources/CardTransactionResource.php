<?php

namespace App\MoonShine\Resources;

use App\Models\CardTransaction;
use App\Models\Card;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;

/**
 * @extends ModelResource<CardTransaction>
 */
class CardTransactionResource extends ModelResource
{
    protected string $model = CardTransaction::class;

    protected string $title = 'Транзакции карт';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),

            Select::make('Карта', 'card_id')
                ->options(Card::pluck('number', 'id')->toArray()),

            Select::make('Тип', 'type')->options([
                'deposit' => 'Пополнение',
                'spend' => 'Трата',
            ]),

            Number::make('Сумма', 'amount'),

            Text::make('Комментарий', 'comment'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Select::make('Карта', 'card_id')
                ->options(Card::pluck('number', 'id')->toArray()),

            Select::make('Тип', 'type')->options([
                'deposit' => 'Пополнение',
                'spend' => 'Трата',
            ]),

            Number::make('Сумма', 'amount'),

            Text::make('Комментарий', 'comment'),
        ];
    }

    protected function rules(mixed $item): array
    {
        return [
            'card_id' => ['required', 'exists:cards,id'],
            'type' => ['required', 'in:deposit,spend'],
            'amount' => ['required', 'numeric'],
        ];
    }
}
