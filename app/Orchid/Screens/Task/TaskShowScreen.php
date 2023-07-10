<?php

namespace App\Orchid\Screens\Task;

use App\Models\Task;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TaskShowScreen extends Screen
{
    public $task;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Task $task): iterable
    {
        return [
            'task' => $task
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __($this->task->title);
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Edytuj'))
                ->icon('pencil')
                ->route('platform.tasks.edit', $this->task),
            Button::make(__('Zamknij'))
                ->icon('key')
                ->method('close')
                ->confirm(__('Czy na pewno zamknąć zadanie?')),
            Button::make(__('Usuń'))
                ->icon('trash')
                ->method('destroy')
                ->confirm(__('Czy na pewno usunąć zadanie?')),
            Link::make(__('Powrót'))
                ->icon('arrow-left')
                ->route('platform.projects.show', $this->task->project_id)
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::legend('task', [
                Sight::make('description', __('Opis'))
                    ->render(function ($task) {
                        return $task->description;
                    }),
                Sight::make('project_id', __('Projekt'))
                    ->render(function ($task) {
                        return $task->project->title;
                    }),
                Sight::make('user_id', __('Użytkownik'))
                    ->render(function ($task) {
                        return $task->user->name;
                    }),
                Sight::make('created_at', __('Data rozpoczęcia'))
                    ->render(function ($task) {
                        return Carbon::createFromFormat('Y-m-d H:i:s', $task->created_at)->format('Y-m-d');
                    }),
                Sight::make('end_at', __('Data zakończenia'))
                    ->render(function ($task) {
                        return $task->end_at ? Carbon::createFromFormat('Y-m-d H:i:s', $task->end_at)->format('Y-m-d') : __('W realizacji');
                    })
            ]),
        ];
    }

    public function close()
    {
        $this->task->close_at = now();
        $this->task->update();

        Toast::info(__('Zamknąłeś zadanie.'));
        
        return redirect()->route('platform.projects.show', $this->task->project_id);
    }

    public function destroy()
    {
        $this->task->delete();

        Toast::info(__('Usunąłeś zadanie.'));

        return redirect()->route('platform.projects.show', $this->task->project_id);
    }
}
