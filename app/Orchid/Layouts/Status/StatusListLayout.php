<?php

namespace App\Orchid\Layouts\Status;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class StatusListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'status';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', __('Lp.')),
            TD::make('name', __('Nazwa'))
                ->sort()
                ->filter(Input::make()),
            TD::make()
                ->alignRight()
                ->width('100px')
                ->render(function ($status) {
                    return Link::make(__('Edytuj'))->route('platform.status.edit', $status);
                }),
        ];
    }
}
