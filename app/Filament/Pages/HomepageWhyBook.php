<?php

namespace App\Filament\Pages;

use App\Models\HomepageWhyBookCard;
use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
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
class HomepageWhyBook extends Page
{
    /** @var array<string, mixed> */
    public array $form = [];

    protected static ?string $slug = 'homepage/why-book';

    protected static ?string $navigationLabel = 'Why book with us';

    protected static ?string $navigationParentItem = 'Homepage';

    protected static string|\UnitEnum|null $navigationGroup = 'Pages';

    protected static ?int $navigationSort = 52;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static ?string $title = 'Homepage — Why book with us';

    protected string $view = 'filament.pages.settings';

    public function mount(): void
    {
        $cards = HomepageWhyBookCard::query()
            ->orderBy('sort_order')
            ->get()
            ->map(function (HomepageWhyBookCard $card) {
                return [
                    'title' => $card->title,
                    'description' => $card->description ?? '',
                    'icon_path' => $card->icon_path,
                ];
            })
            ->all();

        $this->getSchema('form')->fill([
            'section_heading' => Setting::get('homepage_why_book_heading', 'Why thousands book with us.'),
            'cards' => $cards,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('form')
            ->components([
                Section::make('Section heading')
                    ->schema([
                        TextInput::make('section_heading')
                            ->label('Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Shown centered above the three cards on the homepage.'),
                    ]),
                Section::make('Cards')
                    ->description('Add cards, upload an icon image for each, and drag rows to change order. Shown below “Most Popular Tours” on the homepage.')
                    ->schema([
                        Repeater::make('cards')
                            ->label('Cards')
                            ->schema([
                                FileUpload::make('icon_path')
                                    ->label('Icon image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('homepage/why-book')
                                    ->visibility('public')
                                    ->imagePreviewHeight('64')
                                    ->maxSize(1024)
                                    ->helperText('Square PNG/SVG recommended (~48–96px).')
                                    ->columnSpanFull(),
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                RichEditor::make('description')
                                    ->label('Description')
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'link',
                                        'bulletList',
                                        'orderedList',
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->reorderable()
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add card')
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

        Setting::set('homepage_why_book_heading', $data['section_heading'] ?? '');

        $rows = $data['cards'] ?? [];

        DB::transaction(function () use ($rows): void {
            HomepageWhyBookCard::query()->delete();

            $order = 1;
            foreach ($rows as $row) {
                $title = trim((string) ($row['title'] ?? ''));
                if ($title === '') {
                    continue;
                }

                $iconPath = $row['icon_path'] ?? null;
                if (is_array($iconPath)) {
                    $iconPath = $iconPath[0] ?? null;
                }
                $iconPath = $iconPath ? (string) $iconPath : null;

                HomepageWhyBookCard::query()->create([
                    'sort_order' => $order++,
                    'title' => $title,
                    'description' => $row['description'] ?? null,
                    'icon_path' => $iconPath,
                ]);
            }
        });

        Notification::make()
            ->title('Why book section saved.')
            ->success()
            ->send();
    }
}
