<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\User;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Email;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;

/**
 * @extends ModelResource<User>
 */
class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Users';

    // ===== Поля на странице списка =====
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Name', 'name'),
            Email::make('Email', 'email'),
        ];
    }

    // ===== Поля на форме создания/редактирования =====
    protected function formFields(): iterable
    {
        return [
            Box::make([
                Text::make('Name', 'name'),
                Email::make('Email', 'email'),
            ])
        ];
    }

    // ===== Поля на странице просмотра =====
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Name', 'name'),
            Email::make('Email', 'email'),
        ];
    }

    // ===== Правила валидации =====
    protected function rules(mixed $item): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . ($item->id ?? 'null')],
        ];
    }
}
