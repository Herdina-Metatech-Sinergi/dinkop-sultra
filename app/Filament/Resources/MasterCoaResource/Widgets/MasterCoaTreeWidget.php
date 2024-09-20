<?php

namespace App\Filament\Resources\MasterCoaResource\Widgets;

use App\Models\MasterCoa;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use SolutionForest\FilamentTree\Actions\Action;
use SolutionForest\FilamentTree\Actions\ActionGroup;
use SolutionForest\FilamentTree\Actions\DeleteAction;
use SolutionForest\FilamentTree\Actions\EditAction;
use SolutionForest\FilamentTree\Actions\ViewAction;
use SolutionForest\FilamentTree\Widgets\Tree as BaseWidget;

class MasterCoaTreeWidget extends BaseWidget
{
    protected static string $model = MasterCoa::class;

    protected static int $maxDepth = 2;

    protected ?string $treeTitle = 'Master COA';

    protected bool $enableTreeTitle = true;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                    ->maxLength(255)->required(),
            TextInput::make('kode_coa')
                ->maxLength(255)->required(),
            TextInput::make('kelompok')
                ->maxLength(255),
            Select::make('saldo_normal')
                ->options([
                    'Debet' => 'Debet',
                    'Kredit' => 'Kredit',
                ])->required(),
        ];
    }

    // INFOLIST, CAN DELETE
    public function getViewFormSchema(): array {
        return [
            //
        ];
    }

    // CUSTOMIZE ICON OF EACH RECORD, CAN DELETE
    // public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    // {
    //     return null;
    // }

    // CUSTOMIZE ACTION OF EACH RECORD, CAN DELETE
    // protected function getTreeActions(): array
    // {
    //     return [
    //         Action::make('helloWorld')
    //             ->action(function () {
    //                 Notification::make()->success()->title('Hello World')->send();
    //             }),
    //         // ViewAction::make(),
    //         // EditAction::make(),
    //         ActionGroup::make([
    //
    //             ViewAction::make(),
    //             EditAction::make(),
    //         ]),
    //         DeleteAction::make(),
    //     ];
    // }
    // OR OVERRIDE FOLLOWING METHODS
    protected function hasDeleteAction(): bool
    {
       return true;
    }
    protected function hasEditAction(): bool
    {
       return true;
    }
    protected function hasViewAction(): bool
    {
       return true;
    }

    public function getTreeRecordTitle(?\Illuminate\Database\Eloquent\Model $record = null): string
    {
        if (! $record) {
            return '';
        }
        $kode_coa = $record->kode_coa;
        $title = $record->{(method_exists($record, 'determineTitleColumnName') ? $record->determineTitleColumnName() : 'title')};
        return "[{$kode_coa}] {$title}";
    }
}
