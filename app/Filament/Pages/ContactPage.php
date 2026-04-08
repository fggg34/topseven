<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
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

/**
 * @property-read Schema $form
 */
class ContactPage extends Page
{
    /** @var array<string, mixed> */
    public array $form = [];

    protected static ?string $slug = 'contact-page';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?string $navigationLabel = 'Contact';

    protected static ?string $title = 'Contact Page';

    protected static string|\UnitEnum|null $navigationGroup = 'Pages';

    protected static ?int $navigationSort = 54;

    protected string $view = 'filament.pages.settings';

    public function mount(): void
    {
        $this->getSchema('form')->fill([
            'page_contact_hero_title' => Setting::get('page_contact_hero_title', __('Get in touch')),
            'page_contact_hero_subtitle' => Setting::get('page_contact_hero_subtitle', __("We'd love to hear from you")),
            'page_contact_hero_image' => Setting::get('page_contact_hero_image', ''),
            'page_contact_hero_height' => Setting::get('page_contact_hero_height', '440'),
            'page_contact_breadcrumb_label' => Setting::get('page_contact_breadcrumb_label', ''),

            'page_contact_form_title' => Setting::get('page_contact_form_title', __('Send us a message')),
            'page_contact_form_description' => Setting::get('page_contact_form_description', __("Fill out the form below and we'll get back to you as soon as possible.")),

            'page_contact_sidebar_title' => Setting::get('page_contact_sidebar_title', __('Need quick help?')),
            'page_contact_sidebar_description' => Setting::get('page_contact_sidebar_description', __('Check our frequently asked questions for instant answers.')),
            'page_contact_sidebar_button_text' => Setting::get('page_contact_sidebar_button_text', __('Browse travel packages')),
            'page_contact_sidebar_button_url' => Setting::get('page_contact_sidebar_button_url', ''),

            'page_contact_seo_title' => Setting::get('page_contact_seo_title', ''),
            'page_contact_seo_description' => Setting::get('page_contact_seo_description', ''),
            'page_contact_seo_og_image' => Setting::get('page_contact_seo_og_image', ''),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('form')
            ->components([
                Section::make('Hero')
                    ->description('Top banner on /contact (background, headline, optional subtitle).')
                    ->schema([
                        TextInput::make('page_contact_hero_title')
                            ->label('Headline')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('page_contact_hero_subtitle')
                            ->label('Subtitle')
                            ->rows(2)
                            ->maxLength(500)
                            ->helperText('Shown under the headline when filled.')
                            ->columnSpanFull(),
                        FileUpload::make('page_contact_hero_image')
                            ->label('Background image')
                            ->disk('public')
                            ->directory('pages/contact')
                            ->visibility('public')
                            ->image()
                            ->imagePreviewHeight('120')
                            ->maxSize(4096)
                            ->helperText('Leave empty to use the default stock image.')
                            ->columnSpanFull(),
                        TextInput::make('page_contact_hero_height')
                            ->label('Banner height (px)')
                            ->numeric()
                            ->minValue(200)
                            ->maxValue(900)
                            ->default(440)
                            ->suffix('px'),
                        TextInput::make('page_contact_breadcrumb_label')
                            ->label('Breadcrumb — current page label')
                            ->maxLength(120)
                            ->placeholder(__('Contact'))
                            ->helperText('Last segment next to Home. Leave empty to use the translated “Contact”.'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Form block')
                    ->description('Heading and intro above the contact form.')
                    ->schema([
                        TextInput::make('page_contact_form_title')
                            ->label('Title')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('page_contact_form_description')
                            ->label('Description')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Sidebar CTA card')
                    ->description('The card with image overlay in the right column.')
                    ->schema([
                        TextInput::make('page_contact_sidebar_title')
                            ->label('Title')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('page_contact_sidebar_description')
                            ->label('Description')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        TextInput::make('page_contact_sidebar_button_text')
                            ->label('Button label')
                            ->maxLength(120),
                        TextInput::make('page_contact_sidebar_button_url')
                            ->label('Button URL')
                            ->placeholder('/tours')
                            ->maxLength(2048)
                            ->helperText('Leave empty on the site to default to the tours listing.'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('SEO')
                    ->schema([
                        TextInput::make('page_contact_seo_title')
                            ->label('Meta title')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('page_contact_seo_description')
                            ->label('Meta description')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        FileUpload::make('page_contact_seo_og_image')
                            ->label('Open Graph image')
                            ->disk('public')
                            ->directory('pages/contact')
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
                                ->label('Save Contact page')
                                ->submit('save'),
                        ])->alignment(\Filament\Support\Enums\Alignment::Start),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->getSchema('form')->getState();

        $fileKeys = [
            'page_contact_hero_image',
            'page_contact_seo_og_image',
        ];
        foreach ($fileKeys as $key) {
            Setting::set($key, $this->normalizeUpload($data[$key] ?? null));
        }

        $height = (int) ($data['page_contact_hero_height'] ?? 440);
        if ($height < 200) {
            $height = 200;
        }
        if ($height > 900) {
            $height = 900;
        }
        Setting::set('page_contact_hero_height', (string) $height);

        $simpleStringKeys = [
            'page_contact_hero_title',
            'page_contact_hero_subtitle',
            'page_contact_breadcrumb_label',
            'page_contact_form_title',
            'page_contact_form_description',
            'page_contact_sidebar_title',
            'page_contact_sidebar_description',
            'page_contact_sidebar_button_text',
            'page_contact_sidebar_button_url',
            'page_contact_seo_title',
            'page_contact_seo_description',
        ];
        foreach ($simpleStringKeys as $key) {
            Setting::set($key, (string) ($data[$key] ?? ''));
        }

        Notification::make()
            ->title('Contact page saved.')
            ->success()
            ->send();
    }

    private function normalizeUpload(mixed $value): string
    {
        if (is_array($value)) {
            return (string) ($value[0] ?? '');
        }

        return $value ? (string) $value : '';
    }
}
