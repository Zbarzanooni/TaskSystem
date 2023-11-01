<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                TextInput::make('title'),
                Select::make('status')
                    ->options(Task::STATUS),
                Select::make('priority')
                    ->options(Task::PRIORITY),
                Textarea::make('description'),
                Textarea::make('comment'),
                Select::make('assigned_to')
                    ->relationship(name: 'assignedTo', titleAttribute: 'name')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                IconColumn::make('status')
                    ->icon(fn (string $state): string => match ($state) {
                        Task::STATUS['open']     => 'heroicon-s-lock-open',
                        Task::STATUS['closed']   => 'heroicon-s-lock-closed',
                        Task::STATUS['archived'] => 'heroicon-s-archive-box-arrow-down',

                    }),
                IconColumn::make('priority')
                    ->icon(fn (string $state): string => match ($state) {
                        Task::PRIORITY['low']    => 'healthicons-o-low-level',
                        Task::PRIORITY['medium'] => 'healthicons-f-medium-level',
                        Task::PRIORITY['high']   => 'healthicons-o-high-level',

                    })
                ->color(fn (string $state): string => match ($state) {
                    Task::PRIORITY['low']    => 'info',
                    Task::PRIORITY['medium'] => 'warning',
                    Task::PRIORITY['high']   => 'danger',
                    }),
                TextColumn::make('assignedTo.name')

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
