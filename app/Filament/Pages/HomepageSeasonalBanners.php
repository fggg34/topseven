<?php

namespace App\Filament\Pages;

use App\Models\HomepageSeasonalBanner;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;

/**
 * @property-read Schema $form
 */
class HomepageSeasonalBanners extends Page
{
    /** @var array<string, mixed> */
    public array $form = [];

    protected static ?string $slug = 'homepage/seasonal-banners';

    protected static ?string $navigationLabel = 'Seasonal banners';

    protected static ?string $navigationParentItem = 'Homepage';

    protected static string|\UnitEnum|null $navigationGroup = 'Pages';

    protected static ?int $navigationSort = 53;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $title = 'Homepage seasonal banners';

    protected string $view = 'filament.pages.settings';

    public function mount(): void
    {
        $rows = HomepageSeasonalBanner::query()
            ->orderBy('sort_order')
            ->get()
            ->map(fn (HomepageSeasonalBanner $row): array => [
                'background_image' => $row->background_image,
                'title' => $row->title,
                'button_text' => $row->button_text,
                'button_url' => $row->button_url,
                'is_active' => $row->is_active,
            ])
            ->all();

        $this->getSchema('form')->fill([
            'banners' => $rows,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('form')
            ->components([
                Section::make('Seasonal package banners')
                    ->description('Manage the homepage banner slider shown below the second selected tours section.')
                    ->schema([
                        Repeater::make('banners')
                            ->label('Banners')
                            ->schema([
                                FileUpload::make('background_image')
                                    ->label('Background image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('seasonal-banners')
                                    ->visibility('public')
                                    ->required()
                                    ->imagePreviewHeight('140')
                                    ->columnSpanFull(),
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                TextInput::make('button_text')
                                    ->label('Button text')
                                    ->placeholder('Learn More')
                                    ->maxLength(80),
                                TextInput::make('button_url')
                                    ->label('Button URL')
                                    ->placeholder('/tours')
                                    ->maxLength(2048),
                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),
                            ])
                            ->reorderable()
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add banner')
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Save')
                                ->submit('save'),
                        ])->alignment(\Filament\Support\Enums\Alignment::Start),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->getSchema('form')->getState();
        $rows = $data['banners'] ?? [];

        DB::transaction(function () use ($rows): void {
            HomepageSeasonalBanner::query()->delete();

            $order = 1;
            foreach ($rows as $row) {
                $image = trim((string) ($row['background_image'] ?? ''));
                $title = trim((string) ($row['title'] ?? ''));

                if ($image === '' || $title === '') {
                    continue;
                }

                HomepageSeasonalBanner::query()->create([
                    'background_image' => $image,
                    'title' => $title,
                    'button_text' => trim((string) ($row['button_text'] ?? '')) ?: 'Learn More',
                    'button_url' => trim((string) ($row['button_url'] ?? '')) ?: '/tours',
                    'is_active' => (bool) ($row['is_active'] ?? true),
                    'sort_order' => $order++,
                ]);
            }
        });

        Notification::make()
            ->title('Seasonal banners saved.')
            ->success()
            ->send();
    }
}
