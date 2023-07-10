<?php

namespace App\Orchid\Screens\Project;

use App\Models\Project;
use App\Orchid\Layouts\Project\ProjectEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProjectEditScreen extends Screen
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
            'project' => $project
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->project->exists ? __('Edytuj projekt') : __('Dodaj nowy projekt');
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
                ->method('createOrUpdate'),
            Button::make(__('Zamknij'))
                ->icon('key')
                ->method('close')
                ->confirm(__('Czy na pewno zamknąć projekt?'))
                ->canSee($this->project->exists),
            Button::make(__('Usuń'))
                ->icon('trash')
                ->method('destroy')
                ->confirm(__('Czy na pewno usunąć projekt?'))
                ->canSee($this->project->exists),
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
            ProjectEditLayout::class
        ];
    }

    public function createOrUpdate(Request $request)
    {
        $request->validate([
            'project.title' => 'required|min:3|max:255',
            'project.description' => 'required|min:3'
        ]);

        $this->project->title = $request->input('project.title');
        $this->project->description = $request->input('project.description');
        $this->project->save();

        Toast::info(__('Zapisałeś nowy projekt.'));
        
        return redirect()->route('platform.projects.list');
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
        $this->project->update();

        Toast::info(__('Zamknąłeś projekt.'));
        
        return redirect()->route('platform.projects.list');
    }
}
