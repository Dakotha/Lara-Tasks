<?php

namespace App\Orchid\Layouts\Task;

use App\Models\Status;
use App\Models\User;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class TaskEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('task.title')
                ->title(__('Nazwa'))
                ->placeholder(__('Podaj nazwę zadania...')),
            Quill::make('task.description')
                ->title(__('Opis'))
                ->placeholder(__('Podaj opis zadania...')),
            Relation::make('task.status_id')
                ->title(__('Status'))
                ->fromModel(Status::class, 'name'),
            Relation::make('task.user_id')
                ->title(__('Użytkownik'))
                ->fromModel(User::class, 'name')
        ];
    }
}
