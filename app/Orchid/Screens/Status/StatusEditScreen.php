<?php

namespace App\Orchid\Screens\Status;

use App\Models\Status;
use App\Orchid\Layouts\Status\StatusEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class StatusEditScreen extends Screen
{
    public $status;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Status $status): iterable
    {
        return [
            'status' => $status
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Edytuj status');
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
            Button::make(__('Usuń'))
                ->icon('trash')
                ->method('destroy')
                ->confirm(__('Czy na pewno usunąć status?')),
            Link::make(__('Powrót'))
                ->icon('arrow-left')
                ->route('platform.status.list')
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
            StatusEditLayout::class
        ];
    }

    public function update(Request $request)
    {
        $request->validate([
            'status.name' => 'required|min:3|max:255'
        ]);

        $this->status->name = $request->input('status.name');
        $this->status->update();

        Toast::info(__('Uaktualniłeś status.'));
        
        return redirect()->route('platform.status.list');
    }

    public function destroy()
    {
        $this->status->delete();

        Toast::info(__('Usunąłeś status.'));

        return redirect()->route('platform.status.list');
    }
}
