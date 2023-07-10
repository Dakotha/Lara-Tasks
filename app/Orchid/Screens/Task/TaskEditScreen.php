<?php

namespace App\Orchid\Screens\Task;

use App\Models\Task;
use App\Orchid\Layouts\Task\TaskEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class TaskEditScreen extends Screen
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
            Button::make(__('Zapisz'))
                ->icon('pencil')
                ->method('update'),
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
            TaskEditLayout::class
        ];
    }

    public function update(Request $request)
    {
        $request->validate([
            'task.title' => 'required|min:3|max:255',
            'task.description' => 'required|min:3',
            'task.status_id' => 'required',
            'task.user_id' => 'required'
        ]);
    
        $this->task->title = $request->input('task.title');
        $this->task->description = $request->input('task.description');
        $this->task->status_id = $request->input('task.status_id');
        $this->task->user_id = $request->input('task.user_id');
        $this->task->project_id = $this->task->project_id;
        $this->task->close_at = null;
        $this->task->save();

        Toast::info(__('Uaktualniłeś zadanie.'));

        return redirect()->route('platform.projects.show', $this->task->project_id);
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
