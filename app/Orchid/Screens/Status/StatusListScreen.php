<?php

namespace App\Orchid\Screens\Status;

use App\Models\Status;
use App\Orchid\Layouts\Status\StatusListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class StatusListScreen extends Screen
{
    public $stat;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Status $status): iterable
    {
        return [
            'status' => Status::latest()->paginate(10),
            'stat' => $status
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Lista statusów');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make(__('Dodaj nowy status'))->icon('plus-circle')->modal('addStatus')->method('create')
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
            StatusListLayout::class,

            Layout::modal('addStatus', [
                Layout::rows([
                    Input::make('name')
                        ->title(__('Nazwa'))
                        ->placeholder(__('Podaj nazwę statusu...')),
                ])
            ])
                ->title(__('Dodaj nowy status'))
                ->applyButton(__('Zapisz'))
                ->closeButton(__('Zamknij')),

            Layout::modal('editStatus', [
                Layout::rows([
                    Input::make('name')
                        ->title(__('Nazwa'))
                ])
            ])
                ->title(__('Edytuj status'))
                ->applyButton(__('Zapisz'))
                ->closeButton(__('Zamknij'))
        ];
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
        ]);
    
        $status = new Status();

        $status->name = $request->input('name');
        $status->save();

        Toast::info(__('Zapisałeś nowy status.'));
    }

    public function update()
    {
        return ;
    }
}
