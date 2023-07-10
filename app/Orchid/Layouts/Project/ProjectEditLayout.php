<?php

namespace App\Orchid\Layouts\Project;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;

class ProjectEditLayout extends Rows
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
            Input::make('project.title')
                ->title(__('Nazwa'))
                ->placeholder(__('Podaj nazwę projektu...')),
            Quill::make('project.description')
                ->title(__('Opis'))
                ->placeholder(__('Podaj opis projektu...'))
        ];
    }
}
