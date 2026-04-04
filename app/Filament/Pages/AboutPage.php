<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
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

/**
 * @property-read Schema $form
 */
class AboutPage extends Page
{
    /** @var array<string, mixed> */
    public array $form = [];

    protected static ?string $slug = 'about-page';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static ?string $navigationLabel = 'About Us';

    protected static ?string $title = 'About Us Page';

    protected static string|\UnitEnum|null $navigationGroup = 'Pages';

    protected static ?int $navigationSort = 53;

    protected string $view = 'filament.pages.settings';

    public function mount(): void
    {
        $values = $this->decodeJsonSetting('page_about_values', []);
        if ($values === []) {
            $values = [
                ['icon' => 'fa-heart', 'title' => 'Honesty over hype', 'description' => "We'll tell you honestly which travel packages are worth it and which spots are overhyped."],
                ['icon' => 'fa-people-group', 'title' => 'Small groups, real connections', 'description' => "We keep groups small on purpose. You're not a ticket number."],
                ['icon' => 'fa-seedling', 'title' => 'Respect the places we visit', 'description' => 'We work with local families and support the communities that make Albania special.'],
            ];
        }

        $expectItems = $this->decodeJsonSetting('page_about_expect_items', []);
        if ($expectItems === []) {
            $expectItems = [
                ['title' => 'Guides who actually love this', 'description' => "Our guides aren't reading from a script. They're locals who are genuinely passionate."],
                ['title' => 'No surprise costs', 'description' => 'The price you see is the price you pay.'],
                ['title' => 'Flexibility when life happens', 'description' => 'Plans change, we get it. We make rescheduling as painless as possible.'],
                ['title' => 'A real person to talk to', 'description' => "Have a question? You'll reach a real person, not a chatbot."],
            ];
        }

        $stats = $this->decodeJsonSetting('page_about_stats', []);
        if ($stats === []) {
            $stats = [
                ['value' => '500+', 'label' => 'Travellers'],
                ['value' => '50+', 'label' => 'Tours'],
                ['value' => '12', 'label' => 'Destinations'],
                ['value' => '4.9', 'label' => 'Rating'],
            ];
        }

        $this->getSchema('form')->fill([
            'page_about_section_hero_enabled' => $this->boolSetting('page_about_section_hero_enabled', true),
            'page_about_hero_title' => Setting::get('page_about_hero_title', 'Our Story'),
            'page_about_hero_subtitle' => Setting::get('page_about_hero_subtitle', 'The people, the passion, and the places that make every journey unforgettable.'),
            'page_about_hero_image' => Setting::get('page_about_hero_image', ''),

            'page_about_section_intro_enabled' => $this->boolSetting('page_about_section_intro_enabled', true),
            'page_about_intro_label' => Setting::get('page_about_intro_label', 'Nice to meet you'),
            'page_about_intro_title' => Setting::get('page_about_intro_title', 'We started with a simple idea: share the Albania we love'),
            'page_about_intro_content' => Setting::get('page_about_intro_content', ''),
            'page_about_intro_image' => Setting::get('page_about_intro_image', ''),
            'page_about_intro_badge_title' => Setting::get('page_about_intro_badge_title', 'Since day one'),
            'page_about_intro_badge_subtitle' => Setting::get('page_about_intro_badge_subtitle', 'Passionate about Albania'),

            'page_about_section_mosaic_enabled' => $this->boolSetting('page_about_section_mosaic_enabled', true),
            'page_about_expect_image_1' => Setting::get('page_about_expect_image_1', ''),
            'page_about_expect_image_2' => Setting::get('page_about_expect_image_2', ''),
            'page_about_stats' => $stats,

            'page_about_section_values_enabled' => $this->boolSetting('page_about_section_values_enabled', true),
            'page_about_values_label' => Setting::get('page_about_values_label', 'What matters to us'),
            'page_about_values_title' => Setting::get('page_about_values_title', "We're not a big corporation. We're a small team that genuinely cares."),
            'page_about_values' => $values,

            'page_about_section_quote_enabled' => $this->boolSetting('page_about_section_quote_enabled', true),
            'page_about_quote_text' => Setting::get('page_about_quote_text', ''),
            'page_about_quote_image' => Setting::get('page_about_quote_image', ''),

            'page_about_section_expect_enabled' => $this->boolSetting('page_about_section_expect_enabled', false),
            'page_about_expect_label' => Setting::get('page_about_expect_label', 'What to expect'),
            'page_about_expect_title' => Setting::get('page_about_expect_title', "When you book with us, here's what you get"),
            'page_about_expect_intro' => Setting::get('page_about_expect_intro', 'Every journey with us is built on these simple promises. No fine print, no surprises — just a great experience from start to finish.'),
            'page_about_expect_items' => $expectItems,

            'page_about_section_cta_enabled' => $this->boolSetting('page_about_section_cta_enabled', true),
            'page_about_cta_title' => Setting::get('page_about_cta_title', 'Ready for your next adventure?'),
            'page_about_cta_text' => Setting::get('page_about_cta_text', 'Explore our hand-picked travel packages or tell us about your dream trip.'),
            'page_about_cta_primary_label' => Setting::get('page_about_cta_primary_label', 'Browse travel packages'),
            'page_about_cta_primary_url' => Setting::get('page_about_cta_primary_url', ''),
            'page_about_cta_secondary_label' => Setting::get('page_about_cta_secondary_label', 'Get in touch'),
            'page_about_cta_secondary_url' => Setting::get('page_about_cta_secondary_url', ''),

            'page_about_seo_title' => Setting::get('page_about_seo_title', ''),
            'page_about_seo_description' => Setting::get('page_about_seo_description', ''),
            'page_about_seo_og_image' => Setting::get('page_about_seo_og_image', ''),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('form')
            ->components([
                Section::make('Hero')
                    ->description('Top banner with background image.')
                    ->schema([
                        Toggle::make('page_about_section_hero_enabled')
                            ->label('Show this section on the public page')
                            ->default(true)
                            ->columnSpanFull(),
                        TextInput::make('page_about_hero_title')
                            ->label('Title')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('page_about_hero_subtitle')
                            ->label('Subtitle')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        FileUpload::make('page_about_hero_image')
                            ->label('Background image')
                            ->disk('public')
                            ->directory('pages/about')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('120')
                            ->maxSize(4096)
                            ->helperText('Leave empty to use a default stock image.'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Intro (text block)')
                    ->description('Eyebrow, headline, body copy, and optional badge.')
                    ->schema([
                        Toggle::make('page_about_section_intro_enabled')
                            ->label('Show this section on the public page')
                            ->default(true)
                            ->columnSpanFull(),
                        TextInput::make('page_about_intro_label')
                            ->label('Eyebrow / label')
                            ->maxLength(120),
                        TextInput::make('page_about_intro_title')
                            ->label('Headline')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('page_about_intro_content')
                            ->label('Body')
                            ->rows(8)
                            ->helperText('Separate paragraphs with a blank line.')
                            ->columnSpanFull(),
                        FileUpload::make('page_about_intro_image')
                            ->label('Side / mosaic large image')
                            ->disk('public')
                            ->directory('pages/about')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('120')
                            ->maxSize(4096),
                        TextInput::make('page_about_intro_badge_title')
                            ->label('Badge — main line')
                            ->maxLength(120),
                        TextInput::make('page_about_intro_badge_subtitle')
                            ->label('Badge — secondary line')
                            ->maxLength(120)
                            ->helperText('Shown next to the green dot when filled.'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Photo mosaic & stats')
                    ->description('Smaller gallery images and the dark stats strip.')
                    ->schema([
                        Toggle::make('page_about_section_mosaic_enabled')
                            ->label('Show this section on the public page')
                            ->default(true)
                            ->columnSpanFull(),
                        FileUpload::make('page_about_expect_image_1')
                            ->label('Mosaic image 1 (square tile)')
                            ->disk('public')
                            ->directory('pages/about')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('120')
                            ->maxSize(4096),
                        FileUpload::make('page_about_expect_image_2')
                            ->label('Mosaic image 2 (square tile)')
                            ->disk('public')
                            ->directory('pages/about')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('120')
                            ->maxSize(4096),
                        Repeater::make('page_about_stats')
                            ->label('Stats (dark bar)')
                            ->schema([
                                TextInput::make('value')
                                    ->label('Value')
                                    ->required()
                                    ->maxLength(40),
                                TextInput::make('label')
                                    ->label('Label')
                                    ->required()
                                    ->maxLength(80),
                            ])
                            ->columns(2)
                            ->reorderable()
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add stat')
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Values (three cards)')
                    ->schema([
                        Toggle::make('page_about_section_values_enabled')
                            ->label('Show this section on the public page')
                            ->default(true)
                            ->columnSpanFull(),
                        TextInput::make('page_about_values_label')
                            ->label('Eyebrow / label')
                            ->maxLength(120),
                        TextInput::make('page_about_values_title')
                            ->label('Section headline')
                            ->maxLength(500)
                            ->columnSpanFull(),
                        Repeater::make('page_about_values')
                            ->label('Cards')
                            ->schema([
                                TextInput::make('icon')
                                    ->label('Icon class')
                                    ->placeholder('fa-heart')
                                    ->helperText('Font Awesome name only, e.g. fa-heart, fa-people-group (fa-solid is added on the site).')
                                    ->maxLength(80)
                                    ->columnSpanFull(),
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Textarea::make('description')
                                    ->rows(3)
                                    ->maxLength(2000)
                                    ->columnSpanFull(),
                            ])
                            ->reorderable()
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add value')
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Quote block')
                    ->description('Optional pull quote over an image. Hidden on the site if quote text is empty.')
                    ->schema([
                        Toggle::make('page_about_section_quote_enabled')
                            ->label('Show this section when quote text is set')
                            ->default(true)
                            ->columnSpanFull(),
                        Textarea::make('page_about_quote_text')
                            ->label('Quote')
                            ->rows(4)
                            ->maxLength(2000)
                            ->columnSpanFull(),
                        FileUpload::make('page_about_quote_image')
                            ->label('Background image (optional)')
                            ->disk('public')
                            ->directory('pages/about')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('120')
                            ->maxSize(4096)
                            ->helperText('If empty, the hero background image is reused.'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('What to expect')
                    ->description('Numbered promise cards. Off by default; turn on to show on the public page.')
                    ->schema([
                        Toggle::make('page_about_section_expect_enabled')
                            ->label('Show this section on the public page')
                            ->default(false)
                            ->columnSpanFull(),
                        TextInput::make('page_about_expect_label')
                            ->label('Eyebrow / label')
                            ->maxLength(120),
                        TextInput::make('page_about_expect_title')
                            ->label('Headline')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('page_about_expect_intro')
                            ->label('Intro paragraph (right column)')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                        Repeater::make('page_about_expect_items')
                            ->label('Items')
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Textarea::make('description')
                                    ->rows(2)
                                    ->maxLength(2000)
                                    ->columnSpanFull(),
                            ])
                            ->reorderable()
                            ->reorderableWithDragAndDrop()
                            ->addActionLabel('Add item')
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Bottom CTA')
                    ->schema([
                        Toggle::make('page_about_section_cta_enabled')
                            ->label('Show this section on the public page')
                            ->default(true)
                            ->columnSpanFull(),
                        TextInput::make('page_about_cta_title')
                            ->label('Headline')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('page_about_cta_text')
                            ->label('Supporting text')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        TextInput::make('page_about_cta_primary_label')
                            ->label('Primary button label')
                            ->maxLength(120),
                        TextInput::make('page_about_cta_primary_url')
                            ->label('Primary button URL')
                            ->placeholder('/tours')
                            ->maxLength(2048),
                        TextInput::make('page_about_cta_secondary_label')
                            ->label('Secondary button label')
                            ->maxLength(120),
                        TextInput::make('page_about_cta_secondary_url')
                            ->label('Secondary button URL')
                            ->placeholder('/contact')
                            ->maxLength(2048),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('SEO')
                    ->schema([
                        TextInput::make('page_about_seo_title')
                            ->label('Meta title')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('page_about_seo_description')
                            ->label('Meta description')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        FileUpload::make('page_about_seo_og_image')
                            ->label('Open Graph image')
                            ->disk('public')
                            ->directory('pages/about')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('120')
                            ->maxSize(4096),
                    ])
                    ->columns(1)
                    ->collapsible(),
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
                                ->label('Save About page')
                                ->submit('save'),
                        ])->alignment(\Filament\Support\Enums\Alignment::Start),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->getSchema('form')->getState();

        $boolKeys = [
            'page_about_section_hero_enabled',
            'page_about_section_intro_enabled',
            'page_about_section_mosaic_enabled',
            'page_about_section_values_enabled',
            'page_about_section_quote_enabled',
            'page_about_section_expect_enabled',
            'page_about_section_cta_enabled',
        ];
        foreach ($boolKeys as $key) {
            Setting::set($key, ! empty($data[$key]) ? '1' : '0');
        }

        $fileKeys = [
            'page_about_hero_image',
            'page_about_intro_image',
            'page_about_expect_image_1',
            'page_about_expect_image_2',
            'page_about_quote_image',
            'page_about_seo_og_image',
        ];
        foreach ($fileKeys as $key) {
            Setting::set($key, $this->normalizeUpload($data[$key] ?? null));
        }

        $simpleStringKeys = [
            'page_about_hero_title',
            'page_about_hero_subtitle',
            'page_about_intro_label',
            'page_about_intro_title',
            'page_about_intro_content',
            'page_about_intro_badge_title',
            'page_about_intro_badge_subtitle',
            'page_about_values_label',
            'page_about_values_title',
            'page_about_quote_text',
            'page_about_expect_label',
            'page_about_expect_title',
            'page_about_expect_intro',
            'page_about_cta_title',
            'page_about_cta_text',
            'page_about_cta_primary_label',
            'page_about_cta_primary_url',
            'page_about_cta_secondary_label',
            'page_about_cta_secondary_url',
            'page_about_seo_title',
            'page_about_seo_description',
        ];
        foreach ($simpleStringKeys as $key) {
            Setting::set($key, (string) ($data[$key] ?? ''));
        }

        $values = $this->filterRepeaterRows($data['page_about_values'] ?? [], ['title']);
        Setting::set('page_about_values', json_encode(array_values($values)));

        $expectItems = $this->filterRepeaterRows($data['page_about_expect_items'] ?? [], ['title']);
        Setting::set('page_about_expect_items', json_encode(array_values($expectItems)));

        $stats = $this->filterRepeaterRows($data['page_about_stats'] ?? [], ['value', 'label']);
        Setting::set('page_about_stats', json_encode(array_values($stats)));

        Notification::make()
            ->title('About page saved.')
            ->success()
            ->send();
    }

    /**
     * @param  list<string>  $requiredKeys
     * @return list<array<string, mixed>>
     */
    private function filterRepeaterRows(array $rows, array $requiredKeys): array
    {
        $out = [];
        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }
            foreach ($requiredKeys as $req) {
                if (trim((string) ($row[$req] ?? '')) === '') {
                    continue 2;
                }
            }
            $out[] = $row;
        }

        return $out;
    }

    private function normalizeUpload(mixed $value): string
    {
        if (is_array($value)) {
            return (string) ($value[0] ?? '');
        }

        return $value ? (string) $value : '';
    }

    private function boolSetting(string $key, bool $default): bool
    {
        $v = Setting::get($key);
        if ($v === null || $v === '') {
            return $default;
        }

        return filter_var($v, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function decodeJsonSetting(string $key, array $fallback): array
    {
        $raw = Setting::get($key, '');
        if ($raw === null || $raw === '') {
            return $fallback;
        }
        if (is_array($raw)) {
            return $raw;
        }
        $decoded = json_decode((string) $raw, true);

        return is_array($decoded) ? $decoded : $fallback;
    }
}
