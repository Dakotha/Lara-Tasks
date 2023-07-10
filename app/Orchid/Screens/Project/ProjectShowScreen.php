<?php

namespace App\Orchid\Screens\Project;

use App\Models\Project;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use App\Orchid\Layouts\Task\TaskShowLayout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProjectShowScreen extends Screen
{
    public $project;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Project $project): iterable
    {
        return [
            'project' => $project,
            'tasks' => Task::where(['project_id' => $project->id])->latest()->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __($this->project->title);
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make(__('Dodaj nowe zadanie'))
                ->icon('plus-circle')
                ->modal('createTask')
                ->method('create'),
            Link::make(__('Edytuj'))
                ->icon('pencil')
                ->route('platform.projects.edit', $this->project),
            Button::make(__('Zamknij'))
                ->icon('key')
                ->method('close')
                ->confirm(__('Czy na pewno zamknąć projekt?')),
            Button::make(__('Usuń'))
                ->icon('trash')
                ->method('destroy')
                ->confirm(__('Czy na pewno usunąć projekt?')),
            Link::make(__('Powrót'))
                ->icon('arrow-left')
                ->route('platform.projects.list')
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
            Layout::tabs([
                'Projekt' => [
                    Layout::legend('project', [
                        Sight::make('description', __('Opis'))
                            ->render(function ($project) {
                                return $project->description;
                            }),
                        Sight::make('created_at', __('Data rozpoczęcia'))
                            ->render(function ($project) {
                                return Carbon::createFromFormat('Y-m-d H:i:s', $project->created_at)->format('Y-m-d');
                            }),
                        Sight::make('end_at', __('Data zakończenia'))
                            ->render(function ($project) {
                                return $project->end_at ? Carbon::createFromFormat('Y-m-d H:i:s', $project->end_at)->format('Y-m-d') : __('W realizacji');
                            }),
                    ]),
                ],
                'Zadania' => [
                    TaskShowLayout::class
                ],
            ]),

            Layout::modal('createTask', Layout::rows([
                Input::make('title')
                    ->title(__('Nazwa'))
                    ->placeholder(__('Podaj nazwę zadania...')),
                Quill::make('description')
                    ->title(__('Opis'))
                    ->placeholder(__('Podaj opis zadania...')),
                Relation::make('status_id')
                    ->title(__('Status'))
                    ->fromModel(Status::class, 'name'),
                Relation::make('user_id')
                    ->title(__('Użytkownik'))
                    ->fromModel(User::class, 'name')
            ]))
                ->title(__('Dodaj nowe zadanie'))
                ->size(Modal::SIZE_LG)
                ->applyButton(__('Zapisz'))
                ->closeButton(__('Zamknij')),
        ];
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3',
            'status_id' => 'required',
            'user_id' => 'required'
        ]);
    
        $task = new Task();

        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->status_id = $request->input('status_id');
        $task->user_id = $request->input('user_id');
        $task->project_id = $this->project->id;
        $task->close_at = null;
        $task->save();

        Toast::info(__('Zapisałeś nowe zadanie.'));
    }
    
    public function destroy()
    {
        $this->project->delete();

        Toast::info(__('Usunąłeś projekt.'));

        return redirect()->route('platform.projects.list');
    }

    public function close()
    {
        $this->project->close_at = now();
        $this->project->save();

        Toast::info(__('Zamknąłeś projekt.'));
        
        return redirect()->route('platform.projects.list');
    }

    public function open($id)
    {
        $task = Task::find($id);
        $task->close_at = null;
        
        $task->save();

        Toast::info(__('Otworzyłeś zadanie.'));
    }
}
