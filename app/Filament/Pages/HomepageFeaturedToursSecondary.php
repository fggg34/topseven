<?php

namespace App\Filament\Pages;

use App\Models\HomepageSecondarySpotlightTour;
use App\Models\Tour;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
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
class HomepageFeaturedToursSecondary extends Page
{
    /** @var array<string, mixed> */
    public array $form = [];

    protected static ?string $slug = 'homepage/featured-tours-2';

    protected static ?string $navigationLabel = 'Featured tours 2';

    protected static ?string $navigationParentItem = 'Homepage';

    protected static string|\UnitEnum|null $navigationGroup = 'Pages';

    protected static ?int $navigationSort = 52;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $title = 'Homepage featured tours (Section 2)';

    protected string $view = 'filament.pages.settings';

    public function mount(): void
    {
        $rows = HomepageSecondarySpotlightTour::query()
            ->orderBy('sort_order')
            ->pluck('tour_id')
            ->map(fn (int|string $id) => ['tour_id' => (int) $id])
            ->all();

        $this->getSchema('form')->fill([
            'tours' => $rows,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('form')
            ->components([
                Section::make('Tours on the homepage (Section 2)')
                    ->description('Add a row for each tour and drag to set the slider order for the second tours section.')
                    ->schema([
                        Repeater::make('tours')
                            ->label('Tours')
                            ->schema([
                                Select::make('tour_id')
                                    ->label('Tour')
                                    ->options(fn (): array => Tour::query()
                                        ->where('is_active', true)
                                        ->orderBy('title')
                                        ->pluck('title', 'id')
                                        ->all())
                                    ->searchable()
                                    ->required()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->native(false),
                            ])
                            ->reorderable()
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add tour')
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
        $rows = $data['tours'] ?? [];

        DB::transaction(function () use ($rows): void {
            HomepageSecondarySpotlightTour::query()->delete();

            $order = 1;
            $seen = [];

            foreach ($rows as $row) {
                $tourId = (int) ($row['tour_id'] ?? 0);
                if ($tourId < 1 || isset($seen[$tourId])) {
                    continue;
                }
                $seen[$tourId] = true;

                HomepageSecondarySpotlightTour::query()->create([
                    'tour_id' => $tourId,
                    'sort_order' => $order++,
                ]);
            }
        });

        Notification::make()
            ->title('Homepage tours (Section 2) saved.')
            ->success()
            ->send();
    }
}
