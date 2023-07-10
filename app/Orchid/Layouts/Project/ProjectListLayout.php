<?php

namespace App\Orchid\Layouts\Project;

use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProjectListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'projects';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('title', __('Nazwa'))
                ->sort()
                ->filter(Input::make())
                ->render(function ($project) {
                    return Link::make($project->title)->route('platform.projects.show', $project);
                }),
            TD::make('description', __('Opis'))
                ->render(function ($project) {
                    return substr($project->description, 0, 100);
                })->defaultHidden(),
            TD::make('created_at', __('Utworzony'))
                ->sort()
                ->filter(Input::make())
                ->render(function ($project) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $project->created_at)->format('Y-m-d');
                }),
            TD::make('close_at', __('Zamknięty'))
                ->sort()
                ->filter(Input::make())
                ->render(function ($project) {
                    return $project->close_at ? Carbon::createFromFormat('Y-m-d H:i:s', $project->close_at)->format('Y-m-d') : __('W realizacji');
                }),
            TD::make()
                ->alignRight()
                ->width('100px')
                ->render(function ($project) {
                    return $project->close_at ? '' : Link::make(__('Pokaż'))->route('platform.projects.show', $project);
                }),
            TD::make()
                ->alignRight()
                ->width('100px')
                ->render(function ($project) {
                    return $project->close_at ? Button::make(__('Otwórz'))->method('open', ['id' => $project->id]) : Link::make(__('Edytuj'))->route('platform.projects.edit', $project);
                })
        ];
    }
}
