<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Filament\Resources\ActivityResource\RelationManagers;
use App\Models\NavigationItem;
use App\Models\Scopes\ActiveScope;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Activitylog\Models\Activity;
use App\Services\NavigationService;
use Filament\Tables\Filters\TrashedFilter;


class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $slug = 'user-activities';

    public static function getModelLabel(): string
    {
        return __(self::$slug . '.model-label');
    }

    public static function getPluralModelLabel(): string
    {
        return __(self::$slug . '.plural-model-label');
    }

    public static function getNavigationLabel(): string
    {
        return __(self::$slug . '.navigation-label');
    }

    public static function getNavigationGroup(): ?string
    {
        $navigationService = new NavigationService;
        $navigationGroupSlug = $navigationService->getNavigationGroupSlug(self::$slug);
        return __('navigation.'.$navigationGroupSlug);
    }

    public static function getNavigationSort(): ?int
    {
        $navigationService = new NavigationService;
        $navigationSort = $navigationService->getNavigationSort(self::$slug);
        return $navigationSort;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereIn('log_name', ['Access', 'Resource']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        // Forms\Components\TextInput::make('causer_id')
                        //     ->label(__(self::$slug . '.form.causer_id')),
                        Forms\Components\Fieldset::make()
                            ->relationship('causer')
                            ->schema([
                                Forms\Components\TextInput::make('id')
                                    ->label(__(self::$slug . '.form.causer_id')),
                                Forms\Components\TextInput::make('last_name')
                                    ->label(__(self::$slug . '.form.last_name')),
                                Forms\Components\TextInput::make('first_name')
                                    ->label(__(self::$slug . '.form.first_name')),
                            ])
                            ->extraAttributes(['style' => 'border: none; padding-left: 0; padding-right: 0;'])
                            ->columns(3),
                        Forms\Components\TextInput::make('description')
                            ->label(__(self::$slug . '.form.description')),
                        // Forms\Components\TextInput::make('causer_type')
                        //     ->label(__(self::$slug.'.form.causer_type')),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->format('d/m/Y H:i:s')
                            ->label(__(self::$slug . '.form.created_at')),
                        Forms\Components\DateTimePicker::make('updated_at')
                            ->format('d/m/Y H:i:s')
                            ->label(__(self::$slug . '.form.updated_at')),
                        Forms\Components\KeyValue::make('properties')
                            ->columnSpanFull()
                            ->label(__(self::$slug . '.form.properties')),
                    ])
                    ->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('log_name')
                    ->sortable()
                    ->searchable()
                    ->label(__(self::$slug . '.table.log_name')),
                Tables\Columns\TextColumn::make('event')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->label(__(self::$slug . '.table.event')),
                Tables\Columns\TextColumn::make('causer_id')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->label(__(self::$slug . '.table.causer_id')),
                Tables\Columns\TextColumn::make('causer.first_name')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->label(__(self::$slug . '.table.first_name')),
                Tables\Columns\TextColumn::make('causer.last_name')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->label(__(self::$slug . '.table.last_name')),
                Tables\Columns\TextColumn::make('description')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->label(__(self::$slug . '.table.description')),
                // Tables\Columns\TextColumn::make('causer_type')
                //     ->label(__(self::$slug.'.table.causer_type')),
                Tables\Columns\TextColumn::make('properties')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->label(__(self::$slug . '.table.properties')),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->searchable()
                    ->dateTime('d/m/Y H:i:s')
                    ->label(__(self::$slug . '.table.created_at')),
            ])
            ->filters([
                SelectFilter::make('log_name')
                    ->label(__(self::$slug . '.filter.log_name'))
                    ->options([
                        'Access' => 'Access',
                        'Resource' => 'Resource',
                    ])
            ])
            ->actions([
                //Tables\Actions\EditAction::make()->iconButton()->size(ActionSize::Large),
                Tables\Actions\ViewAction::make()->iconButton()->size(ActionSize::Large),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListActivities::route('/'),
            'view' => Pages\ViewActivity::route('/{record}'),
            //'create' => Pages\CreateActivity::route('/create'),
            //'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
