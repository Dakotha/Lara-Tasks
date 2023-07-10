<?php

namespace App\Orchid\Layouts\Task;

use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TaskShowLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'tasks';

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
                ->render(function ($task) {
                    return Link::make($task->title)->route('platform.tasks.show', $task);
                }),
            TD::make('description', __('Opis'))
                ->render(function ($task) {
                    return substr($task->description, 0, 100);
                })->defaultHidden(),
            TD::make('status_id', __('Status'))
                ->sort()
                ->filter(Input::make())
                ->render(function ($task) {
                    return $task->status->name;
                }),
            TD::make('created_at', __('Utworzone'))
                ->sort()
                ->filter(Input::make())
                ->render(function ($task) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $task->created_at)->format('Y-m-d');
                }),
            TD::make('close_at', __('Zamknięte'))
                ->sort()
                ->filter(Input::make())
                ->render(function ($task) {
                    return $task->close_at ? Carbon::createFromFormat('Y-m-d H:i:s', $task->close_at)->format('Y-m-d') : __('W realizacji');
                }),
            TD::make()
                ->alignRight()
                ->width('100px')
                ->render(function ($task) {
                    return $task->close_at ? '' : Link::make(__('Pokaż'))->route('platform.tasks.show', $task);
                }),
            TD::make()
                ->alignRight()
                ->width('100px')
                ->render(function ($task) {
                    return $task->close_at ? Button::make(__('Otwórz'))->method('open', ['id' => $task->id]) : Link::make(__('Edytuj'))->route('platform.tasks.edit', $task);
                })
        ];
    }
}
