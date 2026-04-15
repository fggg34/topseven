<?php

namespace App\Filament\Pages;

use App\Filament\RestrictedPanelUser;
use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\URL;

/**
 * CMS for the public /faq page (hero, SEO, Q&A sections, CTA). Settings keys: page_faq_*.
 *
 * @property-read Schema $form
 */
class FaqPage extends Page
{
    /** @var array<string, mixed> */
    public array $form = [];

    protected static ?string $slug = 'faq-page';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static ?string $navigationLabel = 'FAQ page';

    protected static ?string $title = 'FAQ page';

    protected static string|\UnitEnum|null $navigationGroup = 'Pages';

    protected static ?int $navigationSort = 52;

    protected string $view = 'filament.pages.settings';

    public static function canAccess(): bool
    {
        if (RestrictedPanelUser::isCurrentUser()) {
            return false;
        }

        return parent::canAccess();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function defaultFaqSections(): array
    {
        return [
            [
                'category_label' => 'Enquiries & payments',
                'category_title' => 'How enquiries work',
                'items' => [
                    ['q' => 'How do I enquire about a travel package?', 'a' => 'Browse our travel packages, open the one you like, and submit the enquiry form with your dates, guest count, and message. Our team will contact you with availability and next steps.'],
                    ['q' => 'What payment methods do you accept?', 'a' => 'We accept all major credit and debit cards, as well as bank transfers. Payment is arranged after we confirm your trip details.'],
                ],
            ],
            [
                'category_label' => 'Cancellations & changes',
                'category_title' => 'Flexibility when you need it',
                'items' => [
                    ['q' => 'What is your cancellation policy?', 'a' => 'Most travel packages offer free cancellation up to 7 days before the departure date.'],
                ],
            ],
            [
                'category_label' => 'Tours & experiences',
                'category_title' => 'About our tours',
                'items' => [
                    ['q' => 'Are your tours guided?', 'a' => 'Most tours include professional local guides.'],
                ],
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function decodeSections(mixed $raw): array
    {
        if (is_array($raw)) {
            return $raw;
        }
        if (is_string($raw) && $raw !== '') {
            $decoded = json_decode($raw, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    public function mount(): void
    {
        abort_unless(static::canAccess(), 403);

        $sections = $this->decodeSections(Setting::get('page_faq_sections', ''));
        if ($sections === []) {
            $sections = $this->defaultFaqSections();
        }

        $this->getSchema('form')->fill([
            'page_faq_hero_title' => Setting::get('page_faq_hero_title', 'Frequently Asked Questions'),
            'page_faq_hero_subtitle' => Setting::get('page_faq_hero_subtitle', 'Everything you need to know'),
            'page_faq_hero_image' => Setting::get('page_faq_hero_image', ''),
            'sections' => $sections,
            'page_faq_cta_title' => Setting::get('page_faq_cta_title', 'Still have questions?'),
            'page_faq_cta_description' => Setting::get('page_faq_cta_description', "Can't find what you're looking for? Our team is happy to help."),
            'page_faq_cta_button_text' => Setting::get('page_faq_cta_button_text', 'Contact us'),
            'page_faq_cta_button_url' => Setting::get('page_faq_cta_button_url', ''),
            'page_faq_seo_title' => Setting::get('page_faq_seo_title', ''),
            'page_faq_seo_description' => Setting::get('page_faq_seo_description', ''),
            'page_faq_seo_og_image' => Setting::get('page_faq_seo_og_image', ''),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('form')
            ->components([
                Section::make('Hero')
                    ->description('Shown at the top of '.URL::to('/faq'))
                    ->schema([
                        TextInput::make('page_faq_hero_title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('page_faq_hero_subtitle')
                            ->label('Subtitle')
                            ->maxLength(500)
                            ->columnSpanFull(),
                        FileUpload::make('page_faq_hero_image')
                            ->label('Background image')
                            ->image()
                            ->disk('public')
                            ->directory('pages/faq')
                            ->visibility('public')
                            ->imagePreviewHeight('120')
                            ->maxSize(4096)
                            ->helperText('Optional. If empty, a default travel photo is used on the site.')
                            ->columnSpanFull(),
                    ]),
                Section::make('Questions & categories')
                    ->description('Add categories, then questions and answers inside each. Drag rows to reorder.')
                    ->schema([
                        Repeater::make('sections')
                            ->label('Categories')
                            ->schema([
                                TextInput::make('category_label')
                                    ->label('Eyebrow label')
                                    ->maxLength(120)
                                    ->placeholder('e.g. Enquiries & payments')
                                    ->columnSpanFull(),
                                TextInput::make('category_title')
                                    ->label('Section heading')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Repeater::make('items')
                                    ->label('Questions')
                                    ->schema([
                                        TextInput::make('q')
                                            ->label('Question')
                                            ->required()
                                            ->maxLength(500)
                                            ->columnSpanFull(),
                                        Textarea::make('a')
                                            ->label('Answer')
                                            ->rows(5)
                                            ->required()
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible()
                                    ->collapsed()
                                    ->reorderable()
                                    ->reorderableWithDragAndDrop()
                                    ->addActionLabel('Add question')
                                    ->defaultItems(0)
                                    ->columnSpanFull(),
                            ])
                            ->collapsible()
                            ->reorderable()
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add category')
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ]),
                Section::make('Bottom call-to-action')
                    ->schema([
                        TextInput::make('page_faq_cta_title')
                            ->label('Title')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('page_faq_cta_description')
                            ->label('Description')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('page_faq_cta_button_text')
                            ->label('Button label')
                            ->maxLength(120),
                        TextInput::make('page_faq_cta_button_url')
                            ->label('Button URL')
                            ->placeholder('/contact or https://…')
                            ->maxLength(500)
                            ->helperText('Leave empty to use the contact page.'),
                    ])
                    ->columns(2),
                Section::make('SEO')
                    ->collapsed()
                    ->schema([
                        TextInput::make('page_faq_seo_title')
                            ->label('Meta title')
                            ->maxLength(255)
                            ->helperText('Overrides the default “FAQ — site name” when set.')
                            ->columnSpanFull(),
                        Textarea::make('page_faq_seo_description')
                            ->label('Meta description')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        FileUpload::make('page_faq_seo_og_image')
                            ->label('Open Graph image')
                            ->image()
                            ->disk('public')
                            ->directory('pages/faq')
                            ->visibility('public')
                            ->imagePreviewHeight('80')
                            ->maxSize(2048)
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

    protected function normalizeUpload(mixed $value): string
    {
        if (is_array($value)) {
            $firstKey = array_key_first($value);
            $value = $firstKey !== null ? ($value[$firstKey] ?? '') : ($value[0] ?? '');
        }

        return is_string($value) ? trim($value) : '';
    }

    /**
     * @param  array<int, array<string, mixed>>  $sections
     * @return array<int, array<string, mixed>>
     */
    protected function sanitizeSections(array $sections): array
    {
        $out = [];
        foreach ($sections as $section) {
            if (! is_array($section)) {
                continue;
            }
            $label = trim((string) ($section['category_label'] ?? ''));
            $title = trim((string) ($section['category_title'] ?? ''));
            $itemsIn = $section['items'] ?? [];
            $itemsOut = [];
            if (is_array($itemsIn)) {
                foreach ($itemsIn as $item) {
                    if (! is_array($item)) {
                        continue;
                    }
                    $q = trim((string) ($item['q'] ?? ''));
                    $a = trim((string) ($item['a'] ?? ''));
                    if ($q === '' && $a === '') {
                        continue;
                    }
                    $itemsOut[] = ['q' => $q, 'a' => $a];
                }
            }
            if ($label === '' && $title === '' && $itemsOut === []) {
                continue;
            }
            $out[] = [
                'category_label' => $label,
                'category_title' => $title,
                'items' => $itemsOut,
            ];
        }

        return $out;
    }

    public function save(): void
    {
        $data = $this->getSchema('form')->getState();

        $sections = $this->sanitizeSections($data['sections'] ?? []);
        if ($sections === []) {
            $sections = $this->defaultFaqSections();
        }

        Setting::set('page_faq_hero_title', (string) ($data['page_faq_hero_title'] ?? ''));
        Setting::set('page_faq_hero_subtitle', (string) ($data['page_faq_hero_subtitle'] ?? ''));
        Setting::set('page_faq_hero_image', $this->normalizeUpload($data['page_faq_hero_image'] ?? ''));
        Setting::set('page_faq_sections', $sections);

        Setting::set('page_faq_cta_title', (string) ($data['page_faq_cta_title'] ?? ''));
        Setting::set('page_faq_cta_description', (string) ($data['page_faq_cta_description'] ?? ''));
        Setting::set('page_faq_cta_button_text', (string) ($data['page_faq_cta_button_text'] ?? ''));
        Setting::set('page_faq_cta_button_url', (string) ($data['page_faq_cta_button_url'] ?? ''));

        Setting::set('page_faq_seo_title', (string) ($data['page_faq_seo_title'] ?? ''));
        Setting::set('page_faq_seo_description', (string) ($data['page_faq_seo_description'] ?? ''));
        Setting::set('page_faq_seo_og_image', $this->normalizeUpload($data['page_faq_seo_og_image'] ?? ''));

        Notification::make()
            ->title('FAQ page saved.')
            ->success()
            ->send();
    }
}
