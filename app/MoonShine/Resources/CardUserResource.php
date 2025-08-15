<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Card;
use App\Models\User;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Select;

class CardUserResource extends ModelResource
{
    protected string $model = Card::class;

    protected string $title = 'Ваши карты';

    // Только просмотр
    protected function indexFields(): iterable
    {
        return [
            ID::make(),
            Select::make('User', 'user_id')
                ->options(User::pluck('name','id')->toArray())
                ->readonly(),
            Text::make('Number', 'number')->readonly(),
            Select::make('Status', 'status')->options([
                'in_delivery' => 'In Delivery',
                'active' => 'Active',
                'blocked' => 'Blocked',
                'expired' => 'Expired',
            ])->readonly(),
        ];
    }

    protected function formFields(): iterable
    {
        return []; // запрещаем редактирование
    }

    protected function detailFields(): iterable
    {
        return $this->indexFields();
    }
}
